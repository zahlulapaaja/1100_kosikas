@extends('layouts.app')

@section('title', 'Master Wilayah')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h4 class="section-title mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Master Wilayah</h4>
            <small class="text-muted">Kelola data wilayah dan bandara</small>
        </div>
        <a href="{{ route('travel.wilayah.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>Tambah Wilayah
        </a>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card card-section h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="bi bi-geo-alt-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-semibold mb-0">{{ $wilayahs->total() }}</div>
                        <small class="text-muted">Total Wilayah</small>
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
                            placeholder="Cari nama kota atau kode bandara...">
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
                <div class="col-md-2 d-grid">
                    <a href="{{ route('travel.wilayah.index') }}" class="btn btn-outline-secondary">
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
                            <th style="width:90px;">IATA</th>
                            <th style="width:90px;">ICAO</th>
                            <th>Bandara</th>
                            <th>Kota</th>
                            <th style="width:140px;">Negara</th>
                            <th style="width:110px;">Tipe</th>
                            <th class="text-end" style="width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($wilayahs as $w)
                            <tr>
                                <td><span
                                        class="badge bg-secondary-subtle text-secondary-emphasis fw-semibold">{{ $w->code_iata }}</span>
                                </td>
                                <td><span
                                        class="badge bg-secondary-subtle text-secondary-emphasis fw-semibold">{{ $w->code_icao }}</span>
                                </td>
                                <td class="fw-medium">{{ $w->airport_name }}</td>
                                <td>{{ $w->city_name }}</td>
                                <td>{{ $w->country }}</td>
                                <td>
                                    <span
                                        class="badge {{ $w->type === 'international' ? 'bg-info-subtle text-info-emphasis' : 'bg-light text-dark' }}">
                                        {{ ucfirst($w->type) }}
                                    </span>
                                    @unless ($w->is_active)
                                        <span class="badge bg-danger-subtle text-danger-emphasis">Nonaktif</span>
                                    @endunless
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('travel.wilayah.edit', $w) }}" class="btn btn-sm btn-outline-primary"
                                        title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('travel.wilayah.destroy', $w) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus wilayah {{ $w->city_name }}?');">
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
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Belum ada data wilayah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($wilayahs->hasPages())
            <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                <small class="text-muted">
                    Menampilkan {{ $wilayahs->firstItem() }}–{{ $wilayahs->lastItem() }}
                    dari {{ $wilayahs->total() }} data
                </small>
                {{ $wilayahs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

@endsection
