@extends('layouts.app')

@section('title', 'Daftar E-Ticket')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title mb-0"><i class="bi bi-ticket-perforated-fill me-2"></i>Daftar E-Ticket</h4>
        <a href="{{ route('travel.bookings.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>Buat E-Ticket Baru
        </a>
    </div>

    <div class="card card-section mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-9">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                        placeholder="Cari berdasarkan PNR atau nama penumpang...">
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
                        <th>PNR</th>
                        <th>Tanggal Terbit</th>
                        <th>Jumlah Penerbangan</th>
                        <th>Jumlah Penumpang</th>
                        <th>Total Fare</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td><span class="badge bg-primary">{{ $booking->pnr }}</span></td>
                            <td>{{ $booking->issued_date->translatedFormat('d M Y') }}</td>
                            <td>{{ $booking->flights_count }}</td>
                            <td>{{ $booking->passengers_count }}</td>
                            <td>{{ $booking->currency }} {{ number_format($booking->total_fare, 0, ',', '.') }}</td>
                            <td class="text-end">
                                <a href="{{ route('travel.bookings.pdf', $booking) }}" target="_blank"
                                    class="btn btn-sm btn-outline-danger" title="Cetak PDF">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>

                                @if ($booking->lion_air_tracking_url)
                                    <a href="{{ $booking->lion_air_tracking_url }}" target="_blank"
                                        class="btn btn-sm btn-outline-info" title="Cek Status Booking Lion Air">
                                        <i class="bi bi-airplane-engines"></i>
                                    </a>
                                @endif

                                @if ($booking->garuda_tracking_url)
                                    <a href="{{ $booking->garuda_tracking_url }}" target="_blank"
                                        class="btn btn-sm btn-outline-success" title="Cek Status Booking Garuda Indonesia">
                                        <i class="bi bi-airplane-engines"></i>
                                    </a>
                                @endif

                                <form action="{{ route('travel.bookings.duplicate', $booking) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Duplikat e-ticket dengan PNR {{ $booking->pnr }}? Data penerbangan &amp; penumpang akan disalin ke draft baru.');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Duplikat">
                                        <i class="bi bi-files"></i>
                                    </button>
                                </form>

                                <a href="{{ route('travel.bookings.edit', $booking) }}"
                                    class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('travel.bookings.destroy', $booking) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus e-ticket dengan PNR {{ $booking->pnr }}?');">
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
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data e-ticket.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($bookings->hasPages())
            <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                <small class="text-muted">
                    Menampilkan {{ $bookings->firstItem() }}–{{ $bookings->lastItem() }}
                    dari {{ $bookings->total() }} data
                </small>
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

@endsection
