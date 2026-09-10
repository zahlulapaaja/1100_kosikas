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

        @php
            // Font loading, 3 tiers, most-reliable first:
            // 1. Self-hosted local file (public/fonts/) — fastest, zero external
            //    dependency, works even with isRemoteEnabled off.
            // 2. Online Google Font from Google's permanent GitHub archive —
            //    needs isRemoteEnabled true (set in the controller, see notes)
            //    AND the rendering server to have outbound internet access.
            // 3. DejaVu Sans — dompdf's bundled Unicode font, always available.
            $localFontRegular = public_path('fonts/Poppins-Regular.ttf');
            $localFontBold = public_path('fonts/Poppins-Bold.ttf');
            $localFontsAvailable = file_exists($localFontRegular) && file_exists($localFontBold);

            $remoteFontRegular = 'https://raw.githubusercontent.com/google/fonts/main/ofl/poppins/Poppins-Regular.ttf';
            $remoteFontBold = 'https://raw.githubusercontent.com/google/fonts/main/ofl/poppins/Poppins-Bold.ttf';

            $fontRegularSrc = str_replace('\\', '/', $localFontsAvailable ? $localFontRegular : $remoteFontRegular);
            $fontBoldSrc = str_replace('\\', '/', $localFontsAvailable ? $localFontBold : $remoteFontBold);

            // Icons — plain PNG files, NOT inline <svg>. dompdf does not render
            // inline <svg> markup reliably; <img> to a raster file is the
            // approach already proven to work in this document (logos).
            $iconPlane = public_path('images/icons/plane.png');
            $iconCabin = public_path('images/icons/cabin-bag.png');
            $iconChecked = public_path('images/icons/checked-bag.png');
            $iconInfo = public_path('images/icons/info.png');
        @endphp

        @font-face {
            font-family: 'Poppins';
            font-weight: normal;
            src: url('{{ $fontRegularSrc }}');
        }

        @font-face {
            font-family: 'Poppins';
            font-weight: bold;
            src: url('{{ $fontBoldSrc }}');
        }

        body {
            font-family: 'Poppins', 'DejaVu Sans', sans-serif;
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
            padding: 32px 40px 100px 40px;
        }

        /* ===== Palette — sampled directly from the Kosikas logo =====
           Blue    #2E75B6  primary accent
           Navy    #16324F  dark text / footer
           Orange  #E2502F  single deliberate highlight (PNR, price, checked-bag)
        */

        .top-bar {
            width: 100%;
            margin-bottom: 10px;
        }

        .eticket-pill {
            display: inline-block;
            background-color: #E2502F;
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            padding: 6px 14px;
            border-radius: 20px;
        }

        .booking-code-label {
            font-size: 11px;
            color: #5b6b80;
            margin-left: 8px;
        }

        .booking-code-value {
            font-size: 11px;
            font-weight: bold;
            color: #16324F;
            letter-spacing: .5px;
        }

        .top-bar-date {
            font-size: 9.5px;
            color: #9aa6b5;
            margin-top: 3px;
        }

        .logo-img {
            width: 125px;
            height: auto;
        }

        .top-rule {
            border-bottom: 1px solid #e5e8ee;
            margin: 14px 0 18px 0;
        }

        .pnr-highlight {
            background-color: #FDEEE8;
            border: 1px solid #f6d6c8;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .pnr-highlight table {
            width: 100%;
        }

        .pnr-highlight-label {
            font-size: 9px;
            color: #9a5138;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .pnr-highlight-value {
            font-size: 22px;
            font-weight: bold;
            color: #E2502F;
            letter-spacing: 2px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #16324F;
            margin: 22px 0 10px 0;
        }

        .section-title:first-of-type {
            margin-top: 0;
        }

        .section-sub {
            font-weight: normal;
            color: #7a8699;
        }

        .icon-inline {
            width: 13px;
            height: 13px;
            vertical-align: -2px;
            margin-right: 4px;
        }

        .segment-card {
            border: 1px solid #e5e8ee;
            border-radius: 8px;
            margin-bottom: 12px;
            overflow: hidden;
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
            color: #16324F;
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
            padding: 12px;
            text-align: center;
        }

        .airline-logo-circle {
            display: inline-block;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background-color: #ffffff;
            border: 1px solid #dfe6ee;
            text-align: center;
            line-height: 32px;
            overflow: hidden;
        }

        .airline-logo-img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
        }

        .airline-badge-text {
            display: inline-block;
            width: 34px;
            height: 34px;
            line-height: 34px;
            background-color: #2E75B6;
            color: #ffffff;
            border-radius: 50%;
            font-size: 10px;
            font-weight: bold;
        }

        .airline-name {
            font-size: 10px;
            font-weight: bold;
            color: #23303f;
            margin-top: 6px;
        }

        .flightno-label {
            font-size: 7.5px;
            color: #9aa6b5;
            text-transform: uppercase;
            letter-spacing: .3px;
            margin-top: 6px;
        }

        .flightno-value {
            font-size: 11px;
            font-weight: bold;
            color: #2E75B6;
        }

        .flightno-class {
            font-size: 8px;
            color: #7a8699;
            margin-top: 1px;
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
            padding: 8px 10px;
        }

        .ptable td {
            padding: 9px 10px;
            font-size: 10px;
            border-top: 1px solid #eef1f5;
        }

        .ptable .col-baggage {
            text-align: right;
            white-space: nowrap;
        }

        .passenger-name {
            font-weight: bold;
            color: #16324F;
        }

        .ptable-footnote {
            font-size: 8.5px;
            color: #9aa6b5;
            margin-top: 6px;
        }

        .notes-box {
            border: 1px solid #e5e8ee;
            border-left: 3px solid #E2502F;
            background-color: #fbfcfe;
            border-radius: 4px;
            padding: 12px 16px;
            margin-bottom: 6px;
        }

        .notes-box ul {
            margin: 0;
            padding-left: 0;
            list-style: none;
        }

        .notes-box li {
            font-size: 9.5px;
            color: #445266;
            margin-bottom: 7px;
            padding-left: 14px;
            position: relative;
            line-height: 1.5;
        }

        .notes-box li:last-child {
            margin-bottom: 0;
        }

        .notes-star {
            position: absolute;
            left: 0;
            color: #E2502F;
        }

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
            color: #E2502F;
            text-align: right;
        }

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
            line-height: 1.5;
        }

        .footer-company {
            font-size: 9.5px;
            font-weight: bold;
            color: #16324F;
            line-height: 1.2;
            margin-bottom: 0;
        }
 
        .footer-tagline {
            line-height: 1.2;
            margin-top: 0;
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
                    <span class="booking-code-label">Kode Booking</span>
                    <span class="booking-code-value">{{ strtoupper($booking->pnr) }}</span>
                    <div class="top-bar-date">
                        Diterbitkan {{ $booking->issued_date->translatedFormat('d M Y') }}
                        &nbsp;&middot;&nbsp; Dicetak {{ now()->translatedFormat('d M Y, H:i') }} WIB
                    </div>
                </td>
                <td style="width:40%; text-align:right;">
                    @if ($logoExists)
                        <img src="{{ $logoPath }}" class="logo-img">
                    @else
                        <strong style="font-size:14px; color:#16324F;">{{ strtoupper($booking->agency_name) }}</strong>
                    @endif
                </td>
            </tr>
        </table>
        <div class="top-rule"></div>

        {{-- PNR highlighted inside the content — kept bilingual since this is
             the one instruction a passenger really can't afford to miss. --}}
        <div class="pnr-highlight">
            <table>
                <tr>
                    <td>
                        <div class="pnr-highlight-label">Kode Booking (PNR)</div>
                        <div class="pnr-highlight-value">{{ strtoupper($booking->pnr) }}</div>
                    </td>
                    <td style="text-align:right; vertical-align:middle;">
                        <span style="font-size:9px; color:#9a5138;">
                            Tunjukkan kode ini saat check-in<br>Show this code at check-in
                        </span>
                    </td>
                </tr>
            </table>
        </div>

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
                    @if (file_exists($iconPlane))
                        <img src="{{ $iconPlane }}" class="icon-inline">
                    @endif
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
                            @if ($durationLabel)
                                <div style="margin-top:10px; font-size:9px; color:#7a8699;">
                                    Durasi terbang: <strong style="color:#16324F;">{{ $durationLabel }}</strong>
                                </div>
                            @endif
                        </td>
                        <td style="width:34%;">
                            <div class="airline-box">
                                <span class="airline-logo-circle">
                                    @if ($airlineLogoExists)
                                        <img src="{{ $airlineLogoPath }}" class="airline-logo-img">
                                    @else
                                        <span class="airline-badge-text">{{ strtoupper(substr($airlineCode ?: $flight->maskapai->name, 0, 2)) }}</span>
                                    @endif
                                </span>
                                <div class="airline-name">{{ $flight->maskapai->name }}</div>
                                <div class="flightno-label">No. Penerbangan</div>
                                <div class="flightno-value">{{ $airlineCode }} {{ $flight->flight_no }}</div>
                                <div class="flightno-class">{{ strtoupper($flight->subclass) ?: 'Y' }} &middot; Economy</div>
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

        {{-- Passenger Details — versi rombongan: bagasi digabung sebagai
             kolom paling ujung, bukan box terpisah per orang seperti versi
             perorangan (pdf.blade.php), supaya tetap ringkas untuk daftar
             penumpang yang panjang. --}}
        <p class="section-title">Detail Penumpang</p>
        <table class="ptable">
            <tr>
                <th style="width:6%;">No.</th>
                <th style="width:30%;">Nama</th>
                <th style="width:12%;">Tipe</th>
                <th style="width:24%;">No. Tiket</th>
                <th style="width:28%; text-align:right;">Bagasi Tercatat</th>
            </tr>
            @foreach ($booking->passengers as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="passenger-name">{{ strtoupper($p->title) }} {{ strtoupper($p->name) }}</td>
                    <td>{{ $p->type }}</td>
                    <td>{{ $p->ticket_number }}</td>
                    <td class="col-baggage">{{ $p->baggage ?: '-' }}</td>
                </tr>
            @endforeach
        </table>
        <div class="ptable-footnote">
            * Setiap penumpang mendapat bagasi kabin gratis 7 Kg / 1 tas. Bagasi tercatat sesuai kolom di atas.
        </div>

        {{-- Fare --}}
        <p class="section-title">Rincian Harga</p>
        <div class="fare-box">
            <table>
                <tr>
                    <td>
                        <div class="fare-label">Total Tarif</div>
                        <div class="fare-note">
                            {{ $booking->fare_note ?: 'Termasuk Tarif Dasar, Pajak & Biaya Lainnya' }}</div>
                    </td>
                    <td class="fare-value" style="width:35%;">
                        {{ strtoupper($booking->currency) }} {{ number_format($booking->total_fare, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>

    </div>

    {{-- Fixed footer --}}
    <div class="footer-bar">
        <table>
            <tr>
                <td style="width:60%;">
                     <div class="footer-company">{{ strtoupper($booking->agency_name) }}</div>
                    <div class="footer-tagline">{{ $booking->agency_tagline }}</div>
                    <div>{{ $booking->agency_address ?? 'Jl. Tgk. H. M Jl. Moh. Daud Beureuh No.50, Kuta Alam, Kec. Kuta Alam, Kota Banda Aceh, Aceh 23121' }}</div>
                </td>
                <td style="width:40%; text-align:right;">
                    <div>Email: {{ $booking->agency_email ?? 'kosikas.travel@gmail.com' }}</div>
                    <div>Telp/WA: {{ $booking->agency_phone ?? '0897-9846-945' }}</div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>