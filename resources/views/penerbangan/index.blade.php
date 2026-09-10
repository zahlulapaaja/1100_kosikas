@extends('layouts.app')

@section('content')

    <style>
        .airline-logo-circle {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1px solid #e9ecef;
        }

        .airline-logo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .harga-input {
            max-width: 160px;
        }

        .btn-swap-wilayah {
            width: 100%;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ---------- TEMPLATE GAMBAR (disembunyikan, hanya untuk di-capture) ---------- */
        #ticketTemplate {
            position: fixed;
            top: -99999px;
            left: -99999px;
            width: 480px;
            background: #ffffff;
            font-family: 'Inter', Arial, sans-serif;
            color: #1B2333;
        }

        .kt-img-header {
            background: #0F1D36;
            color: #fff;
            padding: 22px 20px;
        }

        .kt-img-brand {
            font-family: 'Space Grotesk', Arial, sans-serif;
            font-weight: 700;
            font-size: 17px;
            margin-bottom: 6px;
        }

        .kt-img-brand span {
            color: #C9A227;
        }

        .kt-img-route {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 12px;
        }

        .kt-img-route .kota {
            font-size: 22px;
            font-weight: 700;
            font-family: 'Space Grotesk', Arial, sans-serif;
            line-height: 1.2;
        }

        .kt-img-route .kode {
            font-size: 11px;
            opacity: .75;
        }

        .kt-img-tanggal {
            margin-top: 12px;
            font-size: 12px;
            background: rgba(255, 255, 255, .1);
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
        }

        .kt-img-body {
            padding: 16px 20px 22px;
        }

        .kt-img-row {
            padding: 14px 0;
            border-bottom: 1px dashed #E7E2D6;
        }

        .kt-img-row:last-child {
            border-bottom: none;
        }

        .kt-img-row-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .kt-img-maskapai {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .kt-img-maskapai .logo {
            width: 34px;
            height: 34px;
            min-width: 34px;
            border-radius: 50%;
            border: 1px solid #E7E2D6;
            object-fit: cover;
        }

        .kt-img-maskapai .nama {
            font-weight: 600;
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .kt-img-maskapai .kode {
            font-size: 11px;
            color: #808A9C;
        }

        .kt-img-harga {
            font-weight: 700;
            font-size: 15px;
            color: #C9A227;
            font-family: 'Space Grotesk', Arial, sans-serif;
            white-space: nowrap;
            text-align: right;
        }

        .kt-img-row-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
            padding-left: 44px;
        }

        .kt-img-jam .waktu {
            font-weight: 700;
            font-size: 14px;
            font-family: 'Space Grotesk', Arial, sans-serif;
        }

        .kt-img-jam .durasi {
            font-size: 11px;
            color: #808A9C;
            margin-top: 2px;
        }

        .kt-img-footer {
            padding: 12px 20px;
            background: #F6F4EE;
            font-size: 10px;
            color: #808A9C;
            text-align: center;
        }

        .kt-img-header-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .kt-img-logo {
            max-height: 34px;
            width: auto;
            display: block;
        }
    </style>

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Jadwal Penerbangan</h4>
                <p class="text-muted mb-0">
                    Kelola jadwal penerbangan berdasarkan rute
                </p>
            </div>
        </div>

        {{-- Filter Rute --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

                <form method="GET" id="filterWilayahForm" action="{{ route('travel.penerbangan.index') }}">

                    <div class="row g-3 align-items-end">

                        {{-- Asal --}}
                        <div class="col-md-4">

                            <label class="form-label fw-semibold">
                                Wilayah Asal
                            </label>

                            <select name="wilayah_asal_id" id="wilayahAsalSelect" class="form-select" required>

                                <option value="">
                                    -- Pilih Wilayah Asal --
                                </option>

                                @foreach ($wilayahs as $wilayah)
                                    <option value="{{ $wilayah->id }}" @selected(request('wilayah_asal_id') == $wilayah->id)>

                                        {{ $wilayah->code_iata }}
                                        - {{ $wilayah->city_name }}
                                        ({{ $wilayah->airport_name }})
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Tombol Tukar Wilayah --}}
                        <div class="col-md-1 text-center">

                            <label class="form-label fw-semibold d-none d-md-block">
                                &nbsp;
                            </label>

                            <button type="button" class="btn btn-outline-secondary btn-swap-wilayah"
                                title="Tukar Asal &amp; Tujuan" onclick="tukarWilayah()">

                                <i class="bi bi-arrow-left-right"></i>

                            </button>

                        </div>

                        {{-- Tujuan --}}
                        <div class="col-md-4">

                            <label class="form-label fw-semibold">
                                Wilayah Tujuan
                            </label>

                            <select name="wilayah_tujuan_id" id="wilayahTujuanSelect" class="form-select" required>

                                <option value="">
                                    -- Pilih Wilayah Tujuan --
                                </option>

                                @foreach ($wilayahs as $wilayah)
                                    <option value="{{ $wilayah->id }}" @selected(request('wilayah_tujuan_id') == $wilayah->id)>

                                        {{ $wilayah->code_iata }}
                                        - {{ $wilayah->city_name }}
                                        ({{ $wilayah->airport_name }})
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Tanggal (client-side saja, untuk label di gambar) --}}
                        <div class="col-md-2">

                            <label class="form-label fw-semibold">
                                Tanggal
                            </label>

                            <input type="date" id="tanggalPenerbangan" name="tanggal"
                                value="{{ request('tanggal', now()->format('Y-m-d')) }}" class="form-control">

                        </div>

                        <div class="col-md-1">

                            <button class="btn btn-primary w-100">
                                <i class="bi bi-search"></i>
                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>


        {{-- Hanya tampil jika sudah memilih asal dan tujuan --}}
        @if (request('wilayah_asal_id') && request('wilayah_tujuan_id'))

            @php
                $asal = $wilayahs->firstWhere('id', request('wilayah_asal_id'));

                $tujuan = $wilayahs->firstWhere('id', request('wilayah_tujuan_id'));
            @endphp


            {{-- Header Rute --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body">

                    <div class="row align-items-center text-center">

                        <div class="col-md-5">

                            <div class="text-muted small">
                                Keberangkatan
                            </div>

                            <h3 class="fw-bold mb-0">
                                {{ $asal->code_iata }}
                            </h3>

                            <div>
                                {{ $asal->city_name }}
                            </div>

                        </div>

                        <div class="col-md-2">

                            <i class="bi bi-arrow-right fs-2 text-primary"></i>

                        </div>

                        <div class="col-md-5">

                            <div class="text-muted small">
                                Tujuan
                            </div>

                            <h3 class="fw-bold mb-0">
                                {{ $tujuan->code_iata }}
                            </h3>

                            <div>
                                {{ $tujuan->city_name }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Daftar Jadwal --}}
            <div class="card border-0 shadow-sm">

                <div
                    class="card-header bg-white
                        d-flex justify-content-between
                        align-items-center flex-wrap gap-2">

                    <div>
                        <h5 class="mb-0">
                            Daftar Penerbangan
                        </h5>

                        <small class="text-muted">
                            {{ $jadwals->count() }} jadwal tersedia
                        </small>
                    </div>

                    <div class="d-flex gap-2">

                        @if ($jadwals->count())
                            <button type="button" class="btn btn-success" onclick="generateGambarPenerbangan()">

                                <i class="bi bi-image"></i>
                                Generate Gambar

                            </button>
                        @endif

                        <a href="{{ route('travel.penerbangan.create', [
                            'wilayah_asal_id' => request('wilayah_asal_id'),
                            'wilayah_tujuan_id' => request('wilayah_tujuan_id'),
                        ]) }}"
                            class="btn btn-primary">

                            <i class="bi bi-plus-lg"></i>
                            Tambah Jadwal

                        </a>

                    </div>

                </div>

                <div class="card-body p-0">

                    @if ($jadwals->count())
                        {{-- Toolbar Filter Maskapai & Rentang Waktu --}}
                        <div class="p-3 border-bottom bg-light">

                            <div class="row g-2 align-items-end">

                                <div class="col-md-5">
                                    <label class="form-label small fw-semibold mb-1">
                                        Filter Maskapai
                                    </label>

                                    <select id="filterMaskapai" class="form-select form-select-sm"
                                        onchange="filterJadwal()">
                                        <option value="">Semua Maskapai</option>

                                        @foreach ($jadwals->pluck('maskapai')->filter()->unique('id')->sortBy('name') as $mk)
                                            <option value="{{ $mk->id }}">{{ $mk->name }}
                                                ({{ $mk->code_iata }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label small fw-semibold mb-1">
                                        Filter Rentang Waktu Berangkat
                                    </label>

                                    <select id="filterWaktu" class="form-select form-select-sm" onchange="filterJadwal()">
                                        <option value="">Semua Waktu</option>
                                        <option value="00:00-05:59">Dini Hari (00:00 - 05:59)</option>
                                        <option value="06:00-11:59">Pagi (06:00 - 11:59)</option>
                                        <option value="12:00-14:59">Siang (12:00 - 14:59)</option>
                                        <option value="15:00-17:59">Sore (15:00 - 17:59)</option>
                                        <option value="18:00-23:59">Malam (18:00 - 23:59)</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary w-100"
                                        onclick="resetFilterJadwal()">
                                        <i class="bi bi-x-circle"></i> Reset
                                    </button>
                                </div>

                            </div>

                            <div class="small text-muted mt-2" id="filterInfoText"></div>

                        </div>

                        <div class="table-responsive">

                            <table class="table table-hover mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th class="px-4" style="width: 40px;">

                                            <input type="checkbox" class="form-check-input" id="checkAllMaskapai" checked
                                                onchange="toggleAllJadwal(this)">

                                        </th>

                                        <th>
                                            Maskapai
                                        </th>

                                        <th>
                                            Berangkat
                                        </th>

                                        <th>
                                            Tiba
                                        </th>

                                        <th>
                                            Durasi
                                        </th>

                                        <th>
                                            Harga
                                        </th>

                                        <th class="text-end px-4">
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($jadwals as $jadwal)
                                        @php
                                            $airlineCode = $jadwal->maskapai->code_iata ?? null;

                                            $logo = $jadwal->maskapai->logo ?? null;

                                            $logoPath =
                                                $logo && file_exists(public_path($logo))
                                                    ? asset($logo)
                                                    : ($airlineCode &&
                                                    file_exists(
                                                        public_path(
                                                            'images/airlines/' . strtoupper($airlineCode) . '.png',
                                                        ),
                                                    )
                                                        ? asset('images/airlines/' . strtoupper($airlineCode) . '.png')
                                                        : null);

                                            $berangkat = \Carbon\Carbon::parse($jadwal->jam_berangkat);
                                            $sampai = \Carbon\Carbon::parse($jadwal->jam_sampai);

                                            if ($sampai->lessThan($berangkat)) {
                                                $sampai->addDay();
                                            }

                                            $menit = $berangkat->diffInMinutes($sampai);
                                            $jam = intdiv($menit, 60);
                                            $sisa = $menit % 60;
                                        @endphp

                                        <tr class="jadwal-row" data-maskapai="{{ $jadwal->maskapai->name }}"
                                            data-kode="{{ $jadwal->maskapai->code_iata }}"
                                            data-maskapai-id="{{ $jadwal->maskapai_id }}"
                                            data-logo="{{ $logoPath }}"
                                            data-berangkat="{{ $berangkat->format('H:i') }}"
                                            data-tiba="{{ $sampai->format('H:i') }}"
                                            data-durasi="{{ $jam }}j {{ $sisa }}m">

                                            <td class="px-4">

                                                <input type="checkbox" class="form-check-input jadwal-checkbox" checked
                                                    onchange="syncCheckAllState()">

                                            </td>

                                            <td>

                                                <div class="d-flex align-items-center gap-2">

                                                    @if ($logoPath)
                                                        <div class="airline-logo-circle">
                                                            <img src="{{ $logoPath }}"
                                                                alt="{{ $jadwal->maskapai->name }}" class="airline-logo">
                                                        </div>
                                                    @endif

                                                    <div>

                                                        <div class="fw-semibold">
                                                            {{ $jadwal->maskapai->name }}
                                                        </div>

                                                        <small class="text-muted">
                                                            {{ $jadwal->maskapai->code_iata }}
                                                        </small>

                                                    </div>

                                                </div>

                                            </td>

                                            <td>
                                                <strong>{{ $berangkat->format('H:i') }}</strong>
                                            </td>

                                            <td>
                                                <strong>{{ $sampai->format('H:i') }}</strong>
                                            </td>

                                            <td>
                                                {{ $jam }}j {{ $sisa }}m
                                            </td>

                                            <td>

                                                <div class="input-group harga-input">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="text" class="form-control harga-jadwal"
                                                        inputmode="numeric" placeholder="0" oninput="formatRibuan(this)">
                                                </div>

                                            </td>

                                            <td class="text-end px-4">

                                                <a href="{{ route('travel.penerbangan.edit', $jadwal) }}"
                                                    class="btn btn-sm btn-outline-secondary me-1">

                                                    <i class="bi bi-pencil"></i>

                                                </a>

                                                <form method="POST"
                                                    action="{{ route('travel.penerbangan.destroy', $jadwal) }}"
                                                    onsubmit="return confirm('Hapus jadwal ini?')" class="d-inline">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>
                    @else
                        <div class="text-center py-5">

                            <i class="bi bi-airplane fs-1 text-muted"></i>

                            <h5 class="mt-3">
                                Belum ada jadwal penerbangan
                            </h5>

                            <p class="text-muted">
                                Belum terdapat jadwal untuk rute
                                {{ $asal->code_iata }}
                                →
                                {{ $tujuan->code_iata }}
                            </p>

                            <a href="{{ route('travel.penerbangan.create', [
                                'wilayah_asal_id' => $asal->id,
                                'wilayah_tujuan_id' => $tujuan->id,
                            ]) }}"
                                class="btn btn-primary">

                                Tambah Jadwal

                            </a>

                        </div>
                    @endif

                </div>

            </div>


            {{-- Template tersembunyi untuk di-capture jadi gambar --}}
            <div id="ticketTemplate">

                <div class="kt-img-header">

                    <div class="kt-img-header-top">

                        <div class="kt-img-brand">
                            KOSIKAS <span>TRAVEL</span>
                        </div>

                        <img src="{{ asset('images/kosikas-logo.png') }}" class="kt-img-logo" crossorigin="anonymous"
                            alt="Kosikas Travel">

                    </div>

                    <div class="kt-img-route">

                        <div>
                            <div class="kode">Keberangkatan</div>
                            <div class="kota">{{ $asal->code_iata }}</div>
                            <div class="kode">{{ $asal->city_name }}</div>
                        </div>

                        <div style="font-size:22px;">→</div>

                        <div style="text-align:right;">
                            <div class="kode">Tujuan</div>
                            <div class="kota">{{ $tujuan->code_iata }}</div>
                            <div class="kode">{{ $tujuan->city_name }}</div>
                        </div>

                    </div>

                    <div class="kt-img-tanggal" id="imgTanggalLabel">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </div>

                </div>

                <div class="kt-img-body" id="imgBodyRows">
                    {{-- diisi otomatis oleh JS --}}
                </div>

                <div class="kt-img-footer">
                    Kosikas Travel &middot; Teman Setia Perjalanan Anda &middot; Dibuat {{ now()->format('d/m/Y H:i') }}
                </div>

            </div>

        @endif

    </div>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        // Format input harga jadi ribuan otomatis, mis. 1500000 -> 1.500.000
        function formatRibuan(input) {
            let angka = input.value.replace(/[^0-9]/g, '');
            input.value = angka ?
                new Intl.NumberFormat('id-ID').format(angka) :
                '';
        }

        // Format tanggal dari input date jadi teks Indonesia panjang
        function formatTanggalIndo(tanggalStr) {
            if (!tanggalStr) return '';

            const bulan = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            const hariNama = [
                'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
            ];

            const d = new Date(tanggalStr + 'T00:00:00');

            return `${hariNama[d.getDay()]}, ${d.getDate()} ${bulan[d.getMonth()]} ${d.getFullYear()}`;
        }

        // Ubah jam "HH:MM" jadi total menit, untuk perbandingan rentang waktu
        function parseMenit(waktuStr) {
            const [h, m] = waktuStr.split(':').map(Number);
            return h * 60 + m;
        }

        // Filter baris jadwal berdasarkan maskapai & rentang waktu berangkat
        function filterJadwal() {
            const maskapaiFilter = document.getElementById('filterMaskapai').value;
            const waktuFilter = document.getElementById('filterWaktu').value;

            let rentang = null;
            if (waktuFilter) {
                const [dari, sampai] = waktuFilter.split('-');
                rentang = {
                    dari: parseMenit(dari),
                    sampai: parseMenit(sampai)
                };
            }

            let tampil = 0;
            const semuaRow = document.querySelectorAll('.jadwal-row');

            semuaRow.forEach(function(row) {
                const maskapaiId = row.dataset.maskapaiId;
                const berangkatMenit = parseMenit(row.dataset.berangkat);

                const cocokMaskapai = !maskapaiFilter || maskapaiId === maskapaiFilter;
                const cocokWaktu = !rentang || (berangkatMenit >= rentang.dari && berangkatMenit <= rentang.sampai);

                const checkbox = row.querySelector('.jadwal-checkbox');

                if (cocokMaskapai && cocokWaktu) {
                    row.classList.remove('d-none');
                    tampil++;
                } else {
                    row.classList.add('d-none');
                    // Baris yang tersembunyi otomatis di-uncheck supaya tidak ikut ke gambar
                    if (checkbox) checkbox.checked = false;
                }
            });

            syncCheckAllState();

            const info = document.getElementById('filterInfoText');
            if (info) {
                info.textContent = `Menampilkan ${tampil} dari ${semuaRow.length} jadwal`;
            }
        }

        // Reset kedua filter dan tampilkan semua baris kembali
        function resetFilterJadwal() {
            document.getElementById('filterMaskapai').value = '';
            document.getElementById('filterWaktu').value = '';

            document.querySelectorAll('.jadwal-row').forEach(function(row) {
                row.classList.remove('d-none');
                const checkbox = row.querySelector('.jadwal-checkbox');
                if (checkbox) checkbox.checked = true;
            });

            syncCheckAllState();

            const info = document.getElementById('filterInfoText');
            if (info) info.textContent = '';
        }

        // Centang / hapus centang semua baris jadwal yang sedang terlihat
        function toggleAllJadwal(source) {
            document.querySelectorAll('.jadwal-row:not(.d-none) .jadwal-checkbox').forEach(function(cb) {
                cb.checked = source.checked;
            });
        }

        // Jika salah satu baris di-uncheck manual, sinkronkan status "pilih semua" (hanya baris terlihat)
        function syncCheckAllState() {
            const semua = document.querySelectorAll('.jadwal-row:not(.d-none) .jadwal-checkbox');
            const dicentang = document.querySelectorAll('.jadwal-row:not(.d-none) .jadwal-checkbox:checked');
            const checkAll = document.getElementById('checkAllMaskapai');

            if (checkAll) {
                checkAll.checked = semua.length > 0 && dicentang.length === semua.length;
            }
        }

        // Tukar wilayah asal <-> tujuan lalu submit ulang filter
        function tukarWilayah() {
            const asalSelect = document.getElementById('wilayahAsalSelect');
            const tujuanSelect = document.getElementById('wilayahTujuanSelect');

            const temp = asalSelect.value;
            asalSelect.value = tujuanSelect.value;
            tujuanSelect.value = temp;

            document.getElementById('filterWilayahForm').submit();
        }

        function generateGambarPenerbangan() {

            const tanggalInput = document.getElementById('tanggalPenerbangan').value;
            document.getElementById('imgTanggalLabel').innerText =
                formatTanggalIndo(tanggalInput) || 'Tanggal belum dipilih';

            const rows = document.querySelectorAll('.jadwal-row');
            const bodyContainer = document.getElementById('imgBodyRows');
            bodyContainer.innerHTML = '';

            let adaHargaKosong = false;
            let adaBarisTercentang = false;

            rows.forEach(function(row) {

                const checkbox = row.querySelector('.jadwal-checkbox');

                // Lewati baris yang tidak dicentang (termasuk yang sedang difilter/disembunyikan)
                if (!checkbox || !checkbox.checked) {
                    return;
                }

                adaBarisTercentang = true;

                const maskapai = row.dataset.maskapai;
                const kode = row.dataset.kode;
                const logo = row.dataset.logo;
                const berangkat = row.dataset.berangkat;
                const tiba = row.dataset.tiba;
                const durasi = row.dataset.durasi;

                const hargaInput = row.querySelector('.harga-jadwal').value.trim();

                if (!hargaInput) {
                    adaHargaKosong = true;
                }

                const hargaTampil = hargaInput ?
                    'Rp ' + hargaInput :
                    'Hubungi kami';

                const logoHtml = logo ?
                    `<img src="${logo}" class="logo" crossorigin="anonymous">` :
                    `<div class="logo" style="display:flex;align-items:center;justify-content:center;background:#F6F4EE;font-size:11px;font-weight:700;">${kode ?? ''}</div>`;

                bodyContainer.insertAdjacentHTML('beforeend', `
                <div class="kt-img-row">

                    <div class="kt-img-row-top">

                        <div class="kt-img-maskapai">
                            ${logoHtml}
                            <div>
                                <div class="nama">${maskapai}</div>
                                <div class="kode">${kode}</div>
                            </div>
                        </div>

                        <div class="kt-img-harga">
                            ${hargaTampil}
                        </div>

                    </div>

                    <div class="kt-img-row-bottom">
                        <div class="kt-img-jam">
                            <div class="waktu">${berangkat} &rarr; ${tiba}</div>
                        </div>
                        <div class="durasi">${durasi}</div>
                    </div>

                </div>
            `);

            });

            if (!adaBarisTercentang) {
                alert('Pilih minimal satu penerbangan (centang) untuk digenerate ke gambar.');
                return;
            }

            if (adaHargaKosong) {
                const lanjut = confirm('Ada penerbangan yang belum diisi harga. Lanjutkan generate gambar?');
                if (!lanjut) return;
            }

            const target = document.getElementById('ticketTemplate');

            // Tampilkan sementara di posisi normal supaya html2canvas render dengan benar
            target.style.position = 'absolute';
            target.style.top = '0';
            target.style.left = '0';
            target.style.zIndex = '-1';

            html2canvas(target, {
                backgroundColor: '#ffffff',
                scale: 2.25,
                useCORS: true,
                windowWidth: 480
            }).then(function(canvas) {

                // Kembalikan ke posisi tersembunyi
                target.style.position = 'fixed';
                target.style.top = '-99999px';
                target.style.left = '-99999px';

                const link = document.createElement('a');
                const asalKode = '{{ $asal->code_iata ?? '' }}';
                const tujuanKode = '{{ $tujuan->code_iata ?? '' }}';

                link.download = `Penerbangan_${asalKode}_${tujuanKode}_${tanggalInput || 'tanpa-tanggal'}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();

            }).catch(function(err) {
                target.style.position = 'fixed';
                target.style.top = '-99999px';
                target.style.left = '-99999px';

                alert('Gagal generate gambar. Coba lagi.');
                console.error(err);
            });
        }
    </script>
@endpush
