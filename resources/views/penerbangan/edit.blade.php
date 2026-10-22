@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="mb-4">

            <a href="{{ route('travel.penerbangan.index', [
                'wilayah_asal_id' => $penerbangan->wilayah_asal_id,
                'wilayah_tujuan_id' => $penerbangan->wilayah_tujuan_id,
            ]) }}"
                class="text-decoration-none">

                ← Kembali ke Daftar Penerbangan

            </a>

            <h4 class="mt-3 mb-1">
                Edit Jadwal Penerbangan
            </h4>

            <p class="text-muted">
                Perbarui jadwal penerbangan untuk rute berikut.
            </p>

        </div>


        <div class="row">

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <form method="POST" action="{{ route('travel.penerbangan.update', $penerbangan) }}">

                            @csrf
                            @method('PUT')


                            {{-- Rute (read-only) --}}
                            <div class="mb-4">

                                <label class="form-label fw-semibold">
                                    Rute Penerbangan
                                </label>

                                <div class="border rounded p-3">

                                    <div class="row align-items-center text-center">

                                        <div class="col">

                                            <div class="fs-3 fw-bold">
                                                {{ $penerbangan->asal->code_iata }}
                                            </div>

                                            <div>
                                                {{ $penerbangan->asal->city_name }}
                                            </div>

                                        </div>

                                        <div class="col-auto">

                                            <i class="bi bi-arrow-right fs-3"></i>

                                        </div>

                                        <div class="col">

                                            <div class="fs-3 fw-bold">
                                                {{ $penerbangan->tujuan->code_iata }}
                                            </div>

                                            <div>
                                                {{ $penerbangan->tujuan->city_name }}
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

                                <select name="maskapai_id" class="form-select @error('maskapai_id') is-invalid @enderror"
                                    required>

                                    @foreach ($maskapais as $maskapai)
                                        <option value="{{ $maskapai->id }}" @selected(old('maskapai_id', $penerbangan->maskapai_id) == $maskapai->id)>

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

                                    <input type="time" name="jam_berangkat"
                                        value="{{ old('jam_berangkat', \Carbon\Carbon::parse($penerbangan->jam_berangkat)->format('H:i')) }}"
                                        class="form-control @error('jam_berangkat') is-invalid @enderror" required>

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

                                    <input type="time" name="jam_sampai"
                                        value="{{ old('jam_sampai', \Carbon\Carbon::parse($penerbangan->jam_sampai)->format('H:i')) }}"
                                        class="form-control @error('jam_sampai') is-invalid @enderror" required>

                                    @error('jam_sampai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>


                            {{-- Transit --}}
                            @php
                                // Setelah validasi gagal, ikuti input terakhir user.
                                // Saat pertama dibuka, ikuti data di database.
                                $punyaTransit = session()->hasOldInput()
                                    ? (bool) old('punya_transit')
                                    : (bool) $penerbangan->punya_transit;
                            @endphp

                            <div class="mb-3">

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" role="switch" id="punya_transit"
                                        name="punya_transit" value="1" @checked($punyaTransit)>
                                    <label class="form-check-label fw-semibold" for="punya_transit">
                                        Penerbangan ini transit
                                    </label>
                                </div>

                                <div id="transit-fields" class="border rounded p-3 {{ $punyaTransit ? '' : 'd-none' }}">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">Bandara Transit</label>

                                            <select name="transit_wilayah_id"
                                                class="form-select @error('transit_wilayah_id') is-invalid @enderror">
                                                <option value="">-- Pilih Bandara Transit --</option>

                                                @foreach ($wilayahTransits as $w)
                                                    <option value="{{ $w->id }}" @selected(old('transit_wilayah_id', $penerbangan->transit_wilayah_id) == $w->id)>
                                                        {{ $w->city_name }} ({{ $w->code_iata }}) -
                                                        {{ $w->airport_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('transit_wilayah_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">Lama Transit</label>

                                            <div class="input-group">
                                                <input type="number" name="transit_jam" min="0" max="23"
                                                    value="{{ old('transit_jam', intdiv($penerbangan->transit_durasi_menit ?? 0, 60)) }}"
                                                    class="form-control @error('transit_jam') is-invalid @enderror">
                                                <span class="input-group-text">jam</span>

                                                <input type="number" name="transit_menit" min="0" max="59"
                                                    value="{{ old('transit_menit', ($penerbangan->transit_durasi_menit ?? 0) % 60) }}"
                                                    class="form-control @error('transit_menit') is-invalid @enderror">
                                                <span class="input-group-text">menit</span>
                                            </div>

                                            @error('transit_jam')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                            @error('transit_menit')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="mb-1">
                                        <label class="form-label fw-semibold">Maskapai Lanjutan</label>

                                        <select name="transit_maskapai_id"
                                            class="form-select @error('transit_maskapai_id') is-invalid @enderror">
                                            <option value="">-- Sama dengan maskapai pertama --</option>

                                            @foreach ($maskapais as $maskapai)
                                                <option value="{{ $maskapai->id }}" @selected(old('transit_maskapai_id', $penerbangan->transit_maskapai_id) == $maskapai->id)>
                                                    {{ $maskapai->name }} ({{ $maskapai->code_iata }})
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="form-text">
                                            Isi jika penerbangan setelah transit memakai maskapai berbeda.
                                        </div>

                                        @error('transit_maskapai_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                            </div>


                            <div class="d-flex justify-content-end gap-2 mt-3">

                                <a href="{{ route('travel.penerbangan.index', [
                                    'wilayah_asal_id' => $penerbangan->wilayah_asal_id,
                                    'wilayah_tujuan_id' => $penerbangan->wilayah_tujuan_id,
                                ]) }}"
                                    class="btn btn-light">

                                    Batal

                                </a>

                                <button type="submit" class="btn btn-primary">

                                    <i class="bi bi-save"></i>
                                    Perbarui Jadwal

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


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
                                {{ $penerbangan->asal->airport_name }}
                            </div>

                            <div>
                                {{ $penerbangan->asal->city_name }}
                                ({{ $penerbangan->asal->code_iata }})
                            </div>

                        </div>


                        <div>

                            <small class="text-muted">
                                Ke
                            </small>

                            <div class="fw-semibold">
                                {{ $penerbangan->tujuan->airport_name }}
                            </div>

                            <div>
                                {{ $penerbangan->tujuan->city_name }}
                                ({{ $penerbangan->tujuan->code_iata }})
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        document.querySelector('form[action="{{ route('travel.penerbangan.update', $penerbangan) }}"]')
            .addEventListener('submit', function(e) {
                const btn = this.querySelector('button[type="submit"]');
                if (btn.disabled) {
                    e.preventDefault();
                    return;
                }
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';
            });

        // Toggle field transit
        const switchTransit = document.getElementById('punya_transit');
        const boxTransit = document.getElementById('transit-fields');

        function toggleTransit() {
            const on = switchTransit.checked;

            boxTransit.classList.toggle('d-none', !on);

            // Field yang disabled tidak ikut terkirim saat switch dimatikan
            boxTransit.querySelectorAll('input, select').forEach(function(el) {
                el.disabled = !on;
            });

            boxTransit.querySelector('[name="transit_wilayah_id"]').required = on;
        }

        switchTransit.addEventListener('change', toggleTransit);
        toggleTransit(); // sinkron saat halaman dimuat
    </script>
@endsection
