@extends('layouts.app')

@section('title', 'Daftar Invoice')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title mb-0"><i class="bi bi-receipt me-2"></i>Daftar Invoice</h4>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#hotelInvoiceModal">
                <i class="bi bi-building me-1"></i>Buat Invoice Hotel
            </button>
            <a href="{{ route('travel.bookings.index') }}" class="btn btn-success">
                <i class="bi bi-plus-lg me-1"></i>Buat dari Daftar E-Ticket
            </a>
        </div>
    </div>

    <div class="modal fade" id="hotelInvoiceModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('travel.invoices.create-hotel') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Invoice Hotel Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Nama Pemesan</label>
                    <input type="text" name="orderer_name" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Lanjut Isi Data Hotel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-section mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-9">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                        placeholder="Cari berdasarkan kode invoice atau nama pemesan...">
                </div>
                <div class="col-md-3 d-grid">
                    <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search me-1"></i>Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-section">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode Invoice</th>
                        <th>Tanggal</th>
                        <th>Nama Pemesan</th>
                        <th>Jml. Tiket</th>
                        <th>Total Tagihan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td>
                                @if ($invoice->invoice_code)
                                    <span class="badge bg-primary">{{ $invoice->invoice_code }}</span>
                                @else
                                    <span class="badge bg-secondary">Belum ada kode</span>
                                @endif
                            </td>
                            <td>{{ $invoice->issued_date->translatedFormat('d M Y') }}</td>
                            <td>{{ $invoice->orderer_name ?: '-' }}</td>
                            <td>{{ $invoice->flight_items_count }}</td>
                            <td>Rp {{ number_format($invoice->items->sum('amount'), 0, ',', '.') }}</td>
                            <td class="text-end">
                                <a href="{{ route('travel.invoices.show', $invoice) }}" target="_blank"
                                    class="btn btn-sm btn-outline-danger" title="Lihat / Cetak PDF">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>

                                <a href="{{ route('travel.invoices.edit', $invoice) }}"
                                    class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('travel.invoices.destroy', $invoice) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Hapus invoice {{ $invoice->invoice_code ?? '' }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data invoice.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($invoices->hasPages())
            <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                <small class="text-muted">
                    Menampilkan {{ $invoices->firstItem() }}–{{ $invoices->lastItem() }}
                    dari {{ $invoices->total() }} data
                </small>
                {{ $invoices->links() }}
            </div>
        @endif
    </div>

@endsection
