<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $invoice->invoice_code }}</title>
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
            // Font: sama dengan e-ticket (lokal -> online -> DejaVu Sans).
            $localFontRegular = public_path('fonts/Poppins-Regular.ttf');
            $localFontBold = public_path('fonts/Poppins-Bold.ttf');
            $localFontsAvailable = file_exists($localFontRegular) && file_exists($localFontBold);

            $remoteFontRegular = 'https://raw.githubusercontent.com/google/fonts/main/ofl/poppins/Poppins-Regular.ttf';
            $remoteFontBold = 'https://raw.githubusercontent.com/google/fonts/main/ofl/poppins/Poppins-Bold.ttf';

            $fontRegularSrc = str_replace('\\', '/', $localFontsAvailable ? $localFontRegular : $remoteFontRegular);
            $fontBoldSrc = str_replace('\\', '/', $localFontsAvailable ? $localFontBold : $remoteFontBold);
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
            margin: 10px 0 14px 0;
        }

        /* Pembungkus: .section = blok kecil yang tidak boleh terpotong;
           .block = tabel yang boleh lanjut ke halaman berikutnya. */
        .section {
            margin-bottom: 16px;
            page-break-inside: avoid;
        }

        .block {
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #16324F;
            margin: 0 0 10px 0;
            page-break-after: avoid;
        }

        /* ===== Data pemesan ===== */
        .info-band {
            background-color: #F2F6FB;
            border-radius: 6px;
            padding: 12px 16px;
        }

        .band-title {
            font-size: 9px;
            font-weight: bold;
            color: #2E75B6;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 8px;
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
            padding-right: 10px;
        }

        /* ===== Tabel item ===== */
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
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: .3px;
            text-align: left;
            padding: 8px 10px;
        }

        .ptable td {
            padding: 8px 10px;
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

        .ptable .neg {
            color: #E2502F;
        }

        .subtotal-row td {
            font-weight: bold;
            color: #16324F;
            border-top: 1px solid #dfe6ee;
            background-color: #F2F6FB;
        }

        /* ===== Pembayaran + Total (berdampingan, tinggi sama) ===== */
        /* Tidak memakai overflow:hidden supaya isi tidak pernah terpotong;
           latar kartu = warna body, jadi sisa ruang di bawah tidak terlihat. */
        .pay-card {
            border: 1px solid #2E75B6;
            border-radius: 8px;
            background-color: #F2F6FB;
            height: 136px;
        }

        .pay-head {
            background-color: #2E75B6;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 7px 14px;
            border-radius: 7px 7px 0 0;
        }

        .pay-body {
            padding: 8px 14px;
        }

        .pay-body td {
            padding: 3px 0;
            vertical-align: middle;
        }

        .pay-label {
            width: 30%;
            font-size: 8.5px;
            color: #7a8699;
        }

        .pay-value {
            font-size: 10.5px;
            font-weight: bold;
            color: #16324F;
        }

        .pay-account {
            font-size: 16px;
            font-weight: bold;
            color: #16324F;
            letter-spacing: 1.5px;
        }

        .total-card {
            background-color: #FDEEE8;
            border: 1px solid #f6d6c8;
            border-radius: 8px;
            padding: 14px 16px;
            height: 108px;
        }

        .total-label {
            font-size: 9px;
            color: #9a5138;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .total-value {
            font-size: 22px;
            font-weight: bold;
            color: #E2502F;
            margin-top: 8px;
        }

        .total-note {
            font-size: 8.5px;
            color: #9a5138;
            margin-top: 8px;
            line-height: 1.4;
        }

        .notes-box {
            border: 1px solid #e5e8ee;
            border-left: 3px solid #E2502F;
            background-color: #fbfcfe;
            border-radius: 4px;
            padding: 12px 16px;
            font-size: 9.5px;
            color: #445266;
            line-height: 1.6;
        }

        /* ===== TTD & Stempel =====
           Blok punya tinggi tetap supaya stempel (position:absolute) punya
           area pasti untuk menimpa TTD. Stempel dipusatkan tanpa transform
           (dompdf tidak mendukung transform): left = (lebar blok - lebar
           stempel) / 2. Kalau ukuran stempel diubah, sesuaikan keduanya. */
        .signature-block {
            margin-top: 24px;
            width: 220px;
            margin-left: auto;
            text-align: center;
            position: relative;
            height: 140px;
            page-break-inside: avoid;
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
            left: 20px;
            width: 180px;
            height: auto;
            opacity: 0.92;
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

        // Gambar TTD + stempel — taruh file di public/images/ttd-stempel.png
        // (PNG transparan paling bagus). Kalau belum ada, area TTD hanya
        // menampilkan teks nama penandatangan.
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

        {{-- Data Pemesan --}}
        <div class="section">
            <div class="info-band">
                <div class="band-title">Data Pemesan</div>
                <table>
                    <tr>
                        <td style="width:30%;">
                            <div class="info-label">Nama</div>
                            <div class="info-value">{{ $invoice->orderer_name }}</div>
                        </td>
                        <td style="width:44%;">
                            <div class="info-label">Alamat</div>
                            <div class="info-value">{{ $invoice->orderer_address ?: '-' }}</div>
                        </td>
                        <td style="width:26%;">
                            <div class="info-label">No. HP</div>
                            <div class="info-value">{{ $invoice->orderer_phone ?: '-' }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Tiket Pesawat --}}
        @if ($invoice->flightItems->count())
            <div class="block">
                <p class="section-title">Pemesanan Pesawat</p>
                <table class="ptable">
                    <thead>
                        <tr>
                            <th style="width:6%;">No</th>
                            <th style="width:22%;">Nama Penumpang</th>
                            <th style="width:16%;">Maskapai</th>
                            <th style="width:20%;">Rute</th>
                            <th style="width:16%;">Waktu</th>
                            <th class="num" style="width:20%;">Harga Tiket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->sorted_flight_items as $i => $item)
                            <tr class="{{ $i % 2 ? 'alt' : '' }}">
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
                    </tbody>
                </table>
            </div>
        @endif

        {{-- Data Hotel --}}
        @if ($invoice->hotelItems->count())
            <div class="block">
                <p class="section-title">Pemesanan Hotel</p>
                <table class="ptable">
                    <thead>
                        <tr>
                            <th style="width:6%;">No</th>
                            <th style="width:18%;">Nama</th>
                            <th style="width:22%;">Nama Hotel</th>
                            <th style="width:16%;">Lokasi</th>
                            <th style="width:18%;">Waktu</th>
                            <th class="num" style="width:20%;">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->sorted_hotel_items as $i => $item)
                            <tr class="{{ $i % 2 ? 'alt' : '' }}">
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->passenger_name }}</td>
                                <td>{{ $item->hotel_name }}</td>
                                <td>{{ $item->hotel_location ?: '-' }}</td>
                                <td>{{ $item->hotel_date_range_text }}</td>
                                <td class="num">{{ number_format($item->amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="subtotal-row">
                            <td colspan="5">Subtotal Hotel</td>
                            <td class="num">{{ number_format($invoice->hotelItems->sum('amount'), 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        {{-- Biaya Tambahan --}}
        @if ($invoice->extraItems->count())
            <div class="block">
                <p class="section-title">Biaya Tambahan</p>
                <table class="ptable">
                    <thead>
                        <tr>
                            <th style="width:6%;">No</th>
                            <th>Keterangan</th>
                            <th class="num" style="width:20%;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->extraItems as $i => $item)
                            <tr class="{{ $i % 2 ? 'alt' : '' }}">
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->label }}</td>
                                <td class="num {{ $item->amount < 0 ? 'neg' : '' }}">
                                    {{ $item->amount < 0 ? '-' : '' }}{{ number_format(abs($item->amount), 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{-- Pembayaran (kiri) + Total Tagihan (kanan) --}}
        <div class="section">
            <table>
                <tr>
                    <td style="width:56%;">
                        <div class="pay-card">
                            <div class="pay-head">Info Pembayaran &middot; Transfer ke</div>
                            <div class="pay-body">
                                <table>
                                    <tr>
                                        <td class="pay-label">Bank</td>
                                        <td class="pay-value">{{ $invoice->bank_name ?: 'Bank Syariah Indonesia (BSI)' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pay-label">No. Rekening</td>
                                        <td class="pay-account">{{ $invoice->bank_account_number ?: '7344334808' }}</td>
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
                        <div class="total-card">
                            <div class="total-label">Total Tagihan</div>
                            <div class="total-value">Rp {{ number_format($invoice->total, 0, ',', '.') }}</div>
                            <div class="total-note">Sudah termasuk seluruh biaya tiket dan tambahan di atas</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        @if ($invoice->notes)
            <div class="section">
                <div class="notes-box">{{ $invoice->notes }}</div>
            </div>
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