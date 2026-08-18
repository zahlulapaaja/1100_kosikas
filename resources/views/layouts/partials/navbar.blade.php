<nav class="navbar kt-navbar">
    <div class="container-fluid h-100 px-3 px-lg-4 d-flex align-items-center">

        {{-- Hamburger, hanya tampil di mobile/tablet, membuka sidebar (offcanvas) --}}
        @auth
            <button class="btn kt-burger d-lg-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#ktSidebar"
                aria-controls="ktSidebar" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>
        @endauth

        <a class="navbar-brand kt-brand d-flex align-items-center gap-2 me-auto" href="{{ url('/') }}">
            <span class="kt-brand-mark"><i class="bi bi-airplane-engines-fill"></i></span>
            <span class="kt-brand-text d-none d-sm-inline">Kosikas<strong>Travel</strong></span>
        </a>

        <div class="d-flex align-items-center gap-2">
            @auth
                {{-- Menu modul (mis. Travel) - hanya modul aktif yang ditampilkan --}}
                @foreach (config('modules.modules', []) as $key => $module)
                    @if (($module['status'] ?? 'active') === 'active')
                        <a href="{{ $module['url'] ?? '#' }}"
                            class="kt-nav-pill {{ request()->is(($module['route_prefix'] ?? $key) . '*') ? 'active' : '' }}">
                            <i class="bi {{ $module['icon'] ?? 'bi-grid' }}"></i>
                            <span class="d-none d-md-inline">{{ $module['name'] ?? ucfirst($key) }}</span>
                        </a>
                    @endif
                @endforeach

                {{-- Dropdown user --}}
                <div class="dropdown kt-user-dropdown">
                    <button class="btn kt-user-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span class="kt-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                        <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Pengguna' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn kt-btn-login">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
            @endauth
        </div>

    </div>
</nav>
