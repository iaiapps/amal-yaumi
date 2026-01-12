@extends('layouts.auth')

@section('content')
    <div class="card-modern shadow-lg border-0 position-relative"
        style="background: rgba(255,255,255,0.85); backdrop-filter: blur(20px);">
        <div class="card-body">
            <div class="text-center mb-4">
                <div class="avtar avtar-lg bg-primary text-white mx-auto mb-3 shadow-primary rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 64px; height: 64px;">
                    <i class="ti ti-user-plus fs-2"></i>
                </div>
                <h3 class="fw-extra-bold text-dark">Buat Akun</h3>
                <p class="text-muted">Mulai perjalanan mutabaah Anda</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold text-dark small text-uppercase">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="ti ti-user text-muted"></i></span>
                        <input id="name" type="text" class="form-control border-start-0 @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                            placeholder="Nama Anda">
                    </div>
                    @error('name')
                        <span class="invalid-feedback d-block mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold text-dark small text-uppercase">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="ti ti-mail text-muted"></i></span>
                        <input id="email" type="email"
                            class="form-control border-start-0 @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" placeholder="email@contoh.com">
                    </div>
                    @error('email')
                        <span class="invalid-feedback d-block mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold text-dark small text-uppercase">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="ti ti-lock text-muted"></i></span>
                        <input id="password" type="password"
                            class="form-control border-start-0 @error('password') is-invalid @enderror" name="password"
                            required autocomplete="new-password" placeholder="********">
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="form-label fw-bold text-dark small text-uppercase">Konfirmasi
                        Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="ti ti-lock text-muted"></i></span>
                        <input id="password-confirm" type="password" class="form-control border-start-0 
                                    name=" password_confirmation" required autocomplete="new-password"
                            placeholder="********">
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-modern btn-modern-primary fw-bold shadow-lg">
                        <i class="ti ti-rocket me-2"></i> Daftar Sekarang
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-muted small">Sudah punya akun? <a href="{{ route('login') }}"
                            class="fw-bold text-primary text-decoration-none">Login</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection