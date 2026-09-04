<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>eTicket - {{ $booking->pnr }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        /* DejaVu Sans is dompdf's bundled Unicode font — using Helvetica/Arial
           here silently drops arrows, bullets and other symbols to "?". */
        body {
            font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif;
            font-size: 11px;
            color: #23303f;
            margin: 0;
        }

        table {
            border-collapse: collapse;
        }

        td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .page {
            padding: 32px 40px 90px 40px;
        }

        /* ===== Palette =====
           Blue    #1E5FA8  primary accent (cards, headings)
           Navy    #10233F  dark text / footer
           Orange  #E1521E  single deliberate highlight (pill, total, transit)
        */

        /* ===== Top bar ===== */
        .top-bar {
            width: 100%;
            margin-bottom: 10px;
        }

        .eticket-pill {
            display: inline-block;
            background-color: #E1521E;
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            padding: 6px 14px;
            border-radius: 20px;
        }

        .booking-code-label {
            font-size: 11px;
            color: #445266;
            margin-left: 8px;
        }

        .booking-code-value {
            font-size: 11px;
            font-weight: bold;
            color: #10233F;
            letter-spacing: .5px;
        }

        .top-bar-date {
            font-size: 9.5px;
            color: #9aa6b5;
            margin-top: 3px;
        }

        .logo-img {
            width: 160px;
            height: auto;
        }

        .top-rule {
            border-bottom: 1px solid #e5e8ee;
            margin: 14px 0 22px 0;
        }

        /* ===== Section title ===== */
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #10233F;
            margin: 24px 0 10px 0;
        }

        .section-title:first-of-type {
            margin-top: 0;
        }

        .section-sub {
            font-weight: normal;
            color: #7a8699;
        }

        /* ===== Flight card ===== */
        .segment-card {
            border: 1px solid #e5e8ee;
            border-radius: 8px;
            margin-bottom: 12px;
            overflow: hidden;
        }

        .segment-head {
            background-color: #1E5FA8;
            color: #ffffff;
            padding: 9px 14px;
            font-size: 10.5px;
            font-weight: bold;
        }

        .segment-head .segment-duration {
            float: right;
            font-weight: normal;
            color: #cfe0f3;
        }

        .segment-body {
            padding: 16px;
        }

        .segment-body table {
            width: 100%;
        }

        .leg-time {
            font-size: 19px;
            font-weight: bold;
            color: #10233F;
        }

        .leg-date {
            font-size: 8.5px;
            color: #9aa6b5;
        }

        .leg-place {
            font-size: 10.5px;
            font-weight: bold;
            color: #23303f;
            margin-top: 2px;
        }

        .leg-dot {
            color: #cfd6e0;
            font-size: 9px;
        }

        .leg-connector {
            padding-left: 6px;
        }

        .airline-box {
            background-color: #F2F6FB;
            border-radius: 6px;
            padding: 10px 12px;
            text-align: center;
        }

        .airline-logo-img {
            width: 26px;
            height: 26px;
        }

        .airline-badge {
            display: inline-block;
            width: 26px;
            height: 26px;
            background-color: #1E5FA8;
            color: #ffffff;
            border-radius: 50%;
            text-align: center;
            line-height: 26px;
            font-size: 9px;
            font-weight: bold;
        }

        .airline-name {
            font-size: 10px;
            font-weight: bold;
            color: #23303f;
            margin-top: 5px;
        }

        .airline-flightno {
            font-size: 8.5px;
            color: #7a8699;
        }

        .transit-banner {
            background-color: #FDF0E7;
            color: #B5471B;
            font-size: 9px;
            font-weight: bold;
            padding: 7px 14px;
            border-top: 1px solid #f6ddc9;
            border-bottom: 1px solid #f6ddc9;
        }

        .transit-banner .transit-duration {
            float: right;
            font-weight: normal;
            color: #c1703f;
        }

        /* ===== Passenger table ===== */
        .ptable {
            width: 100%;
            border: 1px solid #e5e8ee;
            border-radius: 6px;
        }

        .ptable th {
            background-color: #F2F6FB;
            color: #5b6b80;
            font-size: 9px;
            text-align: left;
            padding: 8px 12px;
        }

        .ptable td {
            padding: 9px 12px;
            font-size: 10.5px;
            border-top: 1px solid #eef1f5;
        }

        .passenger-name {
            font-weight: bold;
            color: #10233F;
        }

        /* ===== Baggage box ===== */
        .baggage-box {
            border: 1px solid #e5e8ee;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .baggage-head {
            background-color: #F2F6FB;
            padding: 8px 12px;
        }

        .baggage-head .bname {
            font-size: 10px;
            font-weight: bold;
            color: #10233F;
        }

        .baggage-head .btype {
            float: right;
            font-size: 8.5px;
            color: #7a8699;
        }

        .baggage-row {
            padding: 10px 12px;
        }

        .baggage-label {
            font-size: 8.5px;
            color: #9aa6b5;
        }

        .baggage-value {
            font-size: 11px;
            font-weight: bold;
            color: #23303f;
        }

        .baggage-note {
            font-size: 8px;
            color: #9aa6b5;
            margin-top: 2px;
        }

        /* ===== Fare ===== */
        .fare-box {
            border: 1px solid #e5e8ee;
            border-radius: 6px;
            padding: 14px 16px;
        }

        .fare-box table {
            width: 100%;
        }

        .fare-label {
            font-size: 11px;
            color: #445266;
        }

        .fare-note {
            font-size: 8.5px;
            color: #9aa6b5;
        }

        .fare-value {
            font-size: 19px;
            font-weight: bold;
            color: #E1521E;
            text-align: right;
        }

        .note-line {
            font-size: 8.5px;
            color: #9aa6b5;
            text-align: center;
            margin-top: 24px;
        }

        /* ===== Footer ===== */
        .footer-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 12px 40px;
            border-top: 1px solid #e5e8ee;
        }

        .footer-bar table {
            width: 100%;
        }

        .footer-bar td {
            font-size: 8.5px;
            color: #7a8699;
        }

        .footer-company {
            font-size: 9.5px;
            font-weight: bold;
            color: #10233F;
        }

        .footer-contact {
            margin-top: 3px;
        }
    </style>
</head>

<body>

    @php
        $logoPath = public_path('images/logo-kosikas.png');
        $logoExists = file_exists($logoPath);
    @endphp

    <div class="page">

        {{-- Top bar: booking code top-left, logo top-right --}}
        <table class="top-bar">
            <tr>
                <td style="width:60%;">
                    <span class="eticket-pill">E-TICKET</span>
                    <span class="booking-code-label">Booking Code</span>
                    <span class="booking-code-value">{{ strtoupper($booking->pnr) }}</span>
                    <div class="top-bar-date">
                        Issued {{ $booking->issued_date->translatedFormat('d M Y') }}
                        &nbsp;&middot;&nbsp; Dicetak {{ now()->translatedFormat('d M Y, H:i') }} WIB
                    </div>
                </td>
                <td style="width:40%; text-align:right;">
                    @if ($logoExists)
                        <img src="{{ $logoPath }}" class="logo-img">
                    @else
                        <strong style="font-size:15px; color:#10233F;">{{ strtoupper($booking->agency_name) }}</strong>
                    @endif
                </td>
            </tr>
        </table>
        <div class="top-rule"></div>

        {{-- Flight Details --}}
        @php
            $flightCount = $booking->flights->count();
            $prevConnecting = false;
        @endphp

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

                // Detect a same-airport connection to the next flight (true layover, not a
                // separate return leg days later), to show a transit banner instead of a new card.
                $nextFlight = $booking->flights->get($i + 1);
                $isConnecting = false;
                $layoverLabel = null;
                if ($nextFlight && $nextFlight->origin_wilayah_id === $flight->destination_wilayah_id) {
                    try {
                        $arrHere = \Carbon\Carbon::parse(
                            $flight->departure_date->format('Y-m-d') . ' ' . $flight->arr_time,
                        );
                        $depNext = \Carbon\Carbon::parse(
                            $nextFlight->departure_date->format('Y-m-d') . ' ' . $nextFlight->dep_time,
                        );
                        if ($depNext->lessThan($arrHere)) {
                            $depNext->addDay();
                        }
                        $layoverHours = $arrHere->diffInHours($depNext);
                        if ($layoverHours <= 12) {
                            $isConnecting = true;
                            $lm = $arrHere->diffInMinutes($depNext) % 60;
                            $layoverLabel = sprintf('%dj %02dm', $layoverHours, $lm);
                        }
                    } catch (\Throwable $e) {
                        $isConnecting = false;
                    }
                }

                $isNewCard = $i === 0 || !$prevConnecting;

                $airlineCode = $flight->maskapai->code_iata ?? '';

                // Prefer the actual uploaded logo (any extension, stored in maskapai->logo).
                // Fall back to guessing a .png at the old naming convention for maskapai
                // rows that haven't been re-saved through the upload form yet.
if (!empty($flight->maskapai->logo) && file_exists(public_path($flight->maskapai->logo))) {
    $airlineLogoPath = public_path($flight->maskapai->logo);
    $airlineLogoExists = true;
} else {
    $airlineLogoPath = $airlineCode ? public_path('images/airlines/' . $airlineCode . '.png') : null;
    $airlineLogoExists = $airlineLogoPath && file_exists($airlineLogoPath);
}

$originCode = $flight->origin->code_iata ?? '';
$destCode = $flight->destination->code_iata ?? '';
            @endphp

            @if ($isNewCard)
                <p class="section-title">
                    {{ $flightCount > 1 ? 'Penerbangan ' . ($i + 1) : 'Detail Penerbangan' }}
                    <span class="section-sub">&middot; {{ $flight->origin->city_name }} &rarr;
                        {{ $flight->destination->city_name }}</span>
                </p>
                <div class="segment-card">
            @endif

            <div class="segment-body" style="{{ !$isNewCard ? 'padding-top:0;' : '' }}">
                <table>
                    <tr>
                        <td style="width:66%;">
                            <table>
                                <tr>
                                    <td style="width:16%;">
                                        <div class="leg-time">{{ $flight->dep_time }}</div>
                                        <div class="leg-date">
                                            {{ $flight->departure_date->translatedFormat('D, d M Y') }}</div>
                                    </td>
                                    <td style="width:2%; text-align:center;"><span class="leg-dot">&bull;</span></td>
                                    <td class="leg-connector">
                                        <div class="leg-place">{{ $flight->origin->city_name }} - {{ $originCode }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table style="margin-top:12px;">
                                <tr>
                                    <td style="width:16%;">
                                        <div class="leg-time">{{ $flight->arr_time }}</div>
                                        <div class="leg-date">
                                            {{ $flight->departure_date->translatedFormat('D, d M Y') }}</div>
                                    </td>
                                    <td style="width:2%; text-align:center;"><span class="leg-dot">&bull;</span></td>
                                    <td class="leg-connector">
                                        <div class="leg-place">{{ $flight->destination->city_name }} -
                                            {{ $destCode }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:34%;">
                            <div class="airline-box">
                                @if ($airlineLogoExists)
                                    <img src="{{ $airlineLogoPath }}" class="airline-logo-img">
                                @else
                                    <span
                                        class="airline-badge">{{ strtoupper(substr($airlineCode ?: $flight->maskapai->name, 0, 2)) }}</span>
                                @endif
                                <div class="airline-name">{{ $flight->maskapai->name }}</div>
                                <div class="airline-flightno">{{ $airlineCode }} {{ $flight->flight_no }} &middot;
                                    {{ strtoupper($flight->subclass) ?: 'Y' }} Economy</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            @if ($isConnecting)
                <div class="transit-banner">
                    Transit di {{ $flight->destination->city_name }}
                    @if ($layoverLabel)
                        <span class="transit-duration">{{ $layoverLabel }}</span>
                    @endif
                </div>
            @else
    </div> {{-- close .segment-card --}}
    @endif

    @php $prevConnecting = $isConnecting; @endphp
    @endforeach

    {{-- Passenger Details --}}
    <p class="section-title">Detail Penumpang</p>
    <table class="ptable">
        <tr>
            <th style="width:8%;">No.</th>
            <th style="width:42%;">Nama</th>
            <th style="width:20%;">Tipe</th>
            <th style="width:30%;">No. Tiket</th>
        </tr>
        @foreach ($booking->passengers as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="passenger-name">{{ $p->title }} {{ $p->name }}</td>
                <td>{{ $p->type }}</td>
                <td>{{ $p->ticket_number }}</td>
            </tr>
        @endforeach
    </table>

    {{-- Baggage --}}
    <p class="section-title">Bagasi</p>
    @foreach ($booking->passengers as $p)
        <div class="baggage-box">
            <div class="baggage-head">
                <span class="bname">{{ $p->title }} {{ $p->name }}</span>
                <span class="btype">{{ $p->type }}</span>
            </div>
            <div class="baggage-row">
                <div class="baggage-label">Alokasi Bagasi</div>
                <div class="baggage-value">{{ $p->baggage ?: 'Cabin baggage only' }}</div>
                @if ($flightCount > 1)
                    <div class="baggage-note">Berlaku untuk seluruh segmen penerbangan pada booking ini</div>
                @endif
            </div>
        </div>
    @endforeach

    {{-- Fare --}}
    <p class="section-title">Rincian Harga</p>
    <div class="fare-box">
        <table>
            <tr>
                <td>
                    <div class="fare-label">Total Fare</div>
                    <div class="fare-note">
                        {{ $booking->fare_note ?: 'Includes Base Fare, Taxes, Fees and Surcharges' }}</div>
                </td>
                <td class="fare-value" style="width:35%;">
                    {{ strtoupper($booking->currency) }} {{ number_format($booking->total_fare, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <p class="note-line">
        E-Ticket ini dibuat secara elektronik dan sah tanpa tanda tangan basah &mdash; simpan untuk keperluan check-in.
    </p>

    </div>

    {{-- Fixed footer --}}
    <div class="footer-bar">
        <table>
            <tr>
                <td style="width:60%;">
                    <div class="footer-company">{{ strtoupper($booking->agency_name) }}</div>
                    <div>{{ $booking->agency_tagline }}</div>
                </td>
                <td style="width:40%; text-align:right;">
                    <div>Email: {{ $booking->agency_email ?? '-' }}</div>
                    <div class="footer-contact">Telp/WA: {{ $booking->agency_phone ?? '-' }}</div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
