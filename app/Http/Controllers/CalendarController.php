<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\InvoiceItem;
use App\Support\FlightTime;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class CalendarController extends Controller
{
    private const UPCOMING_DAYS  = 7;   // jendela "penerbangan terdekat"
    private const UPCOMING_LIMIT = 4;   // jumlah kartu maksimal
    private const OFFICE_TZ      = 'Asia/Jakarta'; // acuan "hari ini" / "besok" (zona waktu kantor)

    /** cache waktu penerbangan per booking (satu request) */
    private array $legCache = [];

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
     * "Hari ini / besok" dihitung dengan tanggal WIB dari waktu keberangkatan absolut,
     * jadi penerbangan dari bandara beda zona tetap dihitung benar.
     */
    private function upcomingFlights(): Collection
    {
        $now   = now(self::OFFICE_TZ);
        $today = $now->copy()->startOfDay();

        return Flight::with($this->flightRelations())
            // tanggal lokal bandara bisa selisih +-1 hari dari WIB, jadi jendela query dilebarkan
            ->whereBetween('departure_date', [
                $today->copy()->subDay()->toDateString(),
                $today->copy()->addDays(self::UPCOMING_DAYS + 1)->toDateString(),
            ])
            ->get()
            ->map(function (Flight $f) {
                $meta = $this->flightMeta($f);
                $t    = $this->legFor($f);

                // tanpa jam -> dianggap berlaku sampai akhir hari
                if ($t['dep'] && $meta['dep']) {
                    $departAt = $t['dep'];
                } elseif ($t['dep']) {
                    $departAt = $t['dep']->copy()->setTime(23, 59);
                } else {
                    $departAt = $f->departure_date->copy()->setTimeFromTimeString($meta['dep'] ?? '23:59');
                }

                return ['flight' => $f, 'meta' => $meta, 't' => $t, 'departAt' => $departAt];
            })
            ->filter(function ($x) use ($now, $today) {
                if ($x['departAt']->lt($now)) {
                    return false;
                }
                $days = $this->daysFromToday($x['departAt'], $today);

                return $days >= 0 && $days <= self::UPCOMING_DAYS;
            })
            ->sortBy(fn($x) => $x['departAt']->timestamp)
            ->take(self::UPCOMING_LIMIT)
            ->map(function ($x) use ($now, $today) {
                /** @var Flight $f */
                $f    = $x['flight'];
                $m    = $x['meta'];
                $t    = $x['t'];
                $days = $this->daysFromToday($x['departAt'], $today);

                $detail = null;

                if ($days === 0) {
                    $level = 'today';
                    $label = 'Hari ini';
                    if ($m['dep']) {
                        $minutes = intdiv($x['departAt']->timestamp - $now->timestamp, 60);
                        $detail  = 'Berangkat ' . $this->humanMinutes($minutes) . ' lagi';
                    }
                } elseif ($days === 1) {
                    $level = 'tomorrow';
                    $label = 'Besok';
                } else {
                    $level = 'soon';
                    $label = $days . ' hari lagi';
                }

                // tanggal tampilan = tanggal lokal bandara asal (sama dengan e-ticket & posisi event di kalender)
                $depDate = $t['dep'] ?: $f->departure_date;

                return [
                    'id'        => $f->id,
                    'level'     => $level,
                    'label'     => $label,
                    'detail'    => $detail,
                    'time'      => $m['dep'],
                    'tz'        => $m['dep'] ? $t['dep_label'] : null,
                    'arrival'   => $this->arrivalText($t, $m),
                    'code'      => $m['code'],
                    'airline'   => $m['airline'],
                    'route'     => $m['route'],
                    'passenger' => $m['passenger'],
                    'pnr'       => $m['pnr'],
                    'date_iso'  => $depDate->format('Y-m-d'),
                    'date_text' => $depDate->translatedFormat('D, d M Y'),
                ];
            })
            ->values();
    }

    private function flightEvents(string $start, string $end)
    {
        // tanggal tersimpan bisa maju 1 hari setelah penyesuaian lewat tengah malam,
        // jadi query dimulai 1 hari lebih awal lalu difilter lagi berdasarkan tanggal tampil
        $from = Carbon::parse($start)->subDay()->toDateString();

        return Flight::with($this->flightRelations())
            ->whereBetween('departure_date', [$from, $end])
            ->get()
            ->map(function (Flight $f) {
                $m       = $this->flightMeta($f);
                $t       = $this->legFor($f);
                $booking = $f->booking;

                $dep = $m['dep'];
                $arr = $m['arr'];

                // jam event = jam lokal bandara asal, TANPA offset (kalender menampilkannya apa adanya)
                if ($t['dep'] && $dep) {
                    $eventStart = $t['dep']->format('Y-m-d\TH:i:s');
                    $eventEnd   = $t['arr'] ? $t['arr']->format('Y-m-d\TH:i:s') : null;
                    if ($eventEnd !== null && $eventEnd <= $eventStart) {
                        $eventEnd = null;
                    }
                } else {
                    $eventStart = ($t['dep'] ?: $f->departure_date)->format('Y-m-d');
                    $eventEnd   = null;
                }

                $depDate = $t['dep'] ?: $f->departure_date;

                $details = [
                    ['PNR', $m['pnr']],
                    ['Tanggal', $depDate->translatedFormat('l, d M Y')],
                    ['Berangkat', $dep ? $this->timeWithZone($dep, $t['dep_label']) : 'Jam belum diisi'],
                ];

                if ($arr) {
                    $arrText = $this->timeWithZone($arr, $t['arr_label']);
                    if ($t['arr']) {
                        $arrText .= ' · ' . $t['arr']->translatedFormat('D, d M Y');
                    }
                    $details[] = ['Tiba', $arrText];
                }

                if ($t['duration']) {
                    $details[] = ['Durasi terbang', $t['duration']];
                }

                $details[] = ['Penumpang', $m['passenger']];

                return [
                    'id'            => 'flight-' . $f->id,
                    'title'         => trim($m['code'] . ' ' . $m['origin'] . '→' . $m['destination']),
                    'start'         => $eventStart,
                    'end'           => $eventEnd,
                    'allDay'        => $dep === null,
                    'classNames'    => ['ev-flight'],
                    'extendedProps' => [
                        'kind'       => 'Penerbangan',
                        'headline'   => $m['route'],
                        'subline'    => trim($m['airline'] . '  ' . $m['code']),
                        'tz_abbr'    => $dep ? $t['dep_abbr'] : null,
                        'time_label' => $dep ? $this->timeWithZone($dep, $t['dep_label']) : null,
                        'details'    => $details,
                        'url'        => $booking ? route('travel.bookings.pdf', $booking) : null,
                        'urlText'    => 'Buka e-ticket',
                    ],
                ];
            })
            // buang yang tanggal tampilnya di luar rentang yang diminta kalender
            ->filter(function (array $e) use ($start, $end) {
                $date = substr($e['start'], 0, 10);

                return $date >= $start && $date <= $end;
            })
            ->values();
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
     * Relasi yang dimuat untuk penerbangan. booking.flights (+ origin/destination)
     * dibutuhkan supaya tanggal lewat tengah malam bisa dihitung per booking.
     */
    private function flightRelations(): array
    {
        return [
            'booking.passengers',
            'booking.flights.origin',
            'booking.flights.destination',
            'maskapai',
            'origin',
            'destination',
        ];
    }

    /**
     * Waktu berangkat/tiba (dengan zona waktu bandara) untuk satu penerbangan.
     * Dihitung per booking karena tanggal segmen lanjutan bergantung pada segmen sebelumnya.
     */
    private function legFor(Flight $f): array
    {
        $booking = $f->booking;

        if ($booking) {
            if (!isset($this->legCache[$booking->id])) {
                $flights = $booking->flights
                    ->sortBy(fn($x) => $x->departure_date->format('Y-m-d') . ' ' . ($x->dep_time ?: '00:00'))
                    ->values();

                $this->legCache[$booking->id] = FlightTime::legs($flights);
            }

            if (isset($this->legCache[$booking->id][$f->id])) {
                return $this->legCache[$booking->id][$f->id];
            }
        }

        return FlightTime::legs(collect([$f]))[$f->id];
    }

    /**
     * Selisih hari (tanggal WIB) antara waktu keberangkatan dan hari ini.
     */
    private function daysFromToday(Carbon $departAt, Carbon $today): int
    {
        $depDay = $departAt->copy()->setTimezone(self::OFFICE_TZ)->startOfDay();

        return intdiv($depDay->timestamp - $today->timestamp, 86400);
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

    /** "19:20 (MYT · UTC+8)" atau "19:20" kalau zona tidak diketahui */
    private function timeWithZone(string $time, ?string $label): string
    {
        return $label ? $time . ' (' . $label . ')' : $time;
    }

    /** "Tiba 21:40 AST · UTC+3" (+ tanggal kalau beda hari dengan keberangkatan) */
    private function arrivalText(array $t, array $m): ?string
    {
        if (!$m['arr']) {
            return null;
        }

        $text = 'Tiba ' . $m['arr'];

        if (!empty($t['arr_label'])) {
            $text .= ' ' . $t['arr_label'];
        }

        // tanggal lokal masing-masing bandara
        if ($t['arr'] && $t['dep'] && $t['arr']->format('Y-m-d') !== $t['dep']->format('Y-m-d')) {
            $text .= ' · ' . $t['arr']->translatedFormat('D, d M');
        }

        return $text;
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
