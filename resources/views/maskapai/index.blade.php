@extends('layouts.app')

@section('title', 'Master Maskapai')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title mb-0"><i class="bi bi-airplane-fill me-2"></i>Master Maskapai</h4>
        <a href="{{ route('maskapai.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>Tambah Maskapai
        </a>
    </div>

    <div class="card card-section mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-9">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama atau kode maskapai...">
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
                        <th>Kode</th>
                        <th>Nama Maskapai</th>
                        <th>Jumlah Penerbangan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($maskapais as $m)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $m->code }}</span></td>
                            <td>{{ $m->name }}</td>
                            <td>{{ $m->flights_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('maskapai.edit', $m) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('maskapai.destroy', $m) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus maskapai {{ $m->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data maskapai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($maskapais->hasPages())
            <div class="card-footer bg-white">{{ $maskapais->links() }}</div>
        @endif
    </div>

@endsection
