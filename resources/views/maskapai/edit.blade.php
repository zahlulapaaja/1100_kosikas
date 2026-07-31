@extends('layouts.app')

@section('title', 'Edit Maskapai')

@section('content')
    <h4 class="section-title mb-3"><i class="bi bi-pencil-square me-2"></i>Edit Maskapai</h4>

    <div class="card card-section">
        <div class="card-body">
            <form action="{{ route('maskapai.update', $maskapai) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Maskapai</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $maskapai->name) }}" required>
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Kode Maskapai</label>
                    <input type="text" name="code" class="form-control text-uppercase" value="{{ old('code', $maskapai->code) }}" maxlength="10" required>
                    @error('code') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <a href="{{ route('maskapai.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-success"><i class="bi bi-save2-fill me-1"></i>Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
