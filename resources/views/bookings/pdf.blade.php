<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>eTicket - {{ $booking->pnr }}</title>
    <style>
        @page {
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Helvetica", "Arial", sans-serif;
            font-size: 11px;
            color: #23303f;
            margin: 0;
        }

        .page {
            padding: 26px 32px 0 32px;
        }

        /* ===== Header ===== */
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
            padding: 0;
        }

        .logo-badge {
            display: inline-block;
            width: 34px;
            height: 34px;
            background-color: #1e88e5;
            border-radius: 50%;
            color: #ffffff;
            text-align: center;
            line-height: 34px;
            font-size: 15px;
            font-weight: bold;
        }

        .agency-name {
            font-size: 15px;
            font-weight: bold;
            color: #23303f;
            margin: 0;
            line-height: 1.2;
        }

        .agency-tagline {
            font-size: 9px;
            color: #7a8699;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .doc-title {
            font-size: 15px;
            color: #1e88e5;
            text-align: right;
            margin: 0 0 6px 0;
        }

        .pnr-pill {
            display: inline-block;
            background-color: #37475a;
            color: #ffffff;
            border-radius: 20px;
            padding: 6px 20px 6px 40px;
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 1px;
            position: relative;
        }

        .pnr-pill .plane-circle {
            position: absolute;
            left: -2px;
            top: -2px;
            width: 30px;
            height: 30px;
            background-color: #1e88e5;
            border-radius: 50%;
            color: #fff;
            text-align: center;
            line-height: 30px;
            font-size: 13px;
        }

        .header-rule {
            border-bottom: 1px solid #d7e0ea;
            margin: 14px 0;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .meta-table td {
            border: none;
            padding: 0;
            font-size: 10px;
            color: #445266;
            vertical-align: top;
        }

        .meta-table .meta-label {
            color: #7a8699;
        }

        /* ===== Section title ===== */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #23303f;
            margin: 0 0 10px 0;
        }

        /* ===== Flight segment card ===== */
        .segment-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 14px;
            overflow: hidden;
        }

        .segment-head {
            background-color: #1e88e5;
            color: #ffffff;
            padding: 7px 12px;
            font-size: 10.5px;
            font-weight: bold;
        }

        .segment-body {
            padding: 12px;
        }

        .segment-body table {
            width: 100%;
            border-collapse: collapse;
        }

        .segment-body td {
            border: none;
            vertical-align: middle;
            padding: 0;
        }

        .seg-info-col {
            width: 22%;
            border-right: 1px solid #eef1f5;
            padding-right: 10px !important;
        }

        .seg-pnr-label {
            font-size: 8.5px;
            color: #7a8699;
        }

        .seg-pnr-value {
            font-size: 10.5px;
            font-weight: bold;
            color: #23303f;
            margin-bottom: 6px;
        }

        .airline-badge {
            display: inline-block;
            width: 26px;
            height: 26px;
            background-color: #37475a;
            color: #fff;
            border-radius: 50%;
            text-align: center;
            line-height: 26px;
            font-size: 9.5px;
            font-weight: bold;
        }

        .airline-name {
            font-size: 9.5px;
            font-weight: bold;
            color: #23303f;
        }

        .flight-no {
            font-size: 9.5px;
            color: #445266;
        }

        .flight-class {
            font-size: 9px;
            color: #7a8699;
        }

        .seg-route-col {
            width: 60%;
            padding-left: 14px !important;
            padding-right: 14px !important;
        }

        .seg-code {
            font-size: 19px;
            font-weight: bold;
            color: #23303f;
        }

        .seg-airport {
            font-size: 9px;
            color: #7a8699;
        }

        .seg-datetime {
            font-size: 10px;
            color: #445266;
            margin-top: 6px;
        }

        .seg-datetime strong {
            font-size: 11.5px;
            color: #23303f;
        }

        .seg-arrow {
            text-align: center;
            font-size: 15px;
            color: #b9c4d1;
        }

        .seg-duration {
            font-size: 8px;
            color: #9aa6b5;
        }

        .seg-transit-col {
            width: 18%;
            text-align: right;
        }

        .transit-badge {
            display: inline-block;
            background-color: #eaf3ff;
            color: #1e88e5;
            font-size: 9px;
            font-weight: bold;
            padding: 4px 10px;
            border-radius: 10px;
        }

        /* ===== Passenger card ===== */
        .passenger-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 16px;
            overflow: hidden;
        }

        .passenger-card table.ptable {
            width: 100%;
            border-collapse: collapse;
        }

        .passenger-card .ptable th {
            background-color: #f6f9fc;
            color: #7a8699;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: .3px;
            text-align: left;
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        .passenger-card .ptable td {
            padding: 8px 12px;
            font-size: 10px;
            vertical-align: top;
            border-bottom: 1px solid #f0f3f7;
        }

        .facility-block {
            padding: 4px 12px 10px 12px;
            font-size: 9px;
            color: #62778e;
        }

        .facility-block .facility-title {
            font-weight: bold;
            color: #445266;
            margin-bottom: 3px;
            display: block;
        }

        .facility-row {
            padding: 2px 0;
        }

        /* ===== Fare box ===== */
        .fare-box {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 16px;
            overflow: hidden;
        }

        .fare-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .fare-box th {
            background-color: #f6f9fc;
            color: #7a8699;
            font-size: 8.5px;
            text-transform: uppercase;
            text-align: left;
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        .fare-box td {
            padding: 10px 12px;
            border: none;
        }

        .fare-total-row td {
            font-size: 12.5px;
            font-weight: bold;
            color: #23303f;
            border-top: 1px solid #e2e8f0;
        }

        .fare-total-row .fare-value {
            text-align: right;
            color: #1e88e5;
        }

        /* ===== Notes ===== */
        .notes-box {
            border: 1px solid #ffe3ab;
            background-color: #fffaf0;
            border-radius: 8px;
            padding: 12px 14px;
            margin-bottom: 6px;
        }

        .notes-title {
            font-size: 10.5px;
            font-weight: bold;
            color: #a56b00;
            margin: 0 0 6px 0;
        }

        .notes-subtitle {
            font-size: 9.5px;
            font-weight: bold;
            color: #445266;
            margin: 8px 0 3px 0;
        }

        .notes-box ul {
            margin: 0;
            padding-left: 14px;
        }

        .notes-box li {
            font-size: 9px;
            color: #62778e;
            margin-bottom: 2px;
        }

        .notes-divider {
            border-top: 1px dashed #e6d2a0;
            margin: 10px 0;
        }

        /* ===== Footer ===== */
        .footer-bar {
            background-color: #37475a;
            color: #d7e0ea;
            padding: 14px 32px;
            margin-top: 20px;
        }

        .footer-bar table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-bar td {
            border: none;
            vertical-align: top;
            padding: 0;
            font-size: 9px;
        }

        .footer-company {
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            margin: 0 0 4px 0;
        }

        .footer-caption {
            color: #9fb0c3;
            font-size: 8px;
            margin-top: 6px;
        }

        .no-print-warning {
            font-size: 9px;
            color: #62778e;
            text-align: center;
            margin: 10px 0 0 0;
        }
    </style>
</head>

<body>

    <div class="page">

        {{-- Header --}}
        <table class="header-table">
            <tr>
                <td style="width:55%;">
                    <table style="border-collapse:collapse;">
                        <tr>
                            <td style="border:none; width:38px; padding:0;"><span class="logo-badge">&#9992;</span></td>
                            <td style="border:none; padding:0 0 0 8px;">
                                <p class="agency-name">{{ strtoupper($booking->agency_name) }}</p>
                                <p class="agency-tagline">{{ $booking->agency_tagline }}</p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width:45%; text-align:right;">
                    <p class="doc-title">eTicket Itinerary</p>
                    <span class="pnr-pill">
                        <span class="plane-circle">&#9992;</span>{{ strtoupper($booking->pnr) }}
                    </span>
                </td>
            </tr>
        </table>
        <div class="header-rule"></div>

        <table class="meta-table">
            <tr>
                <td style="width:50%;">
                    <span class="meta-label">Booking Reference (PNR) :</span>
                    <strong>{{ strtoupper($booking->pnr) }}</strong>
                </td>
                <td style="width:50%; text-align:right;">
                    <span class="meta-label">Issued Date :</span> {{ $booking->issued_date->translatedFormat('d M Y') }}<br>
                    <span class="meta-label">Print Date :</span> {{ now()->translatedFormat('d M Y, H:i') }}
                </td>
            </tr>
        </table>

        {{-- Flight Details --}}
        <p class="section-title">Flight Detail(s)</p>

        @foreach ($booking->flights as $i => $flight)
        @php
        $durationLabel = null;
        try {
        $dep = \Carbon\Carbon::parse($flight->dep_time);
        $arr = \Carbon\Carbon::parse($flight->arr_time);
        if ($arr->lessThan($dep)) { $arr->addDay(); }
        $diffH = $dep->diffInHours($arr);
        $diffM = $dep->diffInMinutes($arr) % 60;
        $durationLabel = sprintf('%dj %02dm', $diffH, $diffM);
        } catch (\Throwable $e) {
        $durationLabel = null;
        }
        @endphp
        <div class="segment-card">
            <div class="segment-head">
                Flight {{ $i + 1 }}: {{ $flight->origin->city_name }} &rarr; {{ $flight->destination->city_name }}
                &nbsp;|&nbsp; {{ $flight->departure_date->translatedFormat('D, d M Y') }}
            </div>
            <div class="segment-body">
                <table>
                    <tr>
                        <td class="seg-info-col">
                            <div class="seg-pnr-label">PNR</div>
                            <div class="seg-pnr-value">{{ strtoupper($booking->pnr) }}</div>
                            <table style="border-collapse:collapse;">
                                <tr>
                                    <td style="border:none; padding:0; width:30px;">
                                        <span class="airline-badge">{{ $flight->maskapai->code }}</span>
                                    </td>
                                    <td style="border:none; padding:0 0 0 6px;">
                                        <div class="airline-name">{{ $flight->maskapai->name }}</div>
                                        <div class="flight-no">{{ $flight->maskapai->code }} - {{ $flight->flight_no }}</div>
                                    </td>
                                </tr>
                            </table>
                            @if($flight->subclass)
                            <div class="flight-class">{{ strtoupper($flight->subclass) }} - Economy</div>
                            @endif
                        </td>
                        <td class="seg-route-col">
                            <table style="border-collapse:collapse;">
                                <tr>
                                    <td style="border:none; padding:0; width:38%;">
                                        <div class="seg-code">{{ $flight->origin->airport_code }}</div>
                                        <div class="seg-airport">{{ $flight->origin->city_name }}</div>
                                        <div class="seg-datetime">
                                            {{ $flight->departure_date->translatedFormat('d M Y') }}<br>
                                            <strong>{{ $flight->dep_time }}</strong>
                                        </div>
                                    </td>
                                    <td style="border:none; padding:0; width:24%; text-align:center;" class="seg-arrow">
                                        &#9992;<br>
                                        @if($durationLabel)
                                        <span class="seg-duration">{{ $durationLabel }}</span>
                                        @endif
                                    </td>
                                    <td style="border:none; padding:0; width:38%; text-align:right;">
                                        <div class="seg-code">{{ $flight->destination->airport_code }}</div>
                                        <div class="seg-airport">{{ $flight->destination->city_name }}</div>
                                        <div class="seg-datetime">
                                            {{ $flight->departure_date->translatedFormat('d M Y') }}<br>
                                            <strong>{{ $flight->arr_time }}</strong>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="seg-transit-col">
                            <span class="transit-badge">Direct</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        @endforeach

        {{-- Passenger Details --}}
        <p class="section-title">Passenger Detail(s)</p>
        <div class="passenger-card">
            <table class="ptable">
                <thead>
                    <tr>
                        <th style="width:6%;">No.</th>
                        <th style="width:34%;">Nama Penumpang</th>
                        <th style="width:14%;">Tipe</th>
                        <th style="width:20%;">No. Identitas</th>
                        <th style="width:26%;">No. Tiket</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($booking->passengers as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $p->title }} {{ $p->name }}</strong> <span style="color:#9aa6b5;">({{ strtoupper(substr($p->type,0,3)) }})</span></td>
                        <td>{{ $p->type }}</td>
                        <td>{{ $p->id_number }}</td>
                        <td>{{ $p->ticket_number }}</td>
                    </tr>
                    @if($p->baggage || $booking->flights->count())
                    <tr>
                        <td style="border-bottom:1px solid #e2e8f0;"></td>
                        <td colspan="4" class="facility-block" style="border-bottom:1px solid #e2e8f0;">
                            <span class="facility-title">Facility(s):</span>
                            @foreach ($booking->flights as $flight)
                            <div class="facility-row">
                                {{ $flight->origin->airport_code }} - {{ $flight->destination->airport_code }}
                                &nbsp;&#127890;&nbsp; Baggage Allowance {{ $p->baggage ?: '-' }}
                            </div>
                            @endforeach
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Grand Total --}}
        <p class="section-title">Grand Total</p>
        <div class="fare-box">
            <table>
                <tr>
                    <th style="width:70%;">Keterangan</th>
                    <th style="width:30%; text-align:right;">Harga</th>
                </tr>
                <tr>
                    <td style="font-size:9.5px; color:#62778e;">
                        {{ $booking->fare_note ?: 'Includes Base Fare, Taxes, Fees and Surcharges' }}
                    </td>
                    <td style="text-align:right; font-size:10px;">
                        {{ strtoupper($booking->currency) }} {{ number_format($booking->total_fare, 0, ',', '.') }}
                    </td>
                </tr>
                <tr class="fare-total-row">
                    <td>Grand Total</td>
                    <td class="fare-value">{{ strtoupper($booking->currency) }} {{ number_format($booking->total_fare, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        {{-- Important Notes --}}
        <p class="section-title">Important Note(s)</p>
        <div class="notes-box">
            <p class="notes-title">&#128161; IMPORTANT NOTES</p>
            <ul>
                <li>Passenger must bring valid travel documents as required by the airline.</li>
                <li>Airline terms & conditions apply at all times.</li>
                <li>Schedule changes or cancellations are subject to the airline's policy.</li>
            </ul>
            <p class="notes-subtitle">Refund &amp; Cancellation</p>
            <ul>
                <li>Estimated refund processing time: Domestic 1&ndash;2 months, International 1&ndash;3 months.</li>
                <li>Refund claims are valid up to 1 year from the request date; after that they are forfeited.</li>
            </ul>
            <p class="notes-subtitle">Reissue &amp; Reschedule</p>
            <ul>
                <li>Please recheck all booking details before the ticket is issued.</li>
                <li>Any changes made after the ticket is issued may be subject to additional fees, based on the airline's current rules.</li>
            </ul>

            <div class="notes-divider"></div>

            <p class="notes-title">&#128161; CATATAN PENTING</p>
            <ul>
                <li>Penumpang wajib membawa dokumen perjalanan yang sah sesuai ketentuan maskapai.</li>
                <li>Syarat &amp; ketentuan maskapai berlaku setiap saat.</li>
                <li>Perubahan jadwal atau pembatalan mengikuti kebijakan maskapai terkait.</li>
            </ul>
            <p class="notes-subtitle">Pengembalian Dana &amp; Pembatalan</p>
            <ul>
                <li>Estimasi waktu proses refund: Domestik 1&ndash;2 bulan, Internasional 1&ndash;3 bulan.</li>
                <li>Klaim refund berlaku maksimal 1 tahun sejak tanggal pengajuan; lewat dari itu, klaim hangus.</li>
            </ul>
            <p class="notes-subtitle">Penerbitan &amp; Reschedule</p>
            <ul>
                <li>Mohon periksa kembali rincian pemesanan sebelum tiket diterbitkan.</li>
                <li>Perubahan setelah tiket terbit dapat dikenakan biaya tambahan sesuai kebijakan maskapai terbaru.</li>
            </ul>
        </div>

        <p class="no-print-warning">
            E-Ticket ini dibuat secara elektronik dan sah tanpa tanda tangan basah. Simpan dokumen ini untuk keperluan check-in.
        </p>

    </div>

    {{-- Footer --}}
    <div class="footer-bar">
        <table>
            <tr>
                <td style="width:60%;">
                    <p class="footer-company">{{ strtoupper($booking->agency_name) }}</p>
                    <div>{{ $booking->agency_tagline }}</div>
                    <div class="footer-caption">Dokumen ini dicetak otomatis oleh sistem &mdash; {{ now()->translatedFormat('d M Y, H:i') }} WIB.</div>
                </td>
                <td style="width:40%; text-align:right;">
                    Contact Customer Care<br>
                    <span style="color:#ffffff;">Booking Reference: {{ strtoupper($booking->pnr) }}</span>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>