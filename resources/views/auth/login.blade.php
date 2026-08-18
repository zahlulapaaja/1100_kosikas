@extends('layouts.guest')

@section('title', 'Login - Kosikas Travel')

@section('content')
    <div class="kt-auth-card">

        <div class="text-center mb-4">
            <span class="kt-brand-mark kt-brand-mark-lg d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-airplane-engines-fill"></i>
            </span>
            <h4 class="kt-page-title mt-3 mb-1">Masuk ke Kosikas<span class="text-warning">Travel</span></h4>
            <p class="text-muted small mb-0">Kelola booking &amp; e-ticket dalam satu tempat.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success py-2 small">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger py-2 small mb-3">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}" novalidate>
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label small fw-semibold">Email</label>
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', app()->environment('local') ? 'admin@kosikas.test' : '') }}"
                    placeholder="admin@kosikas.test" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label small fw-semibold">Password</label>
                <input type="password" name="password" id="password" class="form-control"
                    value="{{ app()->environment('local') ? 'password' : '' }}" placeholder="••••••••" required>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label small text-muted">Ingat saya</label>
            </div>

            <button type="submit" class="btn kt-btn-login w-100 py-2">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
            </button>
        </form>

        @if (app()->environment('local'))
            <div class="kt-auth-hint mt-4">
                <div class="small fw-semibold mb-1"><i class="bi bi-info-circle me-1"></i>Akun demo (khusus lokal)</div>
                <div class="small text-muted">admin@kosikas.test &nbsp;/&nbsp; password</div>
            </div>
        @endif

    </div>
@endsection
