@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <a href="{{ route('travel.penerbangan.index', [
            'wilayah_asal_id' => $wilayahAsal->id,
            'wilayah_tujuan_id' => $wilayahTujuan->id,
        ]) }}"
           class="text-decoration-none">

            ← Kembali ke Daftar Penerbangan

        </a>

        <h4 class="mt-3 mb-1">
            Tambah Jadwal Penerbangan
        </h4>

        <p class="text-muted">
            Tambahkan jadwal penerbangan untuk rute berikut.
        </p>

    </div>


    <div class="row">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <form method="POST"
                          action="{{ route('travel.penerbangan.store') }}">

                        @csrf


                        {{-- Wilayah asal --}}
                        <input type="hidden"
                               name="wilayah_asal_id"
                               value="{{ $wilayahAsal->id }}">


                        {{-- Wilayah tujuan --}}
                        <input type="hidden"
                               name="wilayah_tujuan_id"
                               value="{{ $wilayahTujuan->id }}">


                        {{-- Rute --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Rute Penerbangan
                            </label>

                            <div class="border rounded p-3">

                                <div class="row align-items-center text-center">

                                    <div class="col">

                                        <div class="fs-3 fw-bold">
                                            {{ $wilayahAsal->code_iata }}
                                        </div>

                                        <div>
                                            {{ $wilayahAsal->city_name }}
                                        </div>

                                    </div>

                                    <div class="col-auto">

                                        <i class="bi bi-arrow-right fs-3"></i>

                                    </div>

                                    <div class="col">

                                        <div class="fs-3 fw-bold">
                                            {{ $wilayahTujuan->code_iata }}
                                        </div>

                                        <div>
                                            {{ $wilayahTujuan->city_name }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Maskapai --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Maskapai
                            </label>

                            <select name="maskapai_id"
                                    class="form-select @error('maskapai_id') is-invalid @enderror"
                                    required>

                                <option value="">
                                    -- Pilih Maskapai --
                                </option>

                                @foreach ($maskapais as $maskapai)

                                    <option value="{{ $maskapai->id }}"
                                        @selected(old('maskapai_id') == $maskapai->id)>

                                        {{ $maskapai->name }}
                                        ({{ $maskapai->code_iata }})

                                    </option>

                                @endforeach

                            </select>

                            @error('maskapai_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="row">

                            {{-- Jam berangkat --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">
                                    Jam Berangkat
                                </label>

                                <input type="time"
                                       name="jam_berangkat"
                                       value="{{ old('jam_berangkat') }}"
                                       class="form-control @error('jam_berangkat') is-invalid @enderror"
                                       required>

                                @error('jam_berangkat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Jam sampai --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">
                                    Jam Sampai
                                </label>

                                <input type="time"
                                       name="jam_sampai"
                                       value="{{ old('jam_sampai') }}"
                                       class="form-control @error('jam_sampai') is-invalid @enderror"
                                       required>

                                @error('jam_sampai')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        <div class="d-flex justify-content-end gap-2 mt-3">

                            <a href="{{ route('travel.penerbangan.index', [
                                'wilayah_asal_id' => $wilayahAsal->id,
                                'wilayah_tujuan_id' => $wilayahTujuan->id,
                            ]) }}"
                               class="btn btn-light">

                                Batal

                            </a>

                            <button type="submit"
                                    class="btn btn-primary">

                                <i class="bi bi-save"></i>
                                Simpan Jadwal

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- Informasi --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h6 class="fw-bold">
                        Informasi Rute
                    </h6>

                    <hr>

                    <div class="mb-3">

                        <small class="text-muted">
                            Dari
                        </small>

                        <div class="fw-semibold">
                            {{ $wilayahAsal->airport_name }}
                        </div>

                        <div>
                            {{ $wilayahAsal->city_name }}
                            ({{ $wilayahAsal->code_iata }})
                        </div>

                    </div>


                    <div>

                        <small class="text-muted">
                            Ke
                        </small>

                        <div class="fw-semibold">
                            {{ $wilayahTujuan->airport_name }}
                        </div>

                        <div>
                            {{ $wilayahTujuan->city_name }}
                            ({{ $wilayahTujuan->code_iata }})
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<script>
    document.querySelector('form[action="{{ route('travel.penerbangan.store') }}"]')
        .addEventListener('submit', function (e) {
            const btn = this.querySelector('button[type="submit"]');
            if (btn.disabled) {
                e.preventDefault();
                return;
            }
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';
        });
</script>
@endsection