@extends('layouts.auth')

@section('content')
    <div class="card-modern shadow-lg border-0 position-relative"
        style="background: rgba(255,255,255,0.85); backdrop-filter: blur(20px);">
        <div class="card-body">
            <div class="text-center mb-4">
                <div class="mb-3">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="icon" style="width: 64px; height: 64px;">
                </div>

                <h3 class="fw-extra-bold text-dark">Selamat Datang</h3>
                <p class="text-muted">Masuk untuk melanjutkan ke Portal</p>
            </div>

            @if (isset($status))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>{{ $status }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label fw-bold text-dark small text-uppercase">Email / Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="ti ti-mail text-muted"></i></span>
                        <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            id="email" placeholder="name@example.com">
                    </div>
                    @error('email')
                        <span class="invalid-feedback d-block mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-bold text-dark small text-uppercase">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="ti ti-key text-muted"></i></span>
                        <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" id="password" placeholder="********">
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-modern btn-modern-primary  fw-bold shadow-lg">
                        <i class="ti ti-login me-2"></i> Masuk Sekarang
                    </button>
                </div>

            </form>
            {{-- Optional: Register Link if needed --}}
            <div class="text-center">
                <p class="text-muted small">Belum punya akun? <a href="{{ route('register') }}"
                        class="fw-bold text-primary text-decoration-none">Daftar</a></p>
            </div>
        </div>
    </div>
@endsection
