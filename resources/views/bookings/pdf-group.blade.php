<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>eTicket - {{ $booking->pnr }}</title>
    <style>
        /* margin bawah 76px = ruang footer, supaya konten halaman 2+ tidak menimpa footer */
        @page {
            size: A4;
            margin: 32px 0 76px 0;
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
            padding: 0 40px;
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
            margin: 10px 0 14px 0;
        }

        .pnr-highlight {
            background-color: #FDEEE8;
            border: 1px solid #f6d6c8;
            border-radius: 8px;
            padding: 10px 16px;
            margin-bottom: 14px;
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

        /* Pembungkus tiap section: tidak boleh terpotong, kalau tidak muat pindah halaman */
        .section {
            margin-bottom: 16px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #16324F;
            margin: 0 0 10px 0;
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
            margin-bottom: 0;
            overflow: hidden;
        }

        .segment-body {
            padding: 12px 16px;
        }

        .segment-body table {
            width: 100%;
        }

        .leg-time {
            font-size: 19px;
            font-weight: bold;
            color: #16324F;
        }

        /* label zona waktu di samping jam */
        .leg-tz {
            font-size: 7.5px;
            font-weight: normal;
            color: #7a8699;
        }

        .leg-date {
            font-size: 8.5px;
            color: #9aa6b5;
        }

        .leg-place {
            font-size: 10.5px;
            font-weight: bold;
            color: #23303f;
        }

        /* titik kecil (7px) */
        .leg-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #2E75B6;
            margin: 0 auto;
        }

        /* garis putus-putus penghubung kota atas ke kota bawah */
        .leg-line {
            width: 1px;
            border-left: 1px dashed #8fa5bd;
            margin: 0 auto;
        }

        .leg-connector {
            padding-left: 6px;
        }

        .v-mid {
            vertical-align: middle;
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

        .ptable tr {
            page-break-inside: avoid;
        }

        .ptable th {
            background-color: #F2F6FB;
            color: #5b6b80;
            font-size: 9px;
            text-align: left;
            padding: 8px 10px;
        }

        .ptable td {
            padding: 7px 10px;
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
            padding: 12px 16px;
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

        /* footer diletakkan di area margin bawah @page */
        .footer-bar {
            position: fixed;
            bottom: -76px;
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
                        &nbsp;&middot;&nbsp; Dicetak {{ now('Asia/Jakarta')->translatedFormat('d M Y, H:i') }} WIB
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
            // ===== Helper zona waktu =====
            $tzMap = [
                'WIB'  => 'Asia/Jakarta',
                'WITA' => 'Asia/Makassar',
                'WIT'  => 'Asia/Jayapura',
            ];
            $tzAbbr = [
                'Asia/Jakarta' => 'WIB', 'Asia/Pontianak' => 'WIB',
                'Asia/Makassar' => 'WITA', 'Asia/Jayapura' => 'WIT',
                'Asia/Kuala_Lumpur' => 'MYT', 'Asia/Kuching' => 'MYT',
                'Asia/Singapore' => 'SGT', 'Asia/Bangkok' => 'ICT', 'Asia/Ho_Chi_Minh' => 'ICT',
                'Asia/Manila' => 'PHT', 'Asia/Hong_Kong' => 'HKT',
                'Asia/Tokyo' => 'JST', 'Asia/Seoul' => 'KST',
                'Asia/Qatar' => 'AST', 'Asia/Riyadh' => 'AST', 'Asia/Dubai' => 'GST',
                'Asia/Kolkata' => 'IST',
            ];
            // cadangan kalau kolom timezone hanya berisi offset (menit => singkatan)
            $offsetAbbr = [420 => 'WIB', 480 => 'MYT', 180 => 'AST'];

            // Terima model wilayah. Kolom timezone boleh berisi: IANA, WIB/WITA/WIT, "UTC+8", "+08:00", "8".
            // Kalau kolom kosong dan bandara di Indonesia, zona ditebak dari nama provinsi.
            $resolveTz = function ($w) use ($tzMap) {
                $raw = trim((string) ($w->timezone ?? ''));
                if ($raw === '') {
                    $country = strtolower(trim((string) ($w->country ?? '')));
                    $prov = strtolower(trim((string) ($w->province_name ?? '')));
                    if (in_array($country, ['indonesia', 'id'], true) && $prov !== '') {
                        if (str_contains($prov, 'papua') || str_contains($prov, 'maluku')) {
                            return ['id' => 'Asia/Jayapura', 'known' => true];
                        }
                        foreach (['bali', 'nusa tenggara', 'sulawesi', 'gorontalo',
                                  'kalimantan selatan', 'kalimantan timur', 'kalimantan utara'] as $k) {
                            if (str_contains($prov, $k)) {
                                return ['id' => 'Asia/Makassar', 'known' => true];
                            }
                        }
                        return ['id' => 'Asia/Jakarta', 'known' => true];
                    }
                    return ['id' => 'Asia/Jakarta', 'known' => false];
                }
                if (isset($tzMap[strtoupper($raw)])) {
                    return ['id' => $tzMap[strtoupper($raw)], 'known' => true];
                }
                if (preg_match('/^(?:UTC|GMT)?\s*([+-]?)\s*(\d{1,2})(?::?(\d{2}))?$/i', $raw, $m)) {
                    return ['id' => sprintf('%s%02d:%02d', $m[1] ?: '+', $m[2], $m[3] ?? 0), 'known' => true];
                }
                return ['id' => $raw, 'known' => true];
            };

            // "MYT · UTC+8", "BST · UTC+1", atau "UTC+5:30" kalau singkatan tidak diketahui
            $tzLabel = function (\Carbon\Carbon $t) use ($tzAbbr, $offsetAbbr) {
                $min = $t->utcOffset();
                $abs = abs($min);
                $utc = 'UTC' . ($min < 0 ? '-' : '+') . intdiv($abs, 60)
                    . ($abs % 60 ? ':' . sprintf('%02d', $abs % 60) : '');

                $abbr = $tzAbbr[$t->getTimezone()->getName()] ?? null;
                if (!$abbr) {
                    $abbr = $t->format('T'); // London -> GMT/BST otomatis (DST)
                    if (!preg_match('/^[A-Za-z]{2,5}$/', $abbr)) {
                        $abbr = $offsetAbbr[$min] ?? null;
                    }
                }
                return $abbr ? $abbr . ' · ' . $utc : $utc;
            };

            // ===== Pre-pass 1: waktu absolut tiap segmen =====
            $flights = $booking->flights->values();
            $legs = [];
            $prevArr = null;

            foreach ($flights as $i => $f) {
                $o = $resolveTz($f->origin);
                $d = $resolveTz($f->destination);
                $leg = [
                    'dep' => null, 'arr' => null, 'duration' => null,
                    'depTz' => null, 'arrTz' => null, 'layover_before' => null,
                ];
                try {
                    $dep = \Carbon\Carbon::parse($f->departure_date->format('Y-m-d') . ' ' . $f->dep_time, $o['id']);

                    // Pengaman: berangkat "sebelum" tiba segmen sebelumnya (selisih < 24 jam)
                    // berarti lewat tengah malam -> maju sehari
                    if ($prevArr && $dep->lt($prevArr) && ($prevArr->timestamp - $dep->timestamp) < 86400) {
                        $dep->addDay();
                    }

                    // Jam tiba = jam lokal bandara tujuan, di tanggal lokal tujuan saat berangkat
                    $arr = $dep->copy()->setTimezone($d['id'])->setTimeFromTimeString($f->arr_time);
                    if ($arr->lte($dep)) {
                        $arr->addDay();
                    }

                    $mins = intdiv($arr->timestamp - $dep->timestamp, 60);
                    $leg['dep'] = $dep;
                    $leg['arr'] = $arr;
                    $leg['duration'] = sprintf('%dj %02dm', intdiv($mins, 60), $mins % 60);
                    $leg['depTz'] = $o['known'] ? $tzLabel($dep) : null;
                    $leg['arrTz'] = $d['known'] ? $tzLabel($arr) : null;
                    $prevArr = $arr;
                } catch (\Throwable $e) {
                    // biarkan null -> tampilan fallback ke departure_date
                }
                $legs[$i] = $leg;
            }

            // ===== Pre-pass 2: kelompokkan segmen connecting (transit <= 12 jam) =====
            $groups = [];
            $g = -1;
            foreach ($flights as $i => $f) {
                $connects = false;
                if ($i > 0 && $legs[$i - 1]['arr'] && $legs[$i]['dep']
                    && $f->origin_wilayah_id
                    && $flights[$i - 1]->destination_wilayah_id == $f->origin_wilayah_id) {
                    $gap = intdiv($legs[$i]['dep']->timestamp - $legs[$i - 1]['arr']->timestamp, 60);
                    if ($gap >= 0 && $gap <= 12 * 60) {
                        $connects = true;
                        $legs[$i]['layover_before'] = sprintf('%dj %02dm', intdiv($gap, 60), $gap % 60);
                    }
                }
                if ($connects) {
                    $groups[$g][] = $i;
                } else {
                    $groups[] = [$i];
                    $g = count($groups) - 1;
                }
            }
        @endphp

        @foreach ($groups as $gi => $group)
            @php
                $firstFlight = $flights[$group[0]];
                $lastFlight = $flights[end($group)];
            @endphp

            <div class="section">
                <p class="section-title">
                    @if (file_exists($iconPlane))
                        <img src="{{ $iconPlane }}" class="icon-inline">
                    @endif
                    {{ count($groups) > 1 ? 'Penerbangan ' . ($gi + 1) : 'Detail Penerbangan' }}
                    <span class="section-sub">&middot; {{ $firstFlight->origin->city_name }} &rarr;
                        {{ $lastFlight->destination->city_name }}</span>
                </p>

                <div class="segment-card">
                    @foreach ($group as $k => $idx)
                        @php
                            $flight = $flights[$idx];
                            $leg = $legs[$idx];

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

                        {{-- Banner transit di antara dua segmen --}}
                        @if ($k > 0)
                            @php $tp = $flights[$group[$k - 1]]->destination; @endphp
                            <div class="transit-banner">
                                Transit di {{ $tp->city_name }}
                                &middot; {{ $tp->airport_name ? $tp->airport_name . ' (' . $tp->code_iata . ')' : $tp->code_iata }}
                                @if ($leg['layover_before'])
                                    <span class="transit-duration">{{ $leg['layover_before'] }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="segment-body" style="{{ $k > 0 ? 'padding-top:12px;' : '' }}">
                            <table>
                                <tr>
                                    <td style="width:70%;">
                                        <table>
                                            {{-- Berangkat: jam, titik, dan kota dalam satu baris, rata tengah --}}
                                            <tr>
                                                <td class="v-mid" style="width:38%;">
                                                    <div class="leg-time">{{ $flight->dep_time }}
                                                        @if ($leg['depTz'])
                                                            <span class="leg-tz">{{ $leg['depTz'] }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="v-mid" style="width:8%;">
                                                    <div style="height:10px;"></div>
                                                    <div class="leg-dot"></div>
                                                    <div class="leg-line" style="height:10px;"></div>
                                                </td>
                                                <td class="v-mid leg-connector">
                                                    <div class="leg-place">{{ $flight->origin->city_name }} - {{ $originCode }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="leg-date">
                                                        {{ ($leg['dep'] ?? $flight->departure_date)->translatedFormat('D, d M Y') }}
                                                    </div>
                                                </td>
                                                <td><div class="leg-line" style="height:14px;"></div></td>
                                                <td></td>
                                            </tr>

                                            {{-- Jarak antar kota (garis tetap tersambung) --}}
                                            <tr>
                                                <td></td>
                                                <td><div class="leg-line" style="height:12px;"></div></td>
                                                <td></td>
                                            </tr>

                                            {{-- Tiba --}}
                                            <tr>
                                                <td class="v-mid">
                                                    <div class="leg-time">{{ $flight->arr_time }}
                                                        @if ($leg['arrTz'])
                                                            <span class="leg-tz">{{ $leg['arrTz'] }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="v-mid">
                                                    <div class="leg-line" style="height:10px;"></div>
                                                    <div class="leg-dot"></div>
                                                    <div style="height:10px;"></div>
                                                </td>
                                                <td class="v-mid leg-connector">
                                                    <div class="leg-place">{{ $flight->destination->city_name }} - {{ $destCode }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="leg-date">
                                                        {{ ($leg['arr'] ?? $flight->departure_date)->translatedFormat('D, d M Y') }}
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </table>

                                        @if ($leg['duration'])
                                            <div style="margin-top:10px; font-size:9px; color:#7a8699;">
                                                Durasi terbang: <strong style="color:#16324F;">{{ $leg['duration'] }}</strong>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="width:30%;">
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
                                            <div class="flightno-class">
                                                @if (trim((string) $flight->subclass) !== '')
                                                    {{ strtoupper(trim($flight->subclass)) }} &middot;
                                                @endif
                                                Economy
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Passenger Details — versi rombongan: bagasi digabung sebagai
             kolom paling ujung, bukan box terpisah per orang seperti versi
             perorangan (pdf.blade.php), supaya tetap ringkas untuk daftar
             penumpang yang panjang. Section ini sengaja TIDAK memakai
             .section (avoid), karena daftar panjang boleh lanjut ke halaman
             berikutnya: baris tidak terpotong dan header tabel diulang. --}}
        <div style="margin-bottom:16px;">
            <p class="section-title">Detail Penumpang</p>
            <table class="ptable">
                <thead>
                    <tr>
                        <th style="width:6%;">No.</th>
                        <th style="width:30%;">Nama</th>
                        <th style="width:12%;">Tipe</th>
                        <th style="width:24%;">No. Tiket</th>
                        <th style="width:28%; text-align:right;">Bagasi Tercatat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($booking->passengers as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="passenger-name">{{ strtoupper($p->title) }} {{ strtoupper($p->name) }}</td>
                            <td>{{ $p->type }}</td>
                            <td>{{ $p->ticket_number }}</td>
                            <td class="col-baggage">{{ $p->baggage ?: '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="ptable-footnote">
                * Setiap penumpang mendapat bagasi kabin gratis 7 Kg / 1 tas. Bagasi tercatat sesuai kolom di atas.
            </div>
        </div>

        {{-- Fare --}}
        <div class="section">
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