@extends('layouts.app')

@section('title', 'Edit Maskapai')

@section('content')
    <h4 class="section-title mb-3"><i class="bi bi-pencil-square me-2"></i>Edit Maskapai</h4>

    <div class="card card-section">
        <div class="card-body">
            <form action="{{ route('travel.maskapai.update', $maskapai) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Maskapai</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $maskapai->name) }}"
                        required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kode IATA</label>
                        <input type="text" name="code_iata" class="form-control text-uppercase"
                            value="{{ old('code_iata', $maskapai->code_iata) }}" maxlength="10" required>
                        @error('code_iata')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kode ICAO</label>
                        <input type="text" name="code_icao" class="form-control text-uppercase"
                            value="{{ old('code_icao', $maskapai->code_icao) }}" maxlength="10" required>
                        @error('code_icao')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Logo Maskapai</label>

                    @if ($maskapai->logo)
                        <div class="mb-2">
                            <img src="{{ asset($maskapai->logo) }}" alt="{{ $maskapai->name }}"
                                style="width:64px;height:64px;object-fit:contain;border:1px solid #e9ecef;border-radius:8px;padding:6px;background:#fff;">
                            <div class="form-text">Logo saat ini. Upload file baru untuk menggantinya.</div>
                        </div>
                    @endif

                    <input type="file" name="logo" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <small class="text-muted">Opsional. Format PNG/JPG/WEBP, maks. 2MB. Otomatis dipakai di PDF
                        e-ticket.</small>
                    @error('logo')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <a href="{{ route('travel.maskapai.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-success"><i class="bi bi-save2-fill me-1"></i>Simpan
                    Perubahan</button>
            </form>
        </div>
    </div>
@endsection
