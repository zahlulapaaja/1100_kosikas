<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ETicketController extends Controller
{
    /**
     * Tampilkan form input e-ticket.
     */
    public function index()
    {
        return view('eticket.index');
    }

    /**
     * Validasi input, render, dan tampilkan PDF e-ticket.
     */
    public function generate(Request $request)
    {
        $data = $request->validate([
            'agency_name'        => 'nullable|string|max:100',
            'agency_tagline'     => 'nullable|string|max:150',
            'pnr'                => 'required|string|max:20',
            'issued_date'        => 'required|date',
            'currency'           => 'nullable|string|max:10',
            'total_fare'         => 'required|numeric|min:0',
            'fare_note'          => 'nullable|string|max:255',

            'flights'                       => 'required|array|min:1',
            'flights.*.flight_no'           => 'required|string|max:20',
            'flights.*.airline'             => 'required|string|max:100',
            'flights.*.departure_date'      => 'required|date',
            'flights.*.origin_city'         => 'required|string|max:100',
            'flights.*.origin_code'         => 'required|string|max:5',
            'flights.*.dep_time'            => 'required|string|max:10',
            'flights.*.destination_city'    => 'required|string|max:100',
            'flights.*.destination_code'    => 'required|string|max:5',
            'flights.*.arr_time'            => 'required|string|max:10',
            'flights.*.subclass'            => 'nullable|string|max:5',

            'passengers'                    => 'required|array|min:1',
            'passengers.*.title'            => 'required|string|max:10',
            'passengers.*.name'             => 'required|string|max:100',
            'passengers.*.type'             => 'required|string|max:20',
            'passengers.*.id_number'        => 'required|string|max:50',
            'passengers.*.ticket_number'    => 'required|string|max:50',
            'passengers.*.baggage'          => 'nullable|string|max:20',
        ]);

        // Fallback default untuk identitas agen jika kosong
        $data['agency_name']    = $data['agency_name'] ?: 'TRAVEL AGENCY';
        $data['agency_tagline'] = $data['agency_tagline'] ?: 'Teman Setia Perjalanan Anda';
        $data['currency']       = $data['currency'] ?: 'IDR';

        $pdf = Pdf::loadView('eticket.pdf', ['data' => $data])
            ->setPaper('a4', 'portrait');

        $fileName = 'eticket-' . str($data['passengers'][0]['name'])->slug() . '.pdf';

        return $pdf->stream($fileName);
    }
}
