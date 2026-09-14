<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Daftar seluruh invoice yang sudah dibuat.
     */
    public function index(Request $request)
    {
        $invoices = Invoice::when($request->q, function ($query) use ($request) {
            $query->where('invoice_code', 'like', "%{$request->q}%")
                ->orWhere('orderer_name', 'like', "%{$request->q}%");
        })
            ->withCount(['flightItems', 'extraItems'])
            ->with('items')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Buat invoice baru dari booking-booking yang dicentang di index.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'booking_ids'   => 'required|array|min:1',
            'booking_ids.*' => 'exists:bookings,id',
        ]);

        $bookings = Booking::with(['flights.origin', 'flights.destination', 'flights.maskapai', 'passengers'])
            ->whereIn('id', $data['booking_ids'])
            ->orderByRaw('FIELD(id, ' . implode(',', $data['booking_ids']) . ')') // urut sesuai urutan dicentang
            ->get();

        $invoice = DB::transaction(function () use ($bookings) {
            $firstPassenger = $bookings->first()?->passengers->first();

            $invoice = Invoice::create([
                'issued_date'   => now(),
                'orderer_name'  => $firstPassenger->name ?? '-',
            ]);

            foreach ($bookings as $i => $booking) {
                $passengers = $booking->passengers;
                $passengerLabel = $passengers->first()->name ?? '-';
                if ($passengers->count() > 1) {
                    $passengerLabel .= ' +' . ($passengers->count() - 1) . ' lainnya';
                }

                $legs = $booking->flights->map(function ($f) {
                    return ($f->origin->code_iata ?? '') . '-' . ($f->destination->code_iata ?? '');
                })->implode(' / ');

                $dates = $booking->flights->pluck('departure_date')->unique()
                    ->map(fn($d) => $d->translatedFormat('d M Y'))->implode(' / ');

                $maskapaiNames = $booking->flights->pluck('maskapai.name')->filter()->unique()->implode(' / ');

                InvoiceItem::create([
                    'invoice_id'       => $invoice->id,
                    'booking_id'       => $booking->id,
                    'type'             => 'flight',
                    'passenger_name'   => $passengerLabel,
                    'maskapai_name'    => $maskapaiNames ?: '-',
                    'route_text'       => $legs ?: '-',
                    'flight_date_text' => $dates ?: '-',
                    'amount'           => $booking->total_fare,
                    'sort_order'       => $i,
                ]);
            }

            return $invoice;
        });

        return redirect()->route('travel.invoices.edit', $invoice)
            ->with('success', 'Invoice berhasil dibuat dari ' . $bookings->count() . ' booking. Silakan lengkapi biaya tambahan jika ada.');
    }

    /**
     * Form: tambah biaya tambahan, isi data bank & penandatangan.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load('items');

        $existingHotelsJson = json_encode(
            $invoice->hotelItems->map(fn($h) => [
                'guest_name'     => $h->passenger_name,
                'hotel_name'     => $h->hotel_name,
                'hotel_location' => $h->hotel_location,
                'checkin_date'   => optional($h->checkin_date)->format('Y-m-d'),
                'checkout_date'  => optional($h->checkout_date)->format('Y-m-d'),
                'amount'         => $h->amount,
            ])->values()
        );

        return view('invoices.form', compact('invoice', 'existingHotelsJson'));
    }

    /**
     * Simpan biaya tambahan + data pembayaran, buat kode invoice.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'orderer_address'      => 'nullable|string|max:150',
            'orderer_phone'        => 'nullable|string|max:30',
            'bank_name'            => 'nullable|string|max:100',
            'bank_account_number'  => 'nullable|string|max:50',
            'bank_account_holder'  => 'nullable|string|max:100',
            'signer_name'          => 'nullable|string|max:100',
            'notes'                => 'nullable|string|max:255',

            'extras'                 => 'nullable|array',
            'extras.*.label'         => 'required_with:extras|string|max:150',
            'extras.*.amount'        => 'required_with:extras|numeric', // boleh negatif

            'hotels'                   => 'nullable|array',
            'hotels.*.guest_name'      => 'required_with:hotels|string|max:100',
            'hotels.*.hotel_name'      => 'required_with:hotels|string|max:150',
            'hotels.*.hotel_location'  => 'nullable|string|max:150',
            'hotels.*.checkin_date'    => 'required_with:hotels|date',
            'hotels.*.checkout_date'   => 'nullable|date|after_or_equal:hotels.*.checkin_date',
            'hotels.*.amount'          => 'required_with:hotels|numeric',
        ]);

        DB::transaction(function () use ($invoice, $data) {
            $invoice->update([
                'orderer_address'     => $data['orderer_address'] ?? null,
                'orderer_phone'       => $data['orderer_phone'] ?? null,
                'bank_name'           => $data['bank_name'] ?? null,
                'bank_account_number' => $data['bank_account_number'] ?? null,
                'bank_account_holder' => $data['bank_account_holder'] ?? null,
                'signer_name'         => $data['signer_name'] ?? null,
                'notes'               => $data['notes'] ?? null,
            ]);

            // ganti seluruh item 'extra' dengan yang baru dikirim
            $invoice->extraItems()->delete();
            $invoice->hotelItems()->delete();

            $baseSort = $invoice->flightItems()->count();

            foreach (($data['hotels'] ?? []) as $i => $hotel) {
                InvoiceItem::create([
                    'invoice_id'      => $invoice->id,
                    'type'            => 'hotel',
                    'passenger_name'  => $hotel['guest_name'],
                    'hotel_name'      => $hotel['hotel_name'],
                    'hotel_location'  => $hotel['hotel_location'] ?? null,
                    'checkin_date'    => $hotel['checkin_date'],
                    'checkout_date'   => $hotel['checkout_date'] ?? $hotel['checkin_date'],
                    'amount'          => $hotel['amount'],
                    'sort_order'      => $baseSort + $i,
                ]);
            }

            $flightAndHotelCount = $baseSort + count($data['hotels'] ?? []);
            foreach (($data['extras'] ?? []) as $i => $extra) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'type'       => 'extra',
                    'label'      => $extra['label'],
                    'amount'     => $extra['amount'],
                    'sort_order' => $flightAndHotelCount + $i,
                ]);
            }

            if (!$invoice->invoice_code) {
                $invoice->update(['invoice_code' => $this->generateInvoiceCode($invoice)]);
            }
        });

        return redirect()->route('travel.invoices.show', $invoice)
            ->with('success', 'Invoice berhasil disimpan.');
    }

    /**
     * Tampilkan / unduh PDF invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('items');

        if (!$invoice->invoice_code) {
            $invoice->update(['invoice_code' => $this->generateInvoiceCode($invoice)]);
        }

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))->setPaper('a4', 'portrait');

        return $pdf->stream('invoice-' . $invoice->invoice_code . '.pdf');
    }

    /**
     * Hapus invoice beserta seluruh item-nya (cascade lewat foreign key).
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return back()->with('success', 'Invoice berhasil dihapus.');
    }

    /**
     * P + tanggal invoice (Ymd) + inisial nama pemesan.
     */
    private function generateInvoiceCode(Invoice $invoice): string
    {
        $date = $invoice->issued_date->format('Ymd');
        $initials = 'XX';

        if ($invoice->orderer_name && trim($invoice->orderer_name) !== '-') {
            $parts = preg_split('/\s+/', trim($invoice->orderer_name));
            $initials = mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr(end($parts), 0, 1));
        }

        // P = ada tiket pesawat, H = hotel-only (tanpa tiket sama sekali)
        $prefix = $invoice->flightItems()->exists() ? 'P' : 'H';

        return $prefix . $date . $initials;
    }

    /**
     * Buat invoice hotel baru (kosong, input manual — tanpa sumber booking).
     */
    public function createHotel(Request $request)
    {
        $data = $request->validate([
            'orderer_name' => 'required|string|max:100',
        ]);

        $invoice = Invoice::create([
            'issued_date'  => now(),
            'orderer_name' => $data['orderer_name'],
        ]);

        return redirect()->route('travel.invoices.edit', $invoice)
            ->with('success', 'Invoice hotel berhasil dibuat. Silakan lengkapi data hotel di bawah.');
    }
}
