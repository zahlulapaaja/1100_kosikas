<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Generator E-Ticket')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .card-section { border: none; box-shadow: 0 2px 10px rgba(0,0,0,.06); border-radius: .75rem; }
        .section-title { font-weight: 600; color: #0d3b66; }
        .segment-block, .passenger-block { border: 1px dashed #c7d2e0; border-radius: .5rem; padding: 1rem; margin-bottom: 1rem; position: relative; background: #fbfcfe; }
        .btn-remove { position: absolute; top: .5rem; right: .5rem; }
        footer { color: #8a94a6; font-size: .85rem; }
        .navbar-brand { font-weight: 600; }
        .nav-link.active { font-weight: 600; text-decoration: underline; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark navbar-expand-lg" style="background-color:#0d3b66;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('bookings.index') }}">
                <i class="bi bi-airplane-fill me-2"></i>Generator E-Ticket
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}" href="{{ route('bookings.index') }}">
                            <i class="bi bi-ticket-perforated me-1"></i>Daftar E-Ticket
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('maskapai.*') ? 'active' : '' }}" href="{{ route('maskapai.index') }}">
                            <i class="bi bi-airplane me-1"></i>Master Maskapai
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('wilayah.*') ? 'active' : '' }}" href="{{ route('wilayah.index') }}">
                            <i class="bi bi-geo-alt me-1"></i>Master Wilayah
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <div class="container text-center pb-4">
        <footer>Aplikasi sederhana pembuat e-ticket &mdash; dibuat dengan Laravel 12 &amp; Bootstrap 5</footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
