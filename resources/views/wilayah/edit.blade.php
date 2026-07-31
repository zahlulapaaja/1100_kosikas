@extends('layouts.app')

@section('title', 'Edit Wilayah')

@section('content')
    <h4 class="section-title mb-3"><i class="bi bi-pencil-square me-2"></i>Edit Wilayah</h4>

    <div class="card card-section">
        <div class="card-body">
            <form action="{{ route('wilayah.update', $wilayah) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Kota</label>
                    <input type="text" name="city_name" class="form-control" value="{{ old('city_name', $wilayah->city_name) }}" required>
                    @error('city_name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Kode Bandara</label>
                    <input type="text" name="airport_code" class="form-control text-uppercase" value="{{ old('airport_code', $wilayah->airport_code) }}" maxlength="5" required>
                    @error('airport_code') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Negara</label>
                    <input type="text" name="country" class="form-control" value="{{ old('country', $wilayah->country) }}">
                    @error('country') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <a href="{{ route('wilayah.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-success"><i class="bi bi-save2-fill me-1"></i>Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
