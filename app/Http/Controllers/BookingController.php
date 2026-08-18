<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Maskapai;
use App\Models\Wilayah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Daftar seluruh e-ticket yang sudah diinput.
     */
    public function index(Request $request)
    {
        $bookings = Booking::when($request->q, function ($query) use ($request) {
            $query->where('pnr', 'like', "%{$request->q}%")
                ->orWhereHas('passengers', function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->q}%");
                });
        })
            ->withCount(['flights', 'passengers'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('bookings.index', compact('bookings'));
        return view('preview');
    }

    /**
     * Form input e-ticket baru.
     */
    public function create()
    {
        $maskapais = Maskapai::orderBy('name')->get();
        $wilayahs  = Wilayah::orderBy('city_name')->get();
        $booking   = null;

        $maskapaiOptions    = $this->buildMaskapaiOptions($maskapais);
        $wilayahOptions     = $this->buildWilayahOptions($wilayahs);
        $existingFlights    = old('flights', []);
        $existingPassengers = old('passengers', []);

        return view('bookings.form', compact(
            'maskapais',
            'wilayahs',
            'booking',
            'maskapaiOptions',
            'wilayahOptions',
            'existingFlights',
            'existingPassengers'
        ));
    }

    /**
     * Simpan e-ticket baru ke database.
     */
    public function store(Request $request)
    {
        $data = $this->validateBooking($request);

        DB::transaction(function () use ($data) {
            $booking = Booking::create($data);
            $this->syncFlightsAndPassengers($booking, $data);
        });

        return redirect()->route('bookings.index')->with('success', 'E-ticket berhasil disimpan.');
    }

    /**
     * Form edit e-ticket.
     */
    public function edit(Booking $booking)
    {
        $booking->load('flights', 'passengers');
        $maskapais = Maskapai::orderBy('name')->get();
        $wilayahs  = Wilayah::orderBy('city_name')->get();

        $maskapaiOptions = $this->buildMaskapaiOptions($maskapais);
        $wilayahOptions  = $this->buildWilayahOptions($wilayahs);

        $existingFlights = old('flights', $booking->flights->map(function ($f) {
            return [
                'maskapai_id'             => $f->maskapai_id,
                'flight_no'               => $f->flight_no,
                'departure_date'          => $f->departure_date->format('Y-m-d'),
                'origin_wilayah_id'       => $f->origin_wilayah_id,
                'destination_wilayah_id'  => $f->destination_wilayah_id,
                'dep_time'                => $f->dep_time,
                'arr_time'                => $f->arr_time,
                'subclass'                => $f->subclass,
            ];
        })->values()->toArray());

        $existingPassengers = old('passengers', $booking->passengers->map(function ($p) {
            return [
                'title'          => $p->title,
                'name'           => $p->name,
                'type'           => $p->type,
                'id_number'      => $p->id_number,
                'ticket_number'  => $p->ticket_number,
                'baggage'        => $p->baggage,
            ];
        })->values()->toArray());

        return view('bookings.form', compact(
            'booking',
            'maskapais',
            'wilayahs',
            'maskapaiOptions',
            'wilayahOptions',
            'existingFlights',
            'existingPassengers'
        ));
    }

    /**
     * Perbarui data e-ticket (flight & penumpang di-generate ulang).
     */
    public function update(Request $request, Booking $booking)
    {
        $data = $this->validateBooking($request);

        DB::transaction(function () use ($booking, $data) {
            $booking->update($data);
            $booking->flights()->delete();
            $booking->passengers()->delete();
            $this->syncFlightsAndPassengers($booking, $data);
        });

        return redirect()->route('bookings.index')->with('success', 'E-ticket berhasil diperbarui.');
    }

    /**
     * Hapus e-ticket.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return back()->with('success', 'E-ticket berhasil dihapus.');
    }

    /**
     * Tampilkan / unduh PDF e-ticket yang tersimpan.
     */
    public function pdf(Booking $booking)
    {
        $booking->load(['flights.maskapai', 'flights.origin', 'flights.destination', 'passengers']);

        $pdf = Pdf::loadView('bookings.pdf', compact('booking'))->setPaper('a4', 'portrait');

        $fileName = 'eticket-' . $booking->pnr . '.pdf';

        return $pdf->stream($fileName);
    }

    /**
     * Validasi form booking (dipakai store & update).
     */
    private function validateBooking(Request $request): array
    {
        return $request->validate([
            'agency_name'    => 'nullable|string|max:100',
            'agency_tagline' => 'nullable|string|max:150',
            'pnr'            => 'required|string|max:20',
            'issued_date'    => 'required|date',
            'currency'       => 'nullable|string|max:10',
            'total_fare'     => 'required|numeric|min:0',
            'fare_note'      => 'nullable|string|max:255',

            'flights'                            => 'required|array|min:1',
            'flights.*.maskapai_id'              => 'required|exists:maskapais,id',
            'flights.*.flight_no'                => 'required|string|max:20',
            'flights.*.departure_date'           => 'required|date',
            'flights.*.origin_wilayah_id'        => 'required|exists:wilayahs,id',
            'flights.*.destination_wilayah_id'   => 'required|exists:wilayahs,id|different:flights.*.origin_wilayah_id',
            'flights.*.dep_time'                 => 'required|string|max:10',
            'flights.*.arr_time'                 => 'required|string|max:10',
            'flights.*.subclass'                 => 'nullable|string|max:5',

            'passengers'                   => 'required|array|min:1',
            'passengers.*.title'           => 'required|string|max:10',
            'passengers.*.name'            => 'required|string|max:100',
            'passengers.*.type'            => 'required|string|max:20',
            'passengers.*.id_number'       => 'required|string|max:50',
            'passengers.*.ticket_number'   => 'required|string|max:50',
            'passengers.*.baggage'         => 'nullable|string|max:20',
        ]);
    }

    /**
     * Simpan baris flights & passengers terkait sebuah booking.
     */
    private function syncFlightsAndPassengers(Booking $booking, array $data): void
    {
        foreach ($data['flights'] as $flight) {
            $booking->flights()->create($flight);
        }

        foreach ($data['passengers'] as $passenger) {
            $booking->passengers()->create($passenger);
        }
    }

    /**
     * Susun daftar opsi maskapai (untuk dropdown di form), siap di-JSON-kan.
     */
    private function buildMaskapaiOptions($maskapais): array
    {
        $options = [];

        foreach ($maskapais as $m) {
            $options[] = [
                'id'    => $m->id,
                'label' => $m->name . ' (' . $m->code . ')',
            ];
        }

        return $options;
    }

    /**
     * Susun daftar opsi wilayah (untuk dropdown di form), siap di-JSON-kan.
     */
    private function buildWilayahOptions($wilayahs): array
    {
        $options = [];

        foreach ($wilayahs as $w) {
            $options[] = [
                'id'    => $w->id,
                'label' => $w->city_name . ' (' . $w->airport_code . ')',
            ];
        }

        return $options;
    }
}
