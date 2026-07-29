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
    </style>
</head>
<body>
    <nav class="navbar navbar-dark" style="background-color:#0d3b66;">
        <div class="container">
            <span class="navbar-brand mb-0 h1"><i class="bi bi-airplane-fill me-2"></i>Generator E-Ticket</span>
        </div>
    </nav>

    <div class="container my-4">
        @yield('content')
    </div>

    <div class="container text-center pb-4">
        <footer>Aplikasi sederhana pembuat e-ticket &mdash; dibuat dengan Laravel 12 &amp; Bootstrap 5</footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
