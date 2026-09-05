@extends('layouts.app')

@section('title', $booking ? 'Edit E-Ticket' : 'Buat E-Ticket Baru')

@section('content')

    <h4 class="section-title mb-3">
        <i class="bi bi-{{ $booking ? 'pencil-square' : 'file-earmark-plus' }} me-2"></i>
        {{ $booking ? 'Edit E-Ticket - ' . $booking->pnr : 'Buat E-Ticket Baru' }}
    </h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali isian Anda:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($maskapais->isEmpty() || $wilayahs->isEmpty())
        <div class="alert alert-warning">
            Master <strong>Maskapai</strong> dan/atau <strong>Wilayah</strong> masih kosong.
            Silakan tambahkan data master terlebih dahulu di menu
            <a href="{{ route('travel.maskapai.index') }}">Master Maskapai</a> dan
            <a href="{{ route('travel.wilayah.index') }}">Master Wilayah</a>.
        </div>
    @endif

    <form action="{{ $booking ? route('travel.bookings.update', $booking) : route('travel.bookings.store') }}" method="POST">
        @csrf
        @if ($booking)
            @method('PUT')
        @endif

        {{-- Data Agen --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <h5 class="section-title mb-3"><i class="bi bi-briefcase-fill me-2"></i>Data Agen / Travel</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Agen / Travel</label>
                        <input type="text" name="agency_name" class="form-control"
                            value="{{ old('agency_name', $booking->agency_name ?? 'KOSIKAS TRAVEL') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tagline</label>
                        <input type="text" name="agency_tagline" class="form-control"
                            value="{{ old('agency_tagline', $booking->agency_tagline ?? 'Teman Setia Perjalanan Anda') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Booking --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <h5 class="section-title mb-3"><i class="bi bi-journal-bookmark-fill me-2"></i>Data Booking</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Booking Reference (PNR)</label>
                        <input type="text" name="pnr" class="form-control text-uppercase"
                            value="{{ old('pnr', $booking->pnr ?? '') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Diterbitkan</label>
                        <input type="date" name="issued_date" class="form-control"
                            value="{{ old('issued_date', isset($booking) ? $booking->issued_date->format('Y-m-d') : date('Y-m-d')) }}"
                            required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Mata Uang</label>
                        <input type="text" name="currency" class="form-control"
                            value="{{ old('currency', $booking->currency ?? 'IDR') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Total Fare</label>
                        <input type="number" step="0.01" name="total_fare" class="form-control"
                            value="{{ old('total_fare', $booking->total_fare ?? '') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Catatan Fare (opsional)</label>
                        <input type="text" name="fare_note" class="form-control"
                            value="{{ old('fare_note', $booking->fare_note ?? 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Penerbangan --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0"><i class="bi bi-airplane-engines-fill me-2"></i>Detail Penerbangan</h5>
                    <button type="button" id="addFlight" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i>
                        Tambah Penerbangan</button>
                </div>
                <div id="flightWrapper"></div>
            </div>
        </div>

        {{-- Detail Penumpang --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0"><i class="bi bi-people-fill me-2"></i>Detail Penumpang</h5>
                    <button type="button" id="addPassenger" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i>
                        Tambah Penumpang</button>
                </div>
                <div id="passengerWrapper"></div>
            </div>
        </div>

        <div class="text-end mb-5">
            <a href="{{ route('travel.bookings.index') }}" class="btn btn-outline-secondary btn-lg">Batal</a>
            <button type="submit" class="btn btn-success btn-lg">
                <i class="bi bi-save2-fill me-2"></i>{{ $booking ? 'Simpan Perubahan' : 'Simpan E-Ticket' }}
            </button>
        </div>
    </form>

@endsection

@section('scripts')
    <script>
        const maskapaiList = @json($maskapaiOptions);
        const wilayahList = @json($wilayahOptions);
        const existingFlights = @json($existingFlights);
        const existingPassengers = @json($existingPassengers);

        let flightIndex = 0;
        let passengerIndex = 0;

        function buildOptions(list, selectedId) {
            return list.map(item =>
                `<option value="${item.id}" ${String(item.id) === String(selectedId) ? 'selected' : ''}>${item.label}</option>`
            ).join('');
        }

        function flightTemplate(i, f = {}) {
            return `
    <div class="segment-block" data-flight-index="${i}">
        <button type="button" class="btn btn-sm btn-outline-danger btn-remove remove-flight"><i class="bi bi-x-lg"></i></button>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Maskapai</label>
                <select name="flights[${i}][maskapai_id]" class="form-select" required>
                    <option value="">-- Pilih Maskapai --</option>
                    ${buildOptions(maskapaiList, f.maskapai_id)}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">No. Penerbangan</label>
                <input type="text" name="flights[${i}][flight_no]" class="form-control" placeholder="000" value="${f.flight_no ?? ''}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Berangkat</label>
                <input type="date" name="flights[${i}][departure_date]" class="form-control" value="${f.departure_date ?? ''}" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Sub Class</label>
                <input type="text" name="flights[${i}][subclass]" class="form-control" placeholder="" maxlength="5" value="${f.subclass ?? ''}">
            </div>

            <div class="col-md-5">
                <label class="form-label">Asal (Wilayah)</label>
                <select name="flights[${i}][origin_wilayah_id]" class="form-select" required>
                    <option value="">-- Pilih Wilayah Asal --</option>
                    ${buildOptions(wilayahList, f.origin_wilayah_id)}
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Jam Berangkat</label>
                <input type="time" name="flights[${i}][dep_time]" class="form-control" value="${f.dep_time ?? ''}" required>
            </div>
            <div class="col-md-5">
                <label class="form-label">Tujuan (Wilayah)</label>
                <select name="flights[${i}][destination_wilayah_id]" class="form-select" required>
                    <option value="">-- Pilih Wilayah Tujuan --</option>
                    ${buildOptions(wilayahList, f.destination_wilayah_id)}
                </select>
            </div>
            <div class="col-md-2 offset-md-10">
                <label class="form-label">Jam Tiba</label>
                <input type="time" name="flights[${i}][arr_time]" class="form-control" value="${f.arr_time ?? ''}" required>
            </div>
        </div>
    </div>`;
        }

        function passengerTemplate(i, p = {}) {
            const titleOptions = ['Mr.', 'Mrs.', 'Ms.'].map(t =>
                `<option value="${t}" ${p.title === t ? 'selected' : ''}>${t}</option>`).join('');
            const typeOptions = ['Adult', 'Child', 'Infant'].map(t =>
                `<option value="${t}" ${p.type === t ? 'selected' : ''}>${t}</option>`).join('');

            return `
    <div class="passenger-block" data-passenger-index="${i}">
        <button type="button" class="btn btn-sm btn-outline-danger btn-remove remove-passenger"><i class="bi bi-x-lg"></i></button>
        <div class="row g-3">
            <div class="col-md-2">
                <label class="form-label">Gelar</label>
                <select name="passengers[${i}][title]" class="form-select">${titleOptions}</select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nama Penumpang</label>
                <input type="text" name="passengers[${i}][name]" class="form-control" value="${p.name ?? ''}" placeholder="masukkan nama..." required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tipe</label>
                <select name="passengers[${i}][type]" class="form-select">${typeOptions}</select>
            </div>
            <div class="col-md-4">
                <label class="form-label">No. Identitas (KTP/Paspor)</label>
                <input type="text" name="passengers[${i}][id_number]" placeholder="opsional..." class="form-control" value="${p.id_number ?? ''}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Nomor Tiket</label>
                <input type="text" name="passengers[${i}][ticket_number]" class="form-control" value="${p.ticket_number ?? ''}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Bagasi</label>
                <input type="text" name="passengers[${i}][baggage]" class="form-control" placeholder="20Kg / 1PC" value="${p.baggage ?? ''}">
            </div>
        </div>
    </div>`;
        }

        function addFlight(data = {}) {
            document.getElementById('flightWrapper').insertAdjacentHTML('beforeend', flightTemplate(flightIndex, data));
            flightIndex++;
        }

        function addPassenger(data = {}) {
            document.getElementById('passengerWrapper').insertAdjacentHTML('beforeend', passengerTemplate(passengerIndex,
                data));
            passengerIndex++;
        }

        document.getElementById('addFlight').addEventListener('click', () => addFlight());
        document.getElementById('addPassenger').addEventListener('click', () => addPassenger());

        document.getElementById('flightWrapper').addEventListener('click', function(e) {
            if (e.target.closest('.remove-flight')) e.target.closest('.segment-block').remove();
        });
        document.getElementById('passengerWrapper').addEventListener('click', function(e) {
            if (e.target.closest('.remove-passenger')) e.target.closest('.passenger-block').remove();
        });

        // Isi baris awal: dari data lama (edit / old input) atau satu baris kosong (create)
        if (existingFlights.length) {
            existingFlights.forEach(f => addFlight(f));
        } else {
            addFlight();
        }

        if (existingPassengers.length) {
            existingPassengers.forEach(p => addPassenger(p));
        } else {
            addPassenger();
        }
    </script>
@endsection
