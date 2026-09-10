@extends('layouts.app')

@section('title', 'Lengkapi Invoice')

@section('content')

    <h4 class="section-title mb-3"><i class="bi bi-receipt me-2"></i>Invoice
        {{ $invoice->invoice_code ?? '(belum ada kode)' }}</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('travel.invoices.update', $invoice) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Data Pemesan --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <h5 class="section-title mb-3"><i class="bi bi-person-fill me-2"></i>Data Pemesan</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Nama Pemesan</label>
                        <input type="text" class="form-control" value="{{ $invoice->orderer_name }}" disabled>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="orderer_address" class="form-control"
                            value="{{ old('orderer_address', $invoice->orderer_address) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="orderer_phone" class="form-control"
                            value="{{ old('orderer_phone', $invoice->orderer_phone) }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Ringkasan Tiket (read-only, dari booking yang dicentang) --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <h5 class="section-title mb-3"><i class="bi bi-airplane-engines-fill me-2"></i>Tiket Pesawat</h5>
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Penumpang</th>
                            <th>Maskapai</th>
                            <th>Rute</th>
                            <th>Waktu</th>
                            <th class="text-end">Harga Tiket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->flightItems as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->passenger_name }}</td>
                                <td>{{ $item->maskapai_name }}</td>
                                <td>{{ $item->route_text }}</td>
                                <td>{{ $item->flight_date_text }}</td>
                                <td class="text-end">{{ number_format($item->amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="form-text mt-2">Harga tiket otomatis diambil dari Total Fare tiap booking. Untuk mengubahnya,
                    edit e-ticket terkait.</div>
            </div>
        </div>

        {{-- Biaya Tambahan --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0"><i class="bi bi-plus-circle-fill me-2"></i>Biaya Tambahan
                        <span class="section-sub">(reschedule, refund, dll — isi negatif untuk pengurangan)</span>
                    </h5>
                    <button type="button" id="addExtra" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i>
                        Tambah</button>
                </div>
                <div id="extraWrapper"></div>
            </div>
        </div>

        <div class="text-end mb-5">
            <a href="{{ route('travel.bookings.index') }}" class="btn btn-outline-secondary btn-lg">Batal</a>
            <button type="submit" class="btn btn-success btn-lg">
                <i class="bi bi-file-earmark-pdf-fill me-2"></i>Simpan & Buat Invoice
            </button>
        </div>
    </form>

@endsection

@push('scripts')
    <script>
        const existingExtras = @json($invoice->extraItems->map(fn($e) => ['label' => $e->label, 'amount' => $e->amount])->values());
        let extraIndex = 0;

        function extraTemplate(i, e = {}) {
            return `
    <div class="row g-2 mb-2 align-items-center extra-row" data-extra-index="${i}">
        <div class="col-md-7">
            <input type="text" name="extras[${i}][label]" class="form-control" placeholder="Contoh: Biaya Reschedule / Refund Tiket" value="${e.label ?? ''}">
        </div>
        <div class="col-md-4">
            <input type="number" step="0.01" name="extras[${i}][amount]" class="form-control" placeholder="Jumlah (isi minus untuk refund)" value="${e.amount ?? ''}">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger remove-extra"><i class="bi bi-x-lg"></i></button>
        </div>
    </div>`;
        }

        function addExtra(data = {}) {
            document.getElementById('extraWrapper').insertAdjacentHTML('beforeend', extraTemplate(extraIndex, data));
            extraIndex++;
        }

        document.getElementById('addExtra').addEventListener('click', () => addExtra());
        document.getElementById('extraWrapper').addEventListener('click', function(e) {
            if (e.target.closest('.remove-extra')) e.target.closest('.extra-row').remove();
        });

        if (existingExtras.length) {
            existingExtras.forEach(e => addExtra(e));
        }
    </script>
@endpush
