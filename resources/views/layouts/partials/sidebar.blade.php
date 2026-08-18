@php
    // Helper kecil: hindari error jika route belum dibuat di iterasi berikutnya
    $ktRoute = fn($name, $fallback = '#') => \Illuminate\Support\Facades\Route::has($name) ? route($name) : $fallback;
    $ktActive = fn(...$patterns) => request()->routeIs(...$patterns) ? 'active' : '';
@endphp

<div class="offcanvas-lg offcanvas-start kt-sidebar" tabindex="-1" id="ktSidebar" aria-labelledby="ktSidebarLabel">

    <div class="offcanvas-header d-lg-none border-bottom border-secondary-subtle">
        <h6 class="offcanvas-title text-white m-0" id="ktSidebarLabel">Menu Travel</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#ktSidebar"
            aria-label="Tutup"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-0">

        <div class="kt-sidebar-brand d-none d-lg-flex align-items-center">
            <span class="kt-brand-mark"><i class="bi bi-airplane-engines-fill"></i></span>
            <div class="lh-sm">
                <div class="kt-brand-text">Kosikas<strong>Travel</strong></div>
                <div class="kt-sidebar-tag">Modul E-Tiket</div>
            </div>
        </div>
        <div class="kt-perforation d-none d-lg-block"></div>
        <div class="kt-barcode d-none d-lg-block"></div>

        <nav class="kt-sidebar-nav flex-grow-1">

            <div class="kt-nav-section">Menu Utama</div>

            <a href="{{ $ktRoute('travel.home') }}" class="kt-nav-link {{ $ktActive('travel.home') }}">
                <i class="bi bi-speedometer2"></i><span>Dashboard</span>
            </a>

            <a href="{{ $ktRoute('travel.bookings.create') }}"
                class="kt-nav-link {{ $ktActive('travel.bookings.create') }}">
                <i class="bi bi-ticket-perforated"></i><span>Pesan Tiket</span>
            </a>

            <a href="{{ $ktRoute('travel.bookings.index') }}"
                class="kt-nav-link {{ $ktActive('travel.bookings.index', 'travel.bookings.show') }}">
                <i class="bi bi-journal-text"></i><span>Daftar Booking</span>
            </a>

            <a href="{{ $ktRoute('travel.bookings.index') }}#generate"
                class="kt-nav-link {{ $ktActive('travel.bookings.pdf') }}">
                <i class="bi bi-file-earmark-pdf"></i><span>Generate E-Ticket</span>
            </a>

            <a href="{{ $ktRoute('travel.piutang.index') }}" class="kt-nav-link {{ $ktActive('travel.piutang.*') }}">
                <i class="bi bi-cash-stack"></i><span>Daftar Piutang</span>
            </a>

            <div class="kt-nav-section">Master Data</div>

            <a href="{{ $ktRoute('travel.maskapai.index') }}"
                class="kt-nav-link {{ $ktActive('travel.maskapai.*') }}">
                <i class="bi bi-airplane"></i><span>Data Maskapai</span>
            </a>

            <a href="{{ $ktRoute('travel.wilayah.index') }}" class="kt-nav-link {{ $ktActive('travel.wilayah.*') }}">
                <i class="bi bi-geo-alt"></i><span>Data Wilayah</span>
            </a>

        </nav>

        <div class="kt-sidebar-footer">
            <a href="{{ url('/') }}">
                <i class="bi bi-grid-3x3-gap"></i><span>Kembali ke Semua Modul</span>
            </a>
        </div>

    </div>
</div>
