@extends('layouts.app')

@section('title', 'Input Data E-Ticket')

@section('content')

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

    <form action="{{ route('eticket.generate') }}" method="POST" target="_blank">
        @csrf

        {{-- Data Agen --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <h5 class="section-title mb-3"><i class="bi bi-briefcase-fill me-2"></i>Data Agen / Travel</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Agen / Travel</label>
                        <input type="text" name="agency_name" class="form-control" value="{{ old('agency_name', 'KOSIKAS TRAVEL') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tagline</label>
                        <input type="text" name="agency_tagline" class="form-control" value="{{ old('agency_tagline', 'Teman Setia Perjalanan Anda') }}">
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
                        <input type="text" name="pnr" class="form-control text-uppercase" value="{{ old('pnr') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Diterbitkan</label>
                        <input type="date" name="issued_date" class="form-control" value="{{ old('issued_date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Mata Uang</label>
                        <input type="text" name="currency" class="form-control" value="{{ old('currency', 'IDR') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Total Fare</label>
                        <input type="number" step="0.01" name="total_fare" class="form-control" value="{{ old('total_fare') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Catatan Fare (opsional)</label>
                        <input type="text" name="fare_note" class="form-control" value="{{ old('fare_note', 'Includes Base Fare, Taxes, Fees and Surcharges') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Penerbangan --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0"><i class="bi bi-airplane-engines-fill me-2"></i>Detail Penerbangan</h5>
                    <button type="button" id="addFlight" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Tambah Penerbangan</button>
                </div>
                <div id="flightWrapper"></div>
            </div>
        </div>

        {{-- Detail Penumpang --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0"><i class="bi bi-people-fill me-2"></i>Detail Penumpang</h5>
                    <button type="button" id="addPassenger" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Tambah Penumpang</button>
                </div>
                <div id="passengerWrapper"></div>
            </div>
        </div>

        <div class="text-end mb-5">
            <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-file-earmark-pdf-fill me-2"></i>Buat E-Ticket (PDF)</button>
        </div>
    </form>

@endsection

@section('scripts')
<script>
let flightIndex = 0;
let passengerIndex = 0;

function flightTemplate(i) {
    return `
    <div class="segment-block" data-flight-index="${i}">
        <button type="button" class="btn btn-sm btn-outline-danger btn-remove remove-flight"><i class="bi bi-x-lg"></i></button>
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">No. Penerbangan</label>
                <input type="text" name="flights[${i}][flight_no]" class="form-control" placeholder="IU 995" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Maskapai</label>
                <input type="text" name="flights[${i}][airline]" class="form-control" placeholder="Super Air Jet" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Berangkat</label>
                <input type="date" name="flights[${i}][departure_date]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Sub Class</label>
                <input type="text" name="flights[${i}][subclass]" class="form-control" placeholder="K" maxlength="5">
            </div>

            <div class="col-md-4">
                <label class="form-label">Kota Asal</label>
                <input type="text" name="flights[${i}][origin_city]" class="form-control" placeholder="Banda Aceh" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Kode Asal</label>
                <input type="text" name="flights[${i}][origin_code]" class="form-control text-uppercase" placeholder="BTJ" maxlength="5" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Jam Berangkat</label>
                <input type="time" name="flights[${i}][dep_time]" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Kota Tujuan</label>
                <input type="text" name="flights[${i}][destination_city]" class="form-control" placeholder="Jakarta" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Kode Tujuan</label>
                <input type="text" name="flights[${i}][destination_code]" class="form-control text-uppercase" placeholder="CGK" maxlength="5" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Jam Tiba</label>
                <input type="time" name="flights[${i}][arr_time]" class="form-control" required>
            </div>
        </div>
    </div>`;
}

function passengerTemplate(i) {
    return `
    <div class="passenger-block" data-passenger-index="${i}">
        <button type="button" class="btn btn-sm btn-outline-danger btn-remove remove-passenger"><i class="bi bi-x-lg"></i></button>
        <div class="row g-3">
            <div class="col-md-2">
                <label class="form-label">Gelar</label>
                <select name="passengers[${i}][title]" class="form-select">
                    <option value="Mr.">Mr.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Ms.">Ms.</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nama Penumpang</label>
                <input type="text" name="passengers[${i}][name]" class="form-control" placeholder="Dina Nirmala Sari" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tipe</label>
                <select name="passengers[${i}][type]" class="form-select">
                    <option value="Adult">Adult</option>
                    <option value="Child">Child</option>
                    <option value="Infant">Infant</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">No. Identitas (KTP/Paspor)</label>
                <input type="text" name="passengers[${i}][id_number]" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Nomor Tiket</label>
                <input type="text" name="passengers[${i}][ticket_number]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Bagasi</label>
                <input type="text" name="passengers[${i}][baggage]" class="form-control" placeholder="10Kg">
            </div>
        </div>
    </div>`;
}

function addFlight() {
    document.getElementById('flightWrapper').insertAdjacentHTML('beforeend', flightTemplate(flightIndex));
    flightIndex++;
}
function addPassenger() {
    document.getElementById('passengerWrapper').insertAdjacentHTML('beforeend', passengerTemplate(passengerIndex));
    passengerIndex++;
}

document.getElementById('addFlight').addEventListener('click', addFlight);
document.getElementById('addPassenger').addEventListener('click', addPassenger);

document.getElementById('flightWrapper').addEventListener('click', function (e) {
    if (e.target.closest('.remove-flight')) {
        e.target.closest('.segment-block').remove();
    }
});
document.getElementById('passengerWrapper').addEventListener('click', function (e) {
    if (e.target.closest('.remove-passenger')) {
        e.target.closest('.passenger-block').remove();
    }
});

// Mulai dengan 1 penerbangan dan 1 penumpang secara default
addFlight();
addPassenger();
</script>
@endsection
