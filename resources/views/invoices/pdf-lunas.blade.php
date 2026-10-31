<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice Lunas - {{ $invoice->invoice_code }}</title>
    <style>
        /* margin bawah 76px = ruang footer. Margin atas dirapatkan supaya muat satu halaman. */
        @page {
            size: A4;
            margin: 26px 0 76px 0;
        }

        * {
            box-sizing: border-box;
        }

        @php // Font: sama dengan e-ticket & invoice (lokal -> online -> DejaVu Sans).
        $localFontRegular =public_path('fonts/Poppins-Regular.ttf');
        $localFontBold =public_path('fonts/Poppins-Bold.ttf');
        $localFontsAvailable =file_exists($localFontRegular) && file_exists($localFontBold);

        $remoteFontRegular ='https://raw.githubusercontent.com/google/fonts/main/ofl/poppins/Poppins-Regular.ttf';
        $remoteFontBold ='https://raw.githubusercontent.com/google/fonts/main/ofl/poppins/Poppins-Bold.ttf';

        $fontRegularSrc =str_replace('\\', '/', $localFontsAvailable ? $localFontRegular : $remoteFontRegular);
        $fontBoldSrc =str_replace('\\', '/', $localFontsAvailable ? $localFontBold : $remoteFontBold);

        @endphp @font-face {
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
            font-size: 10.5px;
            color: #23303f;
            margin: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td {
            padding: 0;
            vertical-align: top;
            border: none;
        }

        .page {
            padding: 0 40px;
        }

        /* ===== Palette — sama dengan e-ticket & invoice =====
           Blue    #2E75B6  aksen utama
           Navy    #16324F  teks gelap / footer
           Orange  #E2502F  highlight (catatan, nilai minus)
           Green   #1E9E6A  KHUSUS status lunas (pill, badge, stempel)
        */

        /* ===== Top bar ===== */
        .top-bar {
            margin-bottom: 8px;
        }

        .invoice-pill {
            display: inline-block;
            background-color: #1E9E6A;
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            padding: 6px 14px;
            border-radius: 20px;
        }

        .invoice-code-label {
            font-size: 11px;
            color: #5b6b80;
            margin-left: 8px;
        }

        .invoice-code-value {
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
            margin: 8px 0 12px 0;
        }

        .section {
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #16324F;
            margin: 0 0 7px 0;
            page-break-after: avoid;
        }

        /* ===== Band info ===== */
        .info-band {
            background-color: #F2F6FB;
            border-radius: 6px;
            padding: 10px 16px;
        }

        .band-title {
            font-size: 9px;
            font-weight: bold;
            color: #2E75B6;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 5px;
        }

        .info-label {
            font-size: 8.5px;
            color: #7a8699;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .info-value {
            font-size: 10.5px;
            font-weight: bold;
            color: #16324F;
            margin-top: 2px;
            padding-right: 8px;
        }

        /* Badge status: kecil, padding tipis, line-height dikunci */
        .status-badge {
            display: inline-block;
            background-color: #E4F5EE;
            border: 1px solid #1E9E6A;
            color: #1E9E6A;
            font-size: 8.5px;
            font-weight: bold;
            letter-spacing: 1px;
            line-height: 1.2;
            padding: 2px 9px;
            border-radius: 9px;
            margin-top: 3px;
        }

        /* ===== Pemesan | Penyedia — satu band, dua kolom, baris label-nilai ===== */
        .kv td {
            padding: 2px 0;
            vertical-align: top;
        }

        .kv .k {
            width: 24%;
            font-size: 8.5px;
            color: #7a8699;
            padding-top: 3px;
        }

        .kv .v {
            font-size: 10px;
            font-weight: bold;
            color: #16324F;
            line-height: 1.4;
        }

        .kv .v-small {
            font-size: 9px;
            font-weight: bold;
            color: #16324F;
            line-height: 1.4;
        }

        .col-divider {
            border-left: 1px solid #dfe6ee;
            padding-left: 16px;
        }

        /* ===== Penumpang ===== */
        .pax-box {
            border: 1px solid #e5e8ee;
            border-radius: 6px;
            padding: 7px 16px;
        }

        .pax-box td {
            font-size: 10px;
            color: #16324F;
            font-weight: bold;
            padding: 2px 0;
            width: 50%;
        }

        .pax-no {
            color: #2E75B6;
            font-weight: bold;
        }

        /* ===== Tabel detail pembelian ===== */
        .ptable {
            border: 1px solid #e5e8ee;
            border-radius: 6px;
        }

        .ptable tr {
            page-break-inside: avoid;
        }

        .ptable th {
            background-color: #F2F6FB;
            color: #5b6b80;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: .3px;
            text-align: left;
            padding: 7px 10px;
        }

        .ptable td {
            padding: 7px 10px;
            font-size: 10px;
            border-top: 1px solid #eef1f5;
        }

        .ptable tr.alt td {
            background-color: #fafbfd;
        }

        .ptable td.num,
        .ptable th.num {
            text-align: right;
        }

        .ptable td.ctr,
        .ptable th.ctr {
            text-align: center;
        }

        .ptable .neg {
            color: #E2502F;
        }

        .row-no {
            font-weight: bold;
            color: #2E75B6;
        }

        .item-type {
            font-weight: bold;
            color: #16324F;
        }

        .item-desc {
            font-weight: bold;
            color: #23303f;
        }

        .item-sub {
            font-size: 8.5px;
            color: #7a8699;
            margin-top: 2px;
            line-height: 1.4;
        }

        /* Baris ringkasan (Total, Biaya Layanan, Total Tagihan): tanpa kolom jenis,
           jml, dan harga satuan; label dan angka mepet kanan seperti receipt Traveloka. */
        .sum-plain td {
            font-size: 10px;
            color: #445266;
            border-top: 1px solid #eef1f5;
        }

        .sum-row td {
            font-weight: bold;
            font-size: 10.5px;
            color: #16324F;
            border-top: 1px solid #dfe6ee;
            background-color: #F2F6FB;
        }

        .sum-label {
            text-align: right;
        }

        /* ===== Pembayaran diterima (kiri) + Jumlah pembayaran (kanan) =====
           Dua kartu dengan struktur kembar: header berwarna + body.
           Tinggi sama-sama dikunci di 130px; isi (3 baris / angka + stempel)
           dihitung supaya selalu muat. */
        .card {
            border-radius: 8px;
            height: 146px;
        }

        .card-blue {
            border: 1px solid #2E75B6;
            background-color: #F2F6FB;
        }

        .card-green {
            border: 1px solid #1E9E6A;
            background-color: #E4F5EE;
        }

        .card-head {
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .5px;
            line-height: 1.3;
            padding: 7px 14px;
            border-radius: 7px 7px 0 0;
        }

        .card-blue .card-head {
            background-color: #2E75B6;
        }

        .card-green .card-head {
            background-color: #1E9E6A;
        }

        .card-body {
            padding: 8px 14px;
        }

        .pay-body td {
            padding: 4px 0;
            vertical-align: middle;
        }

        .pay-label {
            width: 32%;
            font-size: 8.5px;
            color: #7a8699;
        }

        .pay-value {
            font-size: 10.5px;
            font-weight: bold;
            color: #16324F;
        }

        .amount-body {
            text-align: center;
            padding-top: 8px;
            padding-bottom: 10px;
        }

        .amount-value {
            font-size: 21px;
            font-weight: bold;
            line-height: 1.3;
            color: #1E9E6A;
        }

        /* Stempel LUNAS — blok tengah bergaris ganda (dompdf tidak mendukung rotate).
           padding-left 3px mengimbangi spasi huruf terakhir supaya teks benar-benar di tengah. */
        .lunas-stamp {
            width: 104px;
            margin: 6px auto 0 auto;
            border: 3px double #1E9E6A;
            border-radius: 5px;
            color: #1E9E6A;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 3px;
            line-height: 1.2;
            text-align: center;
            padding: 3px 0 3px 3px;
        }

        /* ===== Catatan + TTD ===== */
        .notes-box {
            border: 1px solid #e5e8ee;
            border-left: 3px solid #E2502F;
            background-color: #fbfcfe;
            border-radius: 4px;
            padding: 10px 14px;
            font-size: 9.5px;
            color: #445266;
            line-height: 1.5;
        }

        .signature-block {
            width: 200px;
            margin-left: auto;
            text-align: center;
            position: relative;
            height: 126px;
        }

        .signature-label {
            font-size: 10px;
            color: #445266;
        }

        .signature-name {
            position: absolute;
            bottom: 2px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            color: #16324F;
        }

        /* Stempel dipusatkan tanpa transform: left = (200 - 150) / 2.
           top 26px = di bawah tulisan "TTD" supaya tidak menutupinya. */
        .ttd-stamp-img {
            position: absolute;
            top: 26px;
            left: 25px;
            width: 150px;
            height: auto;
            opacity: 0.92;
        }

        /* footer di area margin bawah @page */
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

        /* ===== Mode rapat: otomatis aktif kalau item banyak, supaya tetap 1 halaman ===== */
        .compact .section {
            margin-bottom: 8px;
        }

        .compact .ptable td {
            padding: 4px 8px;
            font-size: 9.5px;
        }

        .compact .ptable th {
            padding: 5px 8px;
        }

        .compact .item-sub {
            margin-top: 1px;
        }

        .compact .info-band {
            padding: 7px 14px;
        }

        .compact .pax-box {
            padding: 4px 14px;
        }

        .compact .signature-block {
            height: 106px;
        }

        .compact .ttd-stamp-img {
            width: 120px;
            left: 40px;
            top: 22px;
        }

        .compact .card {
            height: 140px;
        }

        .compact .amount-body {
            padding-top: 6px;
            padding-bottom: 8px;
        }

        .compact .lunas-stamp {
            margin-top: 4px;
        }

        /* Mode sangat rapat (banyak baris) */
        .tight .ptable td {
            padding: 3px 8px;
            font-size: 9px;
        }

        .tight .item-sub {
            font-size: 8px;
        }

        .tight .signature-block {
            height: 92px;
        }

        .tight .ttd-stamp-img {
            width: 100px;
            left: 50px;
            top: 19px;
        }
    </style>
</head>

@php
$logoPath = public_path('images/logo-kosikas.png');
$logoExists = file_exists($logoPath);

$ttdPath = public_path('images/ttd-stempel.png');
$ttdExists = file_exists($ttdPath);

// ===== Data lunas (semua punya fallback) =====
$paidAt = $invoice->paid_at
? \Carbon\Carbon::parse($invoice->paid_at)
: now('Asia/Jakarta');
$paymentMethod = $invoice->payment_method ?: 'Transfer Bank';

$flightItems = $invoice->sorted_flight_items;
$hotelItems = $invoice->sorted_hotel_items;
$extraItems = $invoice->extraItems;

// Biaya layanan tidak masuk baris bernomor; tampil di ringkasan sebelum Total Tagihan.
$isService = fn($e) => preg_match('/biaya\s*layanan|service\s*fee/i', (string) $e->label) === 1;
$serviceItems = $extraItems->filter($isService)->values();
$otherExtras = $extraItems->reject($isService)->values();

// ===== Daftar penumpang / tamu (unik, urut kemunculan) =====
$paxNames = collect($flightItems)->pluck('passenger_name')
->merge(collect($hotelItems)->pluck('passenger_name'))
->filter()
->unique()
->values();

// ===== Mode kepadatan supaya selalu 1 halaman =====
$itemCount = count($flightItems) + count($hotelItems) + count($extraItems);
$density = $itemCount > 8 ? 'compact tight' : ($itemCount > 3 || $paxNames->count() > 6 ? 'compact' : '');

$rowNo = 0;
$total = $invoice->total;
$subtotal = $total - $serviceItems->sum('amount');
$fmt = fn($n) => number_format($n, 0, ',', '.');
@endphp

<body class="{{ $density }}">

    <div class="page">

        {{-- Top bar --}}
        <table class="top-bar">
            <tr>
                <td style="width:60%;">
                    <span class="invoice-pill">INVOICE LUNAS</span>
                    <span class="invoice-code-label">Kode Pemesanan</span>
                    <span class="invoice-code-value">{{ $invoice->invoice_code }}</span>
                    <div class="top-bar-date">
                        Tanggal Invoice: {{ $invoice->issued_date->translatedFormat('d F Y') }}
                        &nbsp;&middot;&nbsp; Dicetak {{ now('Asia/Jakarta')->translatedFormat('d M Y') }}
                    </div>
                </td>
                <td style="width:40%; text-align:right;">
                    @if ($logoExists)
                    <img src="{{ $logoPath }}" class="logo-img">
                    @else
                    <strong style="font-size:14px; color:#16324F;">KOSIKAS TRAVEL</strong>
                    @endif
                </td>
            </tr>
        </table>
        <div class="top-rule"></div>

        {{-- Detail Pembayaran --}}
        <div class="section">
            <div class="info-band">
                <div class="band-title">Detail Pembayaran</div>
                <table>
                    <tr>
                        <td style="width:30%;">
                            <div class="info-label">No. Bukti Pembayaran</div>
                            <div class="info-value">{{ $invoice->invoice_code }}</div>
                        </td>
                        <td style="width:26%;">
                            <div class="info-label">Tanggal Pembayaran</div>
                            <div class="info-value">{{ $paidAt->translatedFormat('d F Y') }}</div>
                        </td>
                        <td style="width:28%;">
                            <div class="info-label">Metode Pembayaran</div>
                            <div class="info-value">{{ $paymentMethod }}</div>
                        </td>
                        <td style="width:16%;">
                            <div class="info-label">Status</div>
                            <div class="status-badge">LUNAS</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Data Pemesan | Detail Penyedia — satu band, tinggi otomatis, tidak mungkin keluar kotak --}}
        <div class="section">
            <div class="info-band">
                <table>
                    <tr>
                        <td style="width:48%; padding-right:16px;">
                            <div class="band-title">Data Pemesan</div>
                            <table class="kv">
                                <tr>
                                    <td class="k">Nama</td>
                                    <td class="v">{{ $invoice->orderer_name }}</td>
                                </tr>
                                <tr>
                                    <td class="k">No. HP</td>
                                    <td class="v">{{ $invoice->orderer_phone ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="k">Alamat</td>
                                    <td class="v-small">{{ $invoice->orderer_address ?: '-' }}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:52%;" class="col-divider">
                            <div class="band-title">Detail Penyedia</div>
                            <table class="kv">
                                <tr>
                                    <td class="k">Nama</td>
                                    <td class="v">Kosikas Travel</td>
                                </tr>
                                <tr>
                                    <td class="k">Email</td>
                                    <td class="v">kosikas.travel@gmail.com</td>
                                </tr>
                                <tr>
                                    <td class="k">Telp/WA</td>
                                    <td class="v">0897-9846-945</td>
                                </tr>
                                <tr>
                                    <td class="k">Alamat</td>
                                    <td class="v-small">Jl. Tgk. H. M Jl. Moh. Daud Beureuh No.50, Kuta Alam, Kota Banda Aceh, Aceh 23121</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Data Penumpang / Tamu --}}
        @if ($paxNames->count())
        <div class="section">
            <p class="section-title">Data Penumpang &amp; Tamu</p>
            <div class="pax-box">
                <table>
                    @foreach ($paxNames->chunk(2) as $pair)
                    @php $pairIdx = $loop->index; @endphp
                    <tr>
                        @foreach ($pair->values() as $j => $name)
                        <td><span class="pax-no">{{ $pairIdx * 2 + $j + 1 }}.</span> {{ $name }}</td>
                        @endforeach
                        @if ($pair->count() < 2)
                            <td>
                            </td>
                            @endif
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endif

        {{-- Detail Pembelian --}}
        <div class="section" style="page-break-inside:auto;">
            <p class="section-title">Detail Pembelian</p>
            <table class="ptable">
                <thead>
                    <tr>
                        <th style="width:6%;">No</th>
                        <th style="width:16%;">Jenis</th>
                        <th>Deskripsi</th>
                        <th class="ctr" style="width:7%;">Jml</th>
                        <th class="num" style="width:15%;">Harga Satuan</th>
                        <th class="num" style="width:15%;">Total (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($flightItems as $item)
                    @php $rowNo++; @endphp
                    <tr class="{{ $rowNo % 2 ? '' : 'alt' }}">
                        <td class="row-no">{{ $rowNo }}</td>
                        <td class="item-type">Tiket Pesawat</td>
                        <td>
                            <div class="item-desc">{{ $item->maskapai_name }} &middot; {{ $item->route_text }}</div>
                            <div class="item-sub">{{ $item->flight_date_text }} &middot; {{ $item->passenger_name }}</div>
                        </td>
                        <td class="ctr">1</td>
                        <td class="num">{{ $fmt($item->amount) }}</td>
                        <td class="num">{{ $fmt($item->amount) }}</td>
                    </tr>
                    @endforeach

                    @foreach ($hotelItems as $item)
                    @php $rowNo++; @endphp
                    <tr class="{{ $rowNo % 2 ? '' : 'alt' }}">
                        <td class="row-no">{{ $rowNo }}</td>
                        <td class="item-type">Hotel</td>
                        <td>
                            <div class="item-desc">{{ $item->hotel_name }}@if ($item->hotel_location) &middot; {{ $item->hotel_location }}@endif</div>
                            <div class="item-sub">{{ $item->hotel_date_range_text }} &middot; {{ $item->passenger_name }}</div>
                        </td>
                        <td class="ctr">1</td>
                        <td class="num">{{ $fmt($item->amount) }}</td>
                        <td class="num">{{ $fmt($item->amount) }}</td>
                    </tr>
                    @endforeach

                    @foreach ($otherExtras as $item)
                    @php $rowNo++; @endphp
                    <tr class="{{ $rowNo % 2 ? '' : 'alt' }}">
                        <td class="row-no">{{ $rowNo }}</td>
                        <td class="item-type">Biaya Tambahan</td>
                        <td>
                            <div class="item-desc">{{ $item->label }}</div>
                        </td>
                        <td class="ctr">1</td>
                        <td class="num {{ $item->amount < 0 ? 'neg' : '' }}">{{ $item->amount < 0 ? '-' : '' }}{{ $fmt(abs($item->amount)) }}</td>
                        <td class="num {{ $item->amount < 0 ? 'neg' : '' }}">{{ $item->amount < 0 ? '-' : '' }}{{ $fmt(abs($item->amount)) }}</td>
                    </tr>
                    @endforeach

                    @if ($serviceItems->count())
                    <tr class="sum-plain">
                        <td colspan="3"></td>
                        <td colspan="2" class="sum-label">Total</td>
                        <td class="num">{{ $subtotal < 0 ? '-' : '' }}{{ $fmt(abs($subtotal)) }}</td>
                    </tr>
                    @foreach ($serviceItems as $item)
                    <tr class="sum-plain">
                        <td colspan="3"></td>
                        <td colspan="2" class="sum-label">{{ $item->label }}</td>
                        <td class="num {{ $item->amount < 0 ? 'neg' : '' }}">{{ $item->amount < 0 ? '-' : '' }}{{ $fmt(abs($item->amount)) }}</td>
                    </tr>
                    @endforeach
                    @endif
                    <tr class="sum-row">
                        <td colspan="3"></td>
                        <td colspan="2" class="sum-label">Total Tagihan</td>
                        <td class="num">{{ $fmt($total) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pembayaran Diterima (kiri) + Jumlah Pembayaran (kanan) --}}
        <div class="section">
            <table>
                <tr>
                    <td style="width:56%;">
                        <div class="card card-blue">
                            <div class="card-head">Pembayaran Diterima</div>
                            <div class="card-body pay-body">
                                <table>
                                    <tr>
                                        <td class="pay-label">Bank</td>
                                        <td class="pay-value">{{ $invoice->bank_name ?: 'Bank Syariah Indonesia (BSI)' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pay-label">No. Rekening</td>
                                        <td class="pay-value">{{ $invoice->bank_account_number ?: '7344334808' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pay-label">Atas Nama</td>
                                        <td class="pay-value">{{ $invoice->bank_account_holder ?: 'Zahlul Fuadi' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                    <td style="width:3%;"></td>
                    <td style="width:41%;">
                        <div class="card card-green">
                            <div class="card-head">Jumlah Pembayaran</div>
                            <div class="card-body amount-body">
                                <div class="amount-value">Rp {{ $fmt($total) }}</div>
                                <div class="lunas-stamp">LUNAS</div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Catatan (kiri) + TTD (kanan) berdampingan supaya hemat tinggi --}}
        <div style="page-break-inside:avoid;">
            <table>
                <tr>
                    <td style="width:55%; padding-right:16px;">
                        @if ($invoice->notes)
                        <div class="notes-box">{{ $invoice->notes }}</div>
                        @endif
                    </td>
                    <td style="width:45%;">
                        <div class="signature-block">
                            <div class="signature-label">TTD</div>

                            @if ($ttdExists)
                            <img src="{{ $ttdPath }}" class="ttd-stamp-img">
                            @endif

                            <div class="signature-name">{{ $invoice->signer_name ?: 'Kosikas Travel' }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

    {{-- Fixed footer — sama dengan e-ticket & invoice --}}
    <div class="footer-bar">
        <table>
            <tr>
                <td style="width:60%;">
                    <div class="footer-company">KOSIKAS TRAVEL</div>
                    <div class="footer-tagline">Teman Setia Perjalanan Anda</div>
                    <div>Jl. Tgk. H. M Jl. Moh. Daud Beureuh No.50, Kuta Alam, Kec. Kuta Alam, Kota Banda Aceh, Aceh
                        23121</div>
                </td>
                <td style="width:40%; text-align:right;">
                    <div>Email: kosikas.travel@gmail.com</div>
                    <div>Telp/WA: 0897-9846-945</div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>