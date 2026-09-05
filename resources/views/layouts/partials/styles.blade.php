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

    /* ---------- NAVBAR ---------- */
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

    /* ---------- SHELL / LAYOUT ---------- */
    .kt-shell {
        display: flex;
        min-height: 100vh;
    }

    .kt-main {
        flex: 1 1 auto;
        padding-top: var(--kt-navbar-h);
        min-width: 0;
    }

    @media (min-width: 992px) {
        .kt-main-with-sidebar {
            margin-left: var(--kt-sidebar-w);
        }
    }

    /* ---------- SIDEBAR ---------- */
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
    }

    .kt-sidebar-tag {
        font-size: .72rem;
        color: rgba(255, 255, 255, .55);
        letter-spacing: .4px;
    }

    /* perforation divider, like a torn boarding-pass stub */
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

    @media (max-width: 991.98px) {

        .kt-perforation::before,
        .kt-perforation::after {
            background: var(--kt-navy);
        }
    }

    /* decorative barcode strip, single restrained "signature" element */
    .kt-barcode {
        height: 22px;
        margin: 0 1.15rem 1rem;
        background-image: repeating-linear-gradient(90deg,
                rgba(255, 255, 255, .5) 0px, rgba(255, 255, 255, .5) 2px,
                transparent 2px, transparent 5px,
                rgba(255, 255, 255, .5) 5px, rgba(255, 255, 255, .5) 6px,
                transparent 6px, transparent 10px);
        opacity: .5;
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

    /* torn-ticket notch where the active stub meets the content edge */
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

    .kt-nav-badge {
        margin-left: auto;
        font-size: .68rem;
        font-weight: 700;
        background: rgba(255, 255, 255, .12);
        color: rgba(255, 255, 255, .7);
        border-radius: 999px;
        padding: .1rem .45rem;
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

    /* page heading helper used inside the content section */

    */ .kt-page-title {
        font-family: var(--font-display);
        font-weight: 600;
        color: var(--kt-ink);
    }

    /* ---------- AUTH / GUEST PAGES ---------- */
    .kt-guest-body {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        background:
            radial-gradient(circle at 15% 20%, rgba(201, 162, 39, .14), transparent 42%),
            radial-gradient(circle at 85% 85%, rgba(15, 29, 54, .08), transparent 42%),
            var(--kt-cream);
    }

    .kt-guest-wrap {
        width: 100%;
        max-width: 420px;
    }

    .kt-auth-card {
        background: var(--kt-surface);
        border: 1px solid var(--kt-line);
        border-radius: 16px;
        padding: 2.2rem 2rem;
        box-shadow: 0 20px 40px -22px rgba(15, 29, 54, .28);
        position: relative;
    }

    .kt-auth-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 2rem;
        right: 2rem;
        height: 1px;
        background-image: repeating-linear-gradient(90deg, var(--kt-line) 0 6px, transparent 6px 12px);
    }

    .kt-brand-mark-lg {
        width: 56px;
        height: 56px;
        font-size: 1.5rem;
        border-radius: 14px;
    }

    .kt-auth-hint {
        background: var(--kt-gold-soft);
        border: 1px dashed var(--kt-gold);
        border-radius: 10px;
        padding: .7rem .9rem;
    }
</style>
