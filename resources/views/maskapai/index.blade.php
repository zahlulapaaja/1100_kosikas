@extends('layouts.app')

@section('title', 'Master Maskapai')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h4 class="section-title mb-0"><i class="bi bi-airplane-fill me-2"></i>Master Maskapai</h4>
            <small class="text-muted">Kelola data maskapai penerbangan</small>
        </div>
        <a href="{{ route('travel.maskapai.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>Tambah Maskapai
        </a>
    </div>

    {{-- Quick stats --}}
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card card-section h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="bi bi-airplane-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-semibold mb-0">{{ $maskapais->total() }}</div>
                        <small class="text-muted">Total Maskapai</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-section mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                            placeholder="Cari nama atau kode maskapai...">
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
                <div class="col-md-2 d-grid">
                    <a href="{{ route('travel.maskapai.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-section">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:130px;">Kode IATA</th>
                            <th style="width:130px;">Kode ICAO</th>
                            <th>Nama Maskapai</th>
                            <th style="width:180px;">Jumlah Penerbangan</th>
                            <th class="text-end" style="width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($maskapais as $m)
                            <tr>
                                <td><span
                                        class="badge bg-secondary-subtle text-secondary-emphasis fw-semibold">{{ $m->code_iata }}</span>
                                </td>
                                <td><span
                                        class="badge bg-secondary-subtle text-secondary-emphasis fw-semibold">{{ $m->code_icao }}</span>
                                </td>
                                <td class="fw-medium">{{ $m->name }}</td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary-emphasis">
                                        {{ $m->flights_count }} penerbangan
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('travel.maskapai.edit', $m) }}" class="btn btn-sm btn-outline-primary"
                                        title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('travel.maskapai.destroy', $m) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus maskapai {{ $m->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Belum ada data maskapai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($maskapais->hasPages())
            <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                <small class="text-muted">
                    Menampilkan {{ $maskapais->firstItem() }}–{{ $maskapais->lastItem() }}
                    dari {{ $maskapais->total() }} data
                </small>
                {{ $maskapais->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

@endsection
