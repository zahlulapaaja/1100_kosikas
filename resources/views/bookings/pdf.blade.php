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
            padding: 28px 34px 0 34px;
        }

        table {
            border-collapse: collapse;
        }

        td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        /* ===== Brand palette =====
           Navy  #0F1D36  (primary / header bars)
           Gold  #C9A227  (accent / PNR, totals, dividers)
        */

        /* ===== Header ===== */
        .header-table {
            width: 100%;
        }

        .logo-img {
            width: 220px;
            height: auto;
        }

        .doc-title {
            font-size: 9px;
            font-weight: bold;
            color: #7a8699;
            text-align: right;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .pnr-pill {
            display: inline-block;
            background-color: #0F1D36;
            color: #C9A227;
            border-radius: 4px;
            padding: 7px 16px;
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .header-rule {
            border-bottom: 2px solid #C9A227;
            margin: 16px 0 12px 0;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 18px;
        }

        .meta-table td {
            font-size: 9.5px;
            color: #445266;
        }

        .meta-label {
            display: block;
            color: #9aa6b5;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 2px;
        }

        .meta-value {
            font-size: 11px;
            font-weight: bold;
            color: #0F1D36;
        }

        /* ===== Section title ===== */
        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #0F1D36;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 8px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #e2e8f0;
        }

        .section-title .count {
            float: right;
            color: #9aa6b5;
            font-weight: normal;
            text-transform: none;
            letter-spacing: 0;
        }

        /* ===== Flight segment card ===== */
        .segment-card {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .segment-head {
            background-color: #0F1D36;
            color: #ffffff;
            padding: 7px 12px;
            font-size: 9.5px;
            font-weight: bold;
        }

        .segment-head .segment-date {
            float: right;
            color: #C9A227;
            font-weight: bold;
        }

        .segment-body {
            padding: 12px;
        }

        .segment-body table {
            width: 100%;
        }

        .seg-info-col {
            width: 24%;
            border-right: 1px solid #eef1f5;
            padding-right: 10px;
        }

        .seg-pnr-label {
            font-size: 8px;
            color: #9aa6b5;
            text-transform: uppercase;
        }

        .seg-pnr-value {
            font-size: 10.5px;
            font-weight: bold;
            color: #0F1D36;
            margin-bottom: 7px;
        }

        .airline-badge {
            display: inline-block;
            width: 24px;
            height: 24px;
            background-color: #f6f9fc;
            border: 1px solid #e2e8f0;
            color: #0F1D36;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            font-size: 8.5px;
            font-weight: bold;
        }

        .airline-name {
            font-size: 9.5px;
            font-weight: bold;
            color: #23303f;
        }

        .flight-no {
            font-size: 9px;
            color: #7a8699;
        }

        .flight-class {
            display: inline-block;
            margin-top: 5px;
            font-size: 8px;
            font-weight: bold;
            color: #0F1D36;
            background-color: #f6f9fc;
            border: 1px solid #e2e8f0;
            padding: 2px 6px;
            border-radius: 3px;
        }

        .seg-route-col {
            width: 58%;
            padding: 0 14px;
        }

        .seg-code {
            font-size: 20px;
            font-weight: bold;
            color: #0F1D36;
        }

        .seg-airport {
            font-size: 8.5px;
            color: #7a8699;
        }

        .seg-datetime {
            font-size: 9.5px;
            color: #445266;
            margin-top: 8px;
        }

        .seg-datetime strong {
            font-size: 12px;
            color: #0F1D36;
        }

        .seg-arrow {
            text-align: center;
            font-size: 13px;
            color: #C9A227;
            padding-top: 2px;
        }

        .seg-duration {
            font-size: 7.5px;
            color: #9aa6b5;
        }

        .seg-transit-col {
            width: 18%;
            text-align: right;
        }

        .transit-badge {
            display: inline-block;
            background-color: #f6f9fc;
            color: #0F1D36;
            border: 1px solid #e2e8f0;
            font-size: 8px;
            font-weight: bold;
            padding: 4px 9px;
            border-radius: 10px;
        }

        /* ===== Passenger card ===== */
        .passenger-card {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 16px;
            overflow: hidden;
        }

        .ptable {
            width: 100%;
        }

        .ptable th {
            background-color: #0F1D36;
            color: #ffffff;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: .3px;
            text-align: left;
            padding: 7px 12px;
        }

        .ptable td {
            padding: 8px 12px;
            font-size: 10px;
            border-bottom: 1px solid #f0f3f7;
        }

        .ptable tr:last-child td {
            border-bottom: none;
        }

        .passenger-type-tag {
            font-size: 7.5px;
            color: #9aa6b5;
            text-transform: uppercase;
        }

        .facility-block {
            padding: 2px 12px 9px 12px;
            font-size: 8.5px;
            color: #62778e;
            background-color: #fbfcfe;
        }

        .facility-block .facility-title {
            font-weight: bold;
            color: #445266;
            margin-bottom: 3px;
            display: block;
        }

        .facility-row {
            padding: 1px 0;
        }

        /* ===== Fare box ===== */
        .fare-box {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 16px;
            overflow: hidden;
        }

        .fare-box table {
            width: 100%;
        }

        .fare-box td {
            padding: 9px 12px;
        }

        .fare-note-row td {
            font-size: 9px;
            color: #7a8699;
            border-bottom: 1px dashed #e2e8f0;
        }

        .fare-total-row td {
            font-size: 10.5px;
            font-weight: bold;
            color: #0F1D36;
            background-color: #fdf8ea;
        }

        .fare-total-row .fare-value {
            text-align: right;
            font-size: 15px;
            color: #a8801e;
        }

        /* ===== Notes ===== */
        .notes-box {
            border: 1px solid #e2e8f0;
            border-left: 3px solid #C9A227;
            background-color: #fbfcfe;
            border-radius: 4px;
            padding: 12px 14px;
            margin-bottom: 10px;
        }

        .notes-title {
            font-size: 9px;
            font-weight: bold;
            color: #0F1D36;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin: 0 0 7px 0;
        }

        .notes-cols {
            width: 100%;
        }

        .notes-cols td {
            width: 50%;
            vertical-align: top;
            padding-right: 14px;
        }

        .notes-subtitle {
            font-size: 8.5px;
            font-weight: bold;
            color: #445266;
            margin: 7px 0 3px 0;
        }

        .notes-box ul {
            margin: 0;
            padding-left: 12px;
        }

        .notes-box li {
            font-size: 8px;
            color: #7a8699;
            margin-bottom: 2px;
            line-height: 1.35;
        }

        .no-print-warning {
            font-size: 8px;
            color: #9aa6b5;
            text-align: center;
            margin: 4px 0 14px 0;
        }

        /* ===== Footer — fixed to the bottom of every page ===== */
        .footer-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #0F1D36;
            color: #c3cbd8;
            padding: 14px 34px;
        }

        .footer-bar table {
            width: 100%;
        }

        .footer-bar td {
            font-size: 8.5px;
        }

        .footer-company {
            color: #C9A227;
            font-size: 10.5px;
            font-weight: bold;
            margin: 0 0 3px 0;
            letter-spacing: .3px;
        }

        .footer-caption {
            color: #7c8aa0;
            font-size: 7.5px;
            margin-top: 6px;
        }
    </style>
</head>

<body>

    @php
        // Real logo file — drop your PNG/JPG/SVG at this path in the Laravel
        // project (public/images/logo-kosikas.png). Falls back to a plain
        // text wordmark automatically if it's not there yet, so the PDF
// never breaks while brand assets are still being set up.
$logoPath = public_path('images/logo-kosikas.png');
        $logoExists = file_exists($logoPath);
    @endphp

    {{-- Reserve space at the bottom for the fixed footer --}}
    <div class="page" style="padding-bottom: 80px;">

        {{-- Header --}}
        <table class="header-table">
            <tr>
                <td style="width:60%;">
                    @if ($logoExists)
                        <img src="{{ $logoPath }}" class="logo-img" style="width: 120px; height: auto;">
                    @else
                        <p style="font-size:20px; font-weight:bold; color:#0F1D36; margin:0;">
                            {{ strtoupper($booking->agency_name) }}
                        </p>
                        <p style="font-size:9px; color:#7a8699; margin:2px 0 0 0; text-transform:uppercase;">
                            {{ $booking->agency_tagline }}
                        </p>
                    @endif
                </td>
                <td style="width:40%; text-align:right;">
                    <p class="doc-title">Electronic Ticket Itinerary</p>
                    <span class="pnr-pill">{{ strtoupper($booking->pnr) }}</span>
                </td>
            </tr>
        </table>
        <div class="header-rule"></div>

        <table class="meta-table">
            <tr>
                <td style="width:34%;">
                    <span class="meta-label">Booking Reference (PNR)</span>
                    <span class="meta-value">{{ strtoupper($booking->pnr) }}</span>
                </td>
                <td style="width:33%;">
                    <span class="meta-label">Issued Date</span>
                    <span class="meta-value">{{ $booking->issued_date->translatedFormat('d M Y') }}</span>
                </td>
                <td style="width:33%; text-align:right;">
                    <span class="meta-label">Print Date</span>
                    <span class="meta-value">{{ now()->translatedFormat('d M Y, H:i') }}</span>
                </td>
            </tr>
        </table>

        {{-- Flight Details --}}
        <p class="section-title">Flight Detail(s) <span class="count">{{ $booking->flights->count() }}
                segment{{ $booking->flights->count() > 1 ? 's' : '' }}</span></p>

        @foreach ($booking->flights as $i => $flight)
            @php
                $durationLabel = null;
                try {
                    $dep = \Carbon\Carbon::parse($flight->dep_time);
                    $arr = \Carbon\Carbon::parse($flight->arr_time);
                    if ($arr->lessThan($dep)) {
                        $arr->addDay();
                    }
                    $diffH = $dep->diffInHours($arr);
                    $diffM = $dep->diffInMinutes($arr) % 60;
                    $durationLabel = sprintf('%dj %02dm', $diffH, $diffM);
                } catch (\Throwable $e) {
                    $durationLabel = null;
                }
            @endphp
            <div class="segment-card">
                <div class="segment-head">
                    Flight {{ $i + 1 }} &nbsp;&bull;&nbsp; {{ $flight->origin->city_name }} &rarr;
                    {{ $flight->destination->city_name }}
                    <span class="segment-date">{{ $flight->departure_date->translatedFormat('D, d M Y') }}</span>
                </div>
                <div class="segment-body">
                    <table>
                        <tr>
                            <td class="seg-info-col">
                                <span class="seg-pnr-label">Booking Ref.</span>
                                <div class="seg-pnr-value">{{ strtoupper($booking->pnr) }}</div>
                                <table>
                                    <tr>
                                        <td style="width:28px;">
                                            <span class="airline-badge">{{ $flight->maskapai->code }}</span>
                                        </td>
                                        <td style="padding-left:6px;">
                                            <div class="airline-name">{{ $flight->maskapai->name }}</div>
                                            <div class="flight-no">{{ $flight->maskapai->code }}
                                                {{ $flight->flight_no }}</div>
                                        </td>
                                    </tr>
                                </table>
                                @if ($flight->subclass)
                                    <span class="flight-class">Class {{ strtoupper($flight->subclass) }} &middot;
                                        Economy</span>
                                @endif
                            </td>
                            <td class="seg-route-col">
                                <table>
                                    <tr>
                                        <td style="width:38%;">
                                            <div class="seg-code">{{ $flight->origin->airport_code }}</div>
                                            <div class="seg-airport">{{ $flight->origin->city_name }}</div>
                                            <div class="seg-datetime">
                                                {{ $flight->departure_date->translatedFormat('d M Y') }}<br>
                                                <strong>{{ $flight->dep_time }}</strong>
                                            </div>
                                        </td>
                                        <td style="width:24%; text-align:center;" class="seg-arrow">
                                            &#10230;<br>
                                            @if ($durationLabel)
                                                <span class="seg-duration">{{ $durationLabel }}</span>
                                            @endif
                                        </td>
                                        <td style="width:38%; text-align:right;">
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
        <p class="section-title">Passenger Detail(s) <span class="count">{{ $booking->passengers->count() }}
                pax</span></p>
        <div class="passenger-card">
            <table class="ptable">
                <thead>
                    <tr>
                        <th style="width:6%;">No.</th>
                        <th style="width:36%;">Nama Penumpang</th>
                        <th style="width:20%;">No. Identitas</th>
                        <th style="width:24%;">No. Tiket</th>
                        <th style="width:14%;">Bagasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($booking->passengers as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <strong>{{ $p->title }} {{ $p->name }}</strong>
                                <span
                                    class="passenger-type-tag">&nbsp;({{ strtoupper(substr($p->type, 0, 3)) }})</span>
                            </td>
                            <td>{{ $p->id_number }}</td>
                            <td>{{ $p->ticket_number }}</td>
                            <td>{{ $p->baggage ?: '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="facility-block">
                <span class="facility-title">Baggage Allowance per Segment</span>
                @foreach ($booking->passengers as $p)
                    @foreach ($booking->flights as $flight)
                        <div class="facility-row">
                            {{ $p->title }} {{ $p->name }} &middot;
                            {{ $flight->origin->airport_code }}-{{ $flight->destination->airport_code }}
                            &nbsp;&#9992;&nbsp; {{ $p->baggage ?: 'Cabin only' }}
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>

        {{-- Grand Total --}}
        <p class="section-title">Fare Detail(s)</p>
        <div class="fare-box">
            <table>
                <tr class="fare-note-row">
                    <td style="width:70%;">
                        {{ $booking->fare_note ?: 'Includes Base Fare, Taxes, Fees and Surcharges' }}</td>
                    <td style="width:30%; text-align:right;">{{ $booking->passengers->count() }} pax</td>
                </tr>
                <tr class="fare-total-row">
                    <td style="width:70%;">Grand Total</td>
                    <td class="fare-value" style="width:30%;">{{ strtoupper($booking->currency) }}
                        {{ number_format($booking->total_fare, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        {{-- Important Notes --}}
        <div class="notes-box">
            <p class="notes-title">Important Notes / Catatan Penting</p>
            <table class="notes-cols">
                <tr>
                    <td>
                        <p class="notes-subtitle">Travel Document</p>
                        <ul>
                            <li>Bring valid ID / passport matching the passenger name.</li>
                            <li>Airline terms &amp; conditions apply at all times.</li>
                        </ul>
                        <p class="notes-subtitle">Refund &amp; Cancellation</p>
                        <ul>
                            <li>Est. processing: Domestic 1&ndash;2 mo, International 1&ndash;3 mo.</li>
                            <li>Refund claims valid up to 1 year from request date.</li>
                        </ul>
                    </td>
                    <td>
                        <p class="notes-subtitle">Dokumen Perjalanan</p>
                        <ul>
                            <li>Bawa KTP/paspor sesuai nama penumpang di tiket.</li>
                            <li>Syarat &amp; ketentuan maskapai berlaku setiap saat.</li>
                        </ul>
                        <p class="notes-subtitle">Reissue &amp; Reschedule</p>
                        <ul>
                            <li>Periksa kembali detail booking sebelum tiket terbit.</li>
                            <li>Perubahan setelah terbit dapat dikenakan biaya tambahan.</li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>

        <p class="no-print-warning">
            E-Ticket ini dibuat secara elektronik dan sah tanpa tanda tangan basah &mdash; simpan untuk keperluan
            check-in.
        </p>

    </div>

    {{-- Fixed footer, always anchored to the bottom of the page --}}
    <div class="footer-bar">
        <table>
            <tr>
                <td style="width:60%;">
                    <p class="footer-company">{{ strtoupper($booking->agency_name) }}</p>
                    <div>{{ $booking->agency_tagline }}</div>
                    <div class="footer-caption">Dokumen ini dicetak otomatis oleh sistem &mdash;
                        {{ now()->translatedFormat('d M Y, H:i') }} WIB.</div>
                </td>
                <td style="width:40%; text-align:right; vertical-align:middle;">
                    <span
                        style="color:#ffffff; font-weight:bold; letter-spacing:1px;">{{ strtoupper($booking->pnr) }}</span>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
