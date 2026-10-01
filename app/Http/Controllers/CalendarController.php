<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class CalendarController extends Controller
{
    private const UPCOMING_DAYS  = 7;   // jendela "penerbangan terdekat"
    private const UPCOMING_LIMIT = 4;   // jumlah kartu maksimal

    public function index()
    {
        return view('calendar.index', [
            'upcoming' => $this->upcomingFlights(),
        ]);
    }

    /**
     * Endpoint JSON untuk FullCalendar (dipanggil per rentang tampilan).
     */
    public function events(Request $request): JsonResponse
    {
        $request->validate([
            'start' => 'required|date',
            'end'   => 'required|date',
            'type'  => 'nullable|in:all,flight,hotel',
        ]);

        $start = Carbon::parse($request->start)->toDateString();
        $end   = Carbon::parse($request->end)->toDateString();
        $type  = $request->input('type', 'all');

        $events = collect();

        if (in_array($type, ['all', 'flight'])) {
            $events = $events->merge($this->flightEvents($start, $end));
        }

        if (in_array($type, ['all', 'hotel'])) {
            $events = $events->merge($this->hotelEvents($start, $end));
        }

        return response()->json($events->values());
    }

    /**
     * Penerbangan yang belum berangkat dalam UPCOMING_DAYS hari ke depan.
     */
    private function upcomingFlights(): Collection
    {
        $now   = now();
        $today = $now->copy()->startOfDay();

        return Flight::with(['booking.passengers', 'maskapai', 'origin', 'destination'])
            ->whereBetween('departure_date', [
                $today->toDateString(),
                $today->copy()->addDays(self::UPCOMING_DAYS)->toDateString(),
            ])
            ->orderBy('departure_date')
            ->orderBy('dep_time')
            ->get()
            ->map(function (Flight $f) {
                $meta = $this->flightMeta($f);

                return [
                    'flight'   => $f,
                    'meta'     => $meta,
                    // tanpa jam -> dianggap berlaku sampai akhir hari
                    'departAt' => $f->departure_date->copy()->setTimeFromTimeString($meta['dep'] ?? '23:59'),
                ];
            })
            ->filter(fn($x) => $x['departAt']->gte($now))
            ->take(self::UPCOMING_LIMIT)
            ->map(function ($x) use ($now, $today) {
                /** @var Flight $f */
                $f    = $x['flight'];
                $m    = $x['meta'];
                $days = (int) $today->diffInDays($f->departure_date->copy()->startOfDay());

                $detail = null;

                if ($days === 0) {
                    $level = 'today';
                    $label = 'Hari ini';
                    if ($m['dep']) {
                        $detail = 'Berangkat ' . $this->humanMinutes((int) $now->diffInMinutes($x['departAt'])) . ' lagi';
                    }
                } elseif ($days === 1) {
                    $level = 'tomorrow';
                    $label = 'Besok';
                } else {
                    $level = 'soon';
                    $label = $days . ' hari lagi';
                }

                return [
                    'id'        => $f->id,
                    'level'     => $level,
                    'label'     => $label,
                    'detail'    => $detail,
                    'time'      => $m['dep'],
                    'code'      => $m['code'],
                    'airline'   => $m['airline'],
                    'route'     => $m['route'],
                    'passenger' => $m['passenger'],
                    'pnr'       => $m['pnr'],
                    'date_iso'  => $f->departure_date->format('Y-m-d'),
                    'date_text' => $f->departure_date->translatedFormat('D, d M Y'),
                ];
            })
            ->values();
    }

    private function flightEvents(string $start, string $end)
    {
        return Flight::with(['booking.passengers', 'maskapai', 'origin', 'destination'])
            ->whereBetween('departure_date', [$start, $end])
            ->get()
            ->map(function (Flight $f) {
                $m       = $this->flightMeta($f);
                $booking = $f->booking;

                $date = $f->departure_date->format('Y-m-d');
                $dep  = $m['dep'];
                $arr  = $m['arr'];

                $eventStart = $dep ? "{$date}T{$dep}:00" : $date;
                $eventEnd   = ($dep && $arr && $arr > $dep) ? "{$date}T{$arr}:00" : null;

                return [
                    'id'            => 'flight-' . $f->id,
                    'title'         => trim($m['code'] . ' ' . $m['origin'] . '→' . $m['destination']),
                    'start'         => $eventStart,
                    'end'           => $eventEnd,
                    'allDay'        => $dep === null,
                    'classNames'    => ['ev-flight'],
                    'extendedProps' => [
                        'kind'     => 'Penerbangan',
                        'headline' => $m['route'],
                        'subline'  => trim($m['airline'] . '  ' . $m['code']),
                        'details'  => [
                            ['PNR', $m['pnr']],
                            ['Tanggal', $f->departure_date->translatedFormat('l, d M Y')],
                            ['Jam', $dep ? ($dep . ($arr ? ' - ' . $arr : '')) : 'Belum diisi'],
                            ['Penumpang', $m['passenger']],
                        ],
                        'url'     => $booking ? route('travel.bookings.pdf', $booking) : null,
                        'urlText' => 'Buka e-ticket',
                    ],
                ];
            });
    }

    private function hotelEvents(string $start, string $end)
    {
        return InvoiceItem::with('invoice')
            ->where('type', 'hotel')
            ->whereNotNull('checkin_date')
            ->whereDate('checkin_date', '<=', $end)
            ->where(function ($q) use ($start) {
                $q->whereDate('checkout_date', '>=', $start)
                    ->orWhere(function ($q2) use ($start) {
                        $q2->whereNull('checkout_date')->whereDate('checkin_date', '>=', $start);
                    });
            })
            ->get()
            ->map(function (InvoiceItem $h) {
                $checkin  = $h->checkin_date;
                $checkout = $h->checkout_date;

                // end FullCalendar eksklusif: tanggal checkout tidak diwarnai (hitungan malam menginap)
                $hasRange = $checkout && !$checkin->isSameDay($checkout);

                $invoiceUrl = ($h->invoice && Route::has('travel.invoices.show'))
                    ? route('travel.invoices.show', $h->invoice)
                    : null;

                return [
                    'id'            => 'hotel-' . $h->id,
                    'title'         => ($h->hotel_name ?? 'Hotel') . ' - ' . ($h->passenger_name ?? '-'),
                    'start'         => $checkin->format('Y-m-d'),
                    'end'           => $hasRange ? $checkout->format('Y-m-d') : null,
                    'allDay'        => true,
                    'classNames'    => ['ev-hotel'],
                    'extendedProps' => [
                        'kind'     => 'Hotel',
                        'headline' => $h->hotel_name ?? 'Hotel',
                        'subline'  => $h->hotel_location ?? '',
                        'details'  => [
                            ['Invoice', $h->invoice?->invoice_code ?? '-'],
                            ['Tamu', $h->passenger_name ?? '-'],
                            ['Check-in / out', $h->hotel_date_range_text],
                        ],
                        'url'     => $invoiceUrl,
                        'urlText' => 'Buka invoice',
                    ],
                ];
            });
    }

    /**
     * Data ringkas penerbangan yang dipakai bersama oleh event kalender & kartu terdekat.
     */
    private function flightMeta(Flight $f): array
    {
        $passengers = $f->booking?->passengers ?? collect();
        $first      = $passengers->first()?->name ?? '-';
        $count      = $passengers->count();

        $iata   = $f->maskapai?->code_iata ?? '';
        $number = $f->flight_no ?? '';
        $code   = ($iata && !str_starts_with(strtoupper($number), strtoupper($iata)))
            ? trim($iata . ' ' . $number)
            : $number;

        $origin      = $f->origin?->code_iata ?? '?';
        $destination = $f->destination?->code_iata ?? '?';

        return [
            'code'        => $code ?: '-',
            'airline'     => $f->maskapai?->name ?? '-',
            'origin'      => $origin,
            'destination' => $destination,
            'route'       => $origin . ' → ' . $destination,
            'dep'         => $f->dep_time ? substr($f->dep_time, 0, 5) : null,
            'arr'         => $f->arr_time ? substr($f->arr_time, 0, 5) : null,
            'passenger'   => $first . ($count > 1 ? ' +' . ($count - 1) . ' lainnya' : ''),
            'pnr'         => $f->booking?->pnr ?? '-',
        ];
    }

    private function humanMinutes(int $minutes): string
    {
        if ($minutes < 60) {
            return max($minutes, 1) . ' menit';
        }

        $h = intdiv($minutes, 60);
        $m = $minutes % 60;

        return $h . ' jam' . ($m ? ' ' . $m . ' menit' : '');
    }
}
