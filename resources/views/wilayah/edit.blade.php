@extends('layouts.app')

@section('title', 'Edit Wilayah')

@section('content')
    <h4 class="section-title mb-3"><i class="bi bi-pencil-square me-2"></i>Edit Wilayah</h4>

    <div class="card card-section">
        <div class="card-body">
            <form action="{{ route('travel.wilayah.update', $wilayah) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Bandara</label>
                    <input type="text" name="airport_name" class="form-control"
                        value="{{ old('airport_name', $wilayah->airport_name) }}" required>
                    @error('airport_name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kode IATA</label>
                        <input type="text" name="code_iata" class="form-control text-uppercase"
                            value="{{ old('code_iata', $wilayah->code_iata) }}" maxlength="3" required>
                        @error('code_iata')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kode ICAO</label>
                        <input type="text" name="code_icao" class="form-control text-uppercase"
                            value="{{ old('code_icao', $wilayah->code_icao) }}" maxlength="4" required>
                        @error('code_icao')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Kota</label>
                        <input type="text" name="city_name" class="form-control"
                            value="{{ old('city_name', $wilayah->city_name) }}" required>
                        @error('city_name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Provinsi</label>
                        <input type="text" name="province_name" class="form-control"
                            value="{{ old('province_name', $wilayah->province_name) }}">
                        @error('province_name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Negara</label>
                    <input type="text" name="country" class="form-control"
                        value="{{ old('country', $wilayah->country) }}">
                    @error('country')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Latitude</label>
                        <input type="number" step="any" name="latitude" class="form-control"
                            value="{{ old('latitude', $wilayah->latitude) }}">
                        @error('latitude')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Longitude</label>
                        <input type="number" step="any" name="longitude" class="form-control"
                            value="{{ old('longitude', $wilayah->longitude) }}">
                        @error('longitude')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Timezone</label>
                        <input type="text" name="timezone" class="form-control"
                            value="{{ old('timezone', $wilayah->timezone) }}">
                        @error('timezone')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipe</label>
                        <select name="type" class="form-select" required>
                            <option value="domestic" {{ old('type', $wilayah->type) === 'domestic' ? 'selected' : '' }}>
                                Domestic</option>
                            <option value="international"
                                {{ old('type', $wilayah->type) === 'international' ? 'selected' : '' }}>International
                            </option>
                        </select>
                        @error('type')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
                                {{ old('is_active', $wilayah->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                </div>

                <a href="{{ route('travel.wilayah.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-success"><i class="bi bi-save2-fill me-1"></i>Simpan
                    Perubahan</button>
            </form>
        </div>
    </div>
@endsection
