@extends('layouts.app')

@section('title', 'Master Wilayah')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Master Wilayah</h4>
        <a href="{{ route('wilayah.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>Tambah Wilayah
        </a>
    </div>

    <div class="card card-section mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-9">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama kota atau kode bandara...">
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
                        <th>Kode Bandara</th>
                        <th>Nama Kota</th>
                        <th>Negara</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($wilayahs as $w)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $w->airport_code }}</span></td>
                            <td>{{ $w->city_name }}</td>
                            <td>{{ $w->country }}</td>
                            <td class="text-end">
                                <a href="{{ route('wilayah.edit', $w) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('wilayah.destroy', $w) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus wilayah {{ $w->city_name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data wilayah.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($wilayahs->hasPages())
            <div class="card-footer bg-white">{{ $wilayahs->links() }}</div>
        @endif
    </div>

@endsection
