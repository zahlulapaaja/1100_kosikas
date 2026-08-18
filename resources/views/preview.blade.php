<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview - Kosikas Travel Layout</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --kt-navbar-h: 68px;
            --kt-sidebar-w: 264px;
            --kt-navy: #0F1D36;
            --kt-navy-2: #16294A;
            --kt-gold: #C9A227;
            --kt-gold-soft: rgba(201, 162, 39, .18);
            --kt-cream: #F6F4EE;
            --kt-surface: #FFFFFF;
            --kt-ink: #1B2333;
            --kt-muted: #808A9C;
            --kt-line: #E7E2D6;
            --kt-success: #2F7D5C;
            --kt-danger: #C0392B;
            --font-display: 'Space Grotesk', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        body {
            background: var(--kt-cream);
            color: var(--kt-ink);
            font-family: var(--font-body);
        }

        .kt-navbar {
            height: var(--kt-navbar-h);
            background: var(--kt-navy) !important;
            color: #fff;
            border-bottom: 1px solid var(--kt-navy-2);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1040;
        }

        .kt-navbar .container-fluid {
            color: #fff;
        }

        .kt-burger {
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: .55rem;
            font-size: 1.15rem;
            line-height: 1;
            padding: .4rem .6rem;
            background: transparent;
        }

        .kt-burger:hover {
            background: rgba(255, 255, 255, .08);
        }

        .kt-brand {
            text-decoration: none;
        }

        .kt-brand-mark {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--kt-gold);
            color: var(--kt-navy) !important;
            border-radius: 10px;
            font-size: 1.05rem;
        }

        .kt-brand-text,
        .kt-brand-text.navbar-brand {
            font-family: var(--font-display);
            font-weight: 500;
            color: #fff !important;
            font-size: 1.05rem;
            letter-spacing: .2px;
        }

        .kt-brand-text strong {
            font-weight: 700;
            color: var(--kt-gold) !important;
        }

        .kt-nav-pill {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .45rem .9rem;
            border-radius: 999px;
            color: rgba(255, 255, 255, .75) !important;
            text-decoration: none;
            font-size: .92rem;
            font-weight: 500;
            border: 1px solid transparent;
            transition: all .15s ease;
        }

        .kt-nav-pill:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, .08);
        }

        .kt-nav-pill.active {
            color: var(--kt-navy) !important;
            background: var(--kt-gold);
            border-color: var(--kt-gold);
        }

        .kt-btn-login {
            background: var(--kt-gold);
            color: var(--kt-navy) !important;
            font-weight: 600;
            border: none;
            border-radius: .6rem;
            padding: .5rem 1.1rem;
            text-decoration: none;
            font-size: .92rem;
        }

        .kt-btn-login:hover {
            filter: brightness(1.06);
        }

        .kt-user-btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .14);
            color: #fff !important;
            border-radius: .6rem;
            padding: .35rem .7rem;
        }

        .kt-user-btn:hover {
            background: rgba(255, 255, 255, .12);
            color: #fff !important;
        }

        .kt-user-btn span {
            color: #fff !important;
        }

        .kt-avatar {
            width: 26px;
            height: 26px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--kt-gold);
            color: var(--kt-navy) !important;
            border-radius: 50%;
            font-weight: 700;
            font-size: .8rem;
        }

        .kt-shell {
            display: flex;
            min-height: 100vh;
        }

        .kt-main {
            flex: 1 1 auto;
            padding-top: var(--kt-navbar-h);
            min-width: 0;
            transition: margin-left .15s ease;
        }

        @media (min-width: 992px) {
            .kt-main-with-sidebar {
                margin-left: var(--kt-sidebar-w);
            }
        }

        .kt-sidebar {
            width: var(--kt-sidebar-w);
            background: var(--kt-navy) !important;
            color: #fff;
            --bs-offcanvas-width: var(--kt-sidebar-w);
        }

        .kt-sidebar .offcanvas-body {
            background: var(--kt-navy) !important;
            color: #fff;
        }

        @media (min-width: 992px) {
            .kt-sidebar {
                position: fixed;
                top: var(--kt-navbar-h);
                left: 0;
                bottom: 0;
                z-index: 1030;
                border-right: 1px solid var(--kt-navy-2);
                background: var(--kt-navy) !important;
            }

            .kt-sidebar .offcanvas-body {
                background: var(--kt-navy) !important;
            }
        }

        .kt-sidebar-brand {
            padding: 1.1rem 1.15rem .9rem;
            gap: .6rem;
            display: flex;
        }

        .kt-sidebar-tag {
            font-size: .72rem;
            color: rgba(255, 255, 255, .55);
            letter-spacing: .4px;
        }

        .kt-perforation {
            position: relative;
            height: 1px;
            margin: 0 0 .6rem;
            background-image: repeating-linear-gradient(90deg, rgba(255, 255, 255, .28) 0 6px, transparent 6px 12px);
        }

        .kt-perforation::before,
        .kt-perforation::after {
            content: "";
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--kt-cream);
        }

        .kt-perforation::before {
            left: -7px;
        }

        .kt-perforation::after {
            right: -7px;
        }

        @media (max-width:991.98px) {

            .kt-perforation::before,
            .kt-perforation::after {
                background: var(--kt-navy);
            }
        }

        .kt-barcode {
            height: 22px;
            margin: 0 1.15rem 1rem;
            opacity: .5;
            background-image: repeating-linear-gradient(90deg, rgba(255, 255, 255, .5) 0px, rgba(255, 255, 255, .5) 2px, transparent 2px, transparent 5px, rgba(255, 255, 255, .5) 5px, rgba(255, 255, 255, .5) 6px, transparent 6px, transparent 10px);
        }

        .kt-nav-section {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .4);
            padding: .9rem 1.15rem .4rem;
        }

        .kt-nav-link {
            display: flex;
            align-items: center;
            gap: .7rem;
            padding: .62rem 1.15rem;
            color: rgba(255, 255, 255, .82);
            text-decoration: none;
            font-size: .93rem;
            border-left: 3px solid transparent;
            position: relative;
        }

        .kt-nav-link i {
            font-size: 1.05rem;
            width: 1.2rem;
            text-align: center;
            color: rgba(255, 255, 255, .55);
        }

        .kt-nav-link:hover {
            background: rgba(255, 255, 255, .06);
            color: #fff;
        }

        .kt-nav-link:hover i {
            color: var(--kt-gold);
        }

        .kt-nav-link.active {
            color: #fff;
            font-weight: 600;
            border-left-color: var(--kt-gold);
            background: linear-gradient(90deg, var(--kt-gold-soft), transparent 75%);
        }

        .kt-nav-link.active i {
            color: var(--kt-gold);
        }

        @media (min-width: 992px) {
            .kt-nav-link.active::after {
                content: "";
                position: absolute;
                right: -1px;
                top: 50%;
                transform: translateY(-50%);
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: var(--kt-cream);
            }
        }

        .kt-sidebar-footer {
            padding: .9rem 1.15rem 1.2rem;
            border-top: 1px dashed rgba(255, 255, 255, .15);
        }

        .kt-sidebar-footer a {
            color: rgba(255, 255, 255, .6);
            text-decoration: none;
            font-size: .85rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .kt-sidebar-footer a:hover {
            color: #fff;
        }

        .kt-page-title {
            font-family: var(--font-display);
            font-weight: 600;
            color: var(--kt-ink);
        }

        .kt-stat-card {
            background: var(--kt-surface);
            border: 1px solid var(--kt-line);
            border-radius: 14px;
            padding: 1.1rem 1.2rem;
        }

        .kt-stat-card .label {
            font-size: .78rem;
            color: var(--kt-muted);
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .kt-stat-card .value {
            font-family: var(--font-display);
            font-size: 1.6rem;
            font-weight: 700;
        }

        /* guest state: hide auth-only bits */
        body:not(.is-auth) .auth-only {
            display: none !important;
        }

        body.is-auth .guest-only {
            display: none !important;
        }

        .kt-demo-toggle {
            position: fixed;
            bottom: 16px;
            right: 16px;
            z-index: 1050;
        }
    </style>
</head>

<body class="is-auth">

    <nav class="navbar kt-navbar">
        <div class="container-fluid h-100 px-3 px-lg-4 d-flex align-items-center">
            <button class="btn kt-burger d-lg-none me-2 auth-only" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#ktSidebar" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>
            <a class="navbar-brand kt-brand d-flex align-items-center gap-2 me-auto" href="#">
                <span class="kt-brand-mark"><i class="bi bi-airplane-engines-fill"></i></span>
                <span class="kt-brand-text d-none d-sm-inline">Kosikas<strong>Travel</strong></span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="#" class="kt-nav-pill active auth-only"><i class="bi bi-airplane"></i><span
                        class="d-none d-md-inline">Travel</span></a>
                <div class="dropdown auth-only">
                    <button class="btn kt-user-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <span class="kt-avatar">D</span><span class="d-none d-md-inline">Dina Nirmala</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="#"><i
                                    class="bi bi-box-arrow-right me-2"></i>Keluar</a></li>
                    </ul>
                </div>
                <a href="#" class="btn kt-btn-login guest-only"><i class="bi bi-box-arrow-in-right me-1"></i>
                    Login</a>
            </div>
        </div>
    </nav>

    <div class="kt-shell">
        <div class="offcanvas-lg offcanvas-start kt-sidebar auth-only" tabindex="-1" id="ktSidebar">
            <div class="offcanvas-header d-lg-none border-bottom border-secondary-subtle">
                <h6 class="offcanvas-title text-white m-0">Menu Travel</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    data-bs-target="#ktSidebar"></button>
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

                <nav class="flex-grow-1">
                    <div class="kt-nav-section">Menu Utama</div>
                    <a href="#" class="kt-nav-link active"><i
                            class="bi bi-speedometer2"></i><span>Dashboard</span></a>
                    <a href="#" class="kt-nav-link"><i class="bi bi-ticket-perforated"></i><span>Pesan
                            Tiket</span></a>
                    <a href="#" class="kt-nav-link"><i class="bi bi-journal-text"></i><span>Daftar
                            Booking</span></a>
                    <a href="#" class="kt-nav-link"><i class="bi bi-file-earmark-pdf"></i><span>Generate
                            E-Ticket</span></a>
                    <a href="#" class="kt-nav-link"><i class="bi bi-cash-stack"></i><span>Daftar
                            Piutang</span></a>
                    <div class="kt-nav-section">Master Data</div>
                    <a href="#" class="kt-nav-link"><i class="bi bi-airplane"></i><span>Data Maskapai</span></a>
                    <a href="#" class="kt-nav-link"><i class="bi bi-geo-alt"></i><span>Data Wilayah</span></a>
                </nav>

                <div class="kt-sidebar-footer">
                    <a href="#"><i class="bi bi-grid-3x3-gap"></i><span>Kembali ke Semua Modul</span></a>
                </div>
            </div>
        </div>

        <main class="kt-main auth-margin">
            <div class="container-fluid p-3 p-lg-4">
                <h4 class="kt-page-title mb-1">Dashboard</h4>
                <p class="text-muted mb-4">Ringkasan modul Travel &mdash; Kosikas Travel.</p>

                <div class="row g-3 mb-4">
                    <div class="col-6 col-lg-3">
                        <div class="kt-stat-card">
                            <div class="label">Booking Bulan Ini</div>
                            <div class="value">24</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="kt-stat-card">
                            <div class="label">E-Ticket Terbit</div>
                            <div class="value">21</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="kt-stat-card">
                            <div class="label">Piutang Aktif</div>
                            <div class="value text-danger">Rp 8,4jt</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="kt-stat-card">
                            <div class="label">Maskapai Aktif</div>
                            <div class="value">6</div>
                        </div>
                    </div>
                </div>

                <div class="kt-stat-card">
                    <div class="fw-semibold mb-2">Contoh Konten</div>
                    <p class="text-muted mb-0 small">Area ini merepresentasikan <code>@yield('content')</code> pada
                        layout Blade &mdash; ganti dengan tabel booking, form, dsb.</p>
                </div>
            </div>
        </main>
    </div>

    <button class="btn btn-dark kt-demo-toggle shadow" id="toggleAuth">
        <i class="bi bi-arrow-repeat me-1"></i> Simulasikan: Logout
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const body = document.body;
        const main = document.querySelector('.kt-main');
        const btn = document.getElementById('toggleAuth');

        function applyMargin() {
            if (body.classList.contains('is-auth') && window.innerWidth >= 992) {
                main.style.marginLeft = 'var(--kt-sidebar-w)';
            } else {
                main.style.marginLeft = '0';
            }
        }
        btn.addEventListener('click', () => {
            body.classList.toggle('is-auth');
            const loggedIn = body.classList.contains('is-auth');
            btn.innerHTML = loggedIn ?
                '<i class="bi bi-arrow-repeat me-1"></i> Simulasikan: Logout' :
                '<i class="bi bi-arrow-repeat me-1"></i> Simulasikan: Login';
            applyMargin();
        });
        window.addEventListener('resize', applyMargin);
        applyMargin();
    </script>
</body>

</html>
