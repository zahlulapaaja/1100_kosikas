<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $invoice->invoice_code }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
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
            padding: 32px 40px 100px 40px;
        }

        /* ===== Palette — sama persis dengan e-ticket =====
           Blue    #2E75B6  primary accent
           Navy    #16324F  dark text / footer
           Orange  #E2502F  single deliberate highlight
        */

        .top-bar {
            width: 100%;
            margin-bottom: 10px;
        }

        .invoice-pill {
            display: inline-block;
            background-color: #2E75B6;
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
            margin: 14px 0 18px 0;
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

        .info-band {
            background-color: #F2F6FB;
            border-radius: 6px;
            padding: 12px 16px;
        }

        .info-band .band-title {
            font-size: 9px;
            font-weight: bold;
            color: #2E75B6;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 8px;
        }

        .info-row td {
            font-size: 10px;
            padding: 2px 0;
        }

        .info-label {
            width: 90px;
            color: #7a8699;
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
            text-transform: uppercase;
            letter-spacing: .3px;
            text-align: left;
            padding: 8px 10px;
        }

        .ptable td {
            padding: 9px 10px;
            font-size: 10.5px;
            border-top: 1px solid #eef1f5;
        }

        .ptable td.num,
        .ptable th.num {
            text-align: right;
        }

        .subtotal-row td {
            font-weight: bold;
            border-top: 1px solid #e5e8ee;
            background-color: #F2F6FB;
        }

        .fare-box {
            border: 1px solid #e5e8ee;
            border-radius: 6px;
            padding: 14px 16px;
            margin-top: 14px;
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

        .notes-box {
            border: 1px solid #e5e8ee;
            border-left: 3px solid #E2502F;
            background-color: #fbfcfe;
            border-radius: 4px;
            padding: 12px 16px;
            margin-top: 16px;
            font-size: 9.5px;
            color: #445266;
            line-height: 1.6;
        }

        /* ===== TTD & Stempel =====
           .signature-block punya tinggi tetap supaya gambar stempel yang
           position:absolute di dalamnya punya area pasti untuk menimpa TTD.
           Ukuran & posisi stempel diatur lewat .ttd-stamp-img — geser
           top/right dan besar/kecilkan width sesuai gambar aslinya nanti. */
        .signature-block {
            margin-top: 40px;
            width: 220px;
            /* <- lebar kolom TTD, sesuaikan kalau perlu */
            margin-left: auto;
            /* dorong seluruh blok ke kanan halaman */
            text-align: center;
            /* TTD, stempel, & nama center di dalam kolom ini */
            position: relative;
            height: 140px;
        }

        .signature-label {
            font-size: 10px;
            color: #445266;
        }

        .signature-name {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            color: #16324F;
        }

        .ttd-stamp-img {
            position: absolute;
            top: 18px;
            left: 50%;
            transform: translateX(-50%);
            /* center horizontal terhadap kolom */
            width: 180px;
            /* <- sesuaikan ukuran stempel di sini */
            height: auto;
            opacity: 0.92;
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

        // Gambar TTD + stempel — taruh file di public/images/ttd-stempel.png
        // (transparan PNG paling bagus). Kalau belum ada, area TTD hanya
        // menampilkan teks nama penandatangan seperti biasa.
        $ttdPath = public_path('images/ttd-stempel.png');
        $ttdExists = file_exists($ttdPath);
    @endphp

    <div class="page">

        {{-- Top bar: kode invoice kiri, logo kanan — sama seperti e-ticket --}}
        <table class="top-bar">
            <tr>
                <td style="width:60%;">
                    <span class="invoice-pill">INVOICE</span>
                    <span class="invoice-code-label">Kode Pemesanan</span>
                    <span class="invoice-code-value">{{ $invoice->invoice_code }}</span>
                    <div class="top-bar-date">
                        Tanggal Invoice: {{ $invoice->issued_date->translatedFormat('d F Y') }}
                        &nbsp;&middot;&nbsp; Dicetak {{ now()->translatedFormat('d M Y, H:i') }} WIB
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

        {{-- Data Pemesan & Info Pembayaran --}}
        <table>
            <tr>
                <td style="width:48%;">
                    <div class="info-band">
                        <div class="band-title">Data Pemesan</div>
                        <table class="info-row">
                            <tr>
                                <td class="info-label">Nama</td>
                                <td>: {{ $invoice->orderer_name }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Alamat</td>
                                <td>: {{ $invoice->orderer_address ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">HP</td>
                                <td>: {{ $invoice->orderer_phone ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td style="width:4%;"></td>
                <td style="width:48%;">
                    <div class="info-band">
                        <div class="band-title">Info Pembayaran</div>
                        <table class="info-row">
                            <tr>
                                <td class="info-label">Bank</td>
                                <td>: {{ $invoice->bank_name ?: 'Bank Syariah Indonesia (BSI)' }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">No. Rekening</td>
                                <td>: {{ $invoice->bank_account_number ?: '7344334808' }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Atas Nama</td>
                                <td>: {{ $invoice->bank_account_holder ?: 'Zahlul Fuadi' }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Tiket Pesawat --}}
        <p class="section-title">Pemesanan Pesawat</p>
        <table class="ptable">
            <tr>
                <th style="width:6%;">No</th>
                <th style="width:22%;">Nama Penumpang</th>
                <th style="width:16%;">Maskapai</th>
                <th style="width:20%;">Rute</th>
                <th style="width:16%;">Waktu</th>
                <th class="num" style="width:20%;">Harga Tiket</th>
            </tr>
            @foreach ($invoice->sorted_flight_items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->passenger_name }}</td>
                    <td>{{ $item->maskapai_name }}</td>
                    <td>{{ $item->route_text }}</td>
                    <td>{{ $item->flight_date_text }}</td>
                    <td class="num">{{ number_format($item->amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="subtotal-row">
                <td colspan="5">Subtotal Tiket</td>
                <td class="num">{{ number_format($invoice->flightItems->sum('amount'), 0, ',', '.') }}</td>
            </tr>
        </table>

        {{-- Biaya Tambahan --}}
        @if ($invoice->extraItems->count())
            <p class="section-title">Biaya Tambahan</p>
            <table class="ptable">
                <tr>
                    <th style="width:6%;">No</th>
                    <th>Keterangan</th>
                    <th class="num" style="width:20%;">Jumlah</th>
                </tr>
                @foreach ($invoice->extraItems as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->label }}</td>
                        <td class="num">
                            {{ $item->amount < 0 ? '-' : '' }}{{ number_format(abs($item->amount), 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif

        {{-- Total --}}
        <div class="fare-box">
            <table>
                <tr>
                    <td>
                        <div class="fare-label">Total Tagihan</div>
                        <div class="fare-note">Sudah termasuk seluruh biaya tiket dan tambahan di atas</div>
                    </td>
                    <td class="fare-value" style="width:35%;">
                        RP {{ number_format($invoice->total, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>

        @if ($invoice->notes)
            <div class="notes-box">{{ $invoice->notes }}</div>
        @endif

        {{-- TTD + Stempel --}}
        <div class="signature-block">
            <div class="signature-label">TTD</div>

            @if ($ttdExists)
                <img src="{{ $ttdPath }}" class="ttd-stamp-img">
            @endif

            <div class="signature-name">{{ $invoice->signer_name ?: 'Kosikas Travel' }}</div>
        </div>

    </div>

    {{-- Fixed footer — struktur sama persis dengan e-ticket --}}
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
