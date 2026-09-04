@extends('layouts.app')

@section('title', 'Tambah Maskapai')

@section('content')
    <h4 class="section-title mb-3"><i class="bi bi-plus-circle me-2"></i>Tambah Maskapai</h4>

    <div class="card card-section">
        <div class="card-body">
            <form action="{{ route('travel.maskapai.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Maskapai</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="Super Air Jet" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kode IATA</label>
                        <input type="text" name="code_iata" class="form-control text-uppercase"
                            value="{{ old('code_iata') }}" placeholder="IU" maxlength="10" required>
                        @error('code_iata')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kode ICAO</label>
                        <input type="text" name="code_icao" class="form-control text-uppercase"
                            value="{{ old('code_icao') }}" placeholder="SJV" maxlength="10" required>
                        @error('code_icao')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Logo Maskapai</label>
                    <input type="file" name="logo" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <small class="text-muted">Opsional. Format PNG/JPG/WEBP, maks. 2MB. Otomatis dipakai di PDF
                        e-ticket.</small>
                    @error('logo')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <a href="{{ route('travel.maskapai.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-success"><i class="bi bi-save2-fill me-1"></i>Simpan</button>
            </form>
        </div>
    </div>
@endsection
