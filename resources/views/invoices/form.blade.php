@extends('layouts.app')

@section('title', 'Lengkapi Invoice')

@section('content')

    <h4 class="section-title mb-3"><i class="bi bi-receipt me-2"></i>Invoice
        {{ $invoice->invoice_code ?? '(belum ada kode)' }}</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <div id="formErrors" class="alert alert-danger d-none"></div>
    @endif

    <form id="invoiceForm" action="{{ route('travel.invoices.update', $invoice) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Data Pemesan --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <h5 class="section-title mb-3"><i class="bi bi-person-fill me-2"></i>Data Pemesan</h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Kode Invoice</label>
                        <input type="text" name="invoice_code" class="form-control" maxlength="50"
                            value="{{ old('invoice_code', $invoice->invoice_code) }}" placeholder="Otomatis jika kosong">
                        <div class="form-text">Kosong = dibuat otomatis / tetap memakai kode lama.</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nama Pemesan</label>
                        <input type="text" name="orderer_name" class="form-control" required
                            value="{{ old('orderer_name', $invoice->orderer_name) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="orderer_address" class="form-control"
                            value="{{ old('orderer_address', $invoice->orderer_address) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="orderer_phone" class="form-control"
                            value="{{ old('orderer_phone', $invoice->orderer_phone) }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Ringkasan Tiket (read-only, dari booking yang dicentang) --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <h5 class="section-title mb-3"><i class="bi bi-airplane-engines-fill me-2"></i>Tiket Pesawat</h5>
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Penumpang</th>
                            <th>Maskapai</th>
                            <th>Rute</th>
                            <th>Waktu</th>
                            <th class="text-end">Harga Tiket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->flightItems as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->passenger_name }}</td>
                                <td>{{ $item->maskapai_name }}</td>
                                <td>{{ $item->route_text }}</td>
                                <td>{{ $item->flight_date_text }}</td>
                                <td class="text-end">{{ number_format($item->amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="form-text mt-2">Harga tiket otomatis diambil dari Total Fare tiap booking. Untuk mengubahnya,
                    edit e-ticket terkait.</div>
            </div>
        </div>

        {{-- Biaya Hotel --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0"><i class="bi bi-building-fill me-2"></i>Data Hotel</h5>
                    <button type="button" id="addHotel" class="btn btn-sm btn-warning"><i class="bi bi-plus-lg"></i>
                        Tambah</button>
                </div>
                <div id="hotelWrapper"></div>
            </div>
        </div>

        {{-- Biaya Tambahan --}}
        <div class="card card-section mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0"><i class="bi bi-plus-circle-fill me-2"></i>Biaya Tambahan
                        <span class="section-sub">(reschedule, refund, dll — isi negatif untuk pengurangan)</span>
                    </h5>
                    <button type="button" id="addExtra" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i>
                        Tambah</button>
                </div>
                <div id="extraWrapper"></div>
            </div>
        </div>

        <div class="text-end mb-5">
            <a href="{{ route('travel.bookings.index') }}" class="btn btn-outline-secondary btn-lg">Batal</a>
            <button type="submit" class="btn btn-success btn-lg">
                <i class="bi bi-file-earmark-pdf-fill me-2"></i>Simpan & Buat Invoice
            </button>
        </div>
    </form>

@endsection

@push('scripts')
    <script>
        const existingExtras = @json($invoice->extraItems->map(fn($e) => ['label' => $e->label, 'amount' => $e->amount])->values());
        let extraIndex = 0;

        function extraTemplate(i, e = {}) {
            return `
    <div class="row g-2 mb-2 align-items-center extra-row" data-extra-index="${i}">
        <div class="col-md-7">
            <input type="text" name="extras[${i}][label]" class="form-control" placeholder="Contoh: Biaya Reschedule / Refund Tiket" value="${e.label ?? ''}">
        </div>
        <div class="col-md-4">
            <input type="number" step="0.01" name="extras[${i}][amount]" class="form-control" placeholder="Jumlah (isi minus untuk refund)" value="${e.amount ?? ''}">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger remove-extra"><i class="bi bi-x-lg"></i></button>
        </div>
    </div>`;
        }

        function addExtra(data = {}) {
            document.getElementById('extraWrapper').insertAdjacentHTML('beforeend', extraTemplate(extraIndex, data));
            extraIndex++;
        }

        document.getElementById('addExtra').addEventListener('click', () => addExtra());
        document.getElementById('extraWrapper').addEventListener('click', function(e) {
            if (e.target.closest('.remove-extra')) e.target.closest('.extra-row').remove();
        });

        if (existingExtras.length) {
            existingExtras.forEach(e => addExtra(e));
        }
    </script>
    <script>
        const existingHotels = {!! $existingHotelsJson !!};
        let hotelIndex = 0;

        function hotelTemplate(i, h = {}) {
            return `
                <div class="row g-2 mb-2 align-items-center hotel-row" data-hotel-index="${i}">
                    <div class="col-md-2"><input type="text" name="hotels[${i}][guest_name]" class="form-control" placeholder="Nama" value="${h.guest_name ?? ''}"></div>
                    <div class="col-md-2"><input type="text" name="hotels[${i}][hotel_name]" class="form-control" placeholder="Nama Hotel" value="${h.hotel_name ?? ''}"></div>
                    <div class="col-md-2"><input type="text" name="hotels[${i}][hotel_location]" class="form-control" placeholder="Lokasi" value="${h.hotel_location ?? ''}"></div>
                    <div class="col-md-2"><input type="date" name="hotels[${i}][checkin_date]" class="form-control" value="${h.checkin_date ?? ''}"></div>
                    <div class="col-md-2"><input type="date" name="hotels[${i}][checkout_date]" class="form-control" value="${h.checkout_date ?? ''}"></div>
                    <div class="col-md-1"><input type="number" step="0.01" name="hotels[${i}][amount]" class="form-control" placeholder="Harga" value="${h.amount ?? ''}"></div>
                    <div class="col-md-1"><button type="button" class="btn btn-outline-danger remove-hotel"><i class="bi bi-x-lg"></i></button></div>
                </div>`;
        }

        function addHotel(data = {}) {
            document.getElementById('hotelWrapper').insertAdjacentHTML('beforeend', hotelTemplate(hotelIndex, data));
            hotelIndex++;
        }

        document.getElementById('addHotel').addEventListener('click', () => addHotel());
        document.getElementById('hotelWrapper').addEventListener('click', function(e) {
            if (e.target.closest('.remove-hotel')) e.target.closest('.hotel-row').remove();
        });

        if (existingHotels.length) {
            existingHotels.forEach(h => addHotel(h));
        }
    </script>
    <script>
        const LIST_URL = "{{ route('travel.invoices.index') }}";
        const invoiceForm = document.getElementById('invoiceForm');

        function showFormErrors(data) {
            const box = document.getElementById('formErrors');
            const msgs = data && data.errors ? Object.values(data.errors).flat() :
                [(data && data.message) || 'Terjadi kesalahan saat menyimpan.'];
            const ul = document.createElement('ul');
            ul.className = 'mb-0';
            msgs.forEach(m => {
                const li = document.createElement('li');
                li.textContent = m;
                ul.appendChild(li);
            });
            box.replaceChildren(ul);
            box.classList.remove('d-none');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        invoiceForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = invoiceForm.querySelector('button[type="submit"]');

            // dibuka sinkron saat klik supaya tidak diblokir popup blocker
            const win = window.open('', '_blank');
            if (win) {
                win.document.write('<p style="font-family:sans-serif;padding:24px">Menyimpan invoice…</p>');
            }
            btn.disabled = true;

            try {
                const res = await fetch(invoiceForm.action, {
                    method: 'POST', // _method=PUT dan _token sudah ada di FormData
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(invoiceForm),
                });
                const data = await res.json().catch(() => ({}));

                if (res.ok && data.redirect) {
                    if (win) {
                        win.location.href = data.redirect; // tab baru: invoice
                        window.location.href = LIST_URL; // tab awal: daftar invoice
                    } else {
                        window.location.href = data.redirect; // popup diblokir: buka di tab ini
                    }
                    return;
                }

                if (win) win.close();
                showFormErrors(data);
            } catch (err) {
                if (win) win.close();
                showFormErrors({
                    message: 'Gagal menghubungi server. Coba lagi.'
                });
            }
            btn.disabled = false;
        });
    </script>
@endpush
