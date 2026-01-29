@extends('layouts.auth')

@section('content')
    <style>
        .nav-pills .nav-link {
            color: #6c757d;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            background-color: #16595a !important;
            color: white !important;
        }
    </style>
    <div class="card-modern shadow-lg border-0 position-relative"
        style="background: rgba(255,255,255,0.85); backdrop-filter: blur(20px);">
        <div class="card-body">
            <div class="text-center mb-4">
                <div class="mb-3">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="icon" style="width: 64px; height: 64px;">
                </div>

                <h3 class="fw-extra-bold text-dark">Selamat Datang</h3>
                <p class="text-muted small">Pilih jenis akun untuk masuk ke Portal</p>
            </div>

            @if (isset($status))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>{{ $status }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Tab Navigation -->
            <ul class="nav nav-pills nav-justified mb-4 bg-light p-1 rounded-pill" id="loginTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill" id="teacher-tab" data-bs-toggle="tab"
                        data-bs-target="#teacher-pane" type="button" role="tab">
                        <i class="ti ti-school me-1"></i> Guru
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill" id="student-tab" data-bs-toggle="tab"
                        data-bs-target="#student-pane" type="button" role="tab">
                        <i class="ti ti-users me-1"></i> Siswa
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="loginTabContent">
                <!-- Tab Guru / Admin -->
                <div class="tab-pane fade show active" id="teacher-pane" role="tabpanel" tabindex="0">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold text-dark small text-uppercase">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i
                                        class="ti ti-mail text-muted"></i></span>
                                <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="nama@email.com">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block mt-1" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-dark small text-uppercase">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i
                                        class="ti ti-key text-muted"></i></span>
                                <input type="password"
                                    class="form-control border-start-0 @error('password') is-invalid @enderror"
                                    name="password" required placeholder="********">
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-modern btn-modern-primary fw-bold shadow-lg">
                                <i class="ti ti-login me-2"></i> Masuk Guru
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tab Siswa -->
                <div class="tab-pane fade" id="student-pane" role="tabpanel" tabindex="0">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nis" class="form-label fw-bold text-dark small text-uppercase">NIS (Nomor
                                Induk)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i
                                        class="ti ti-id text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" name="nis" required
                                    placeholder="Contoh: 1001" autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="kode_guru" class="form-label fw-bold text-dark small text-uppercase">Kode
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i
                                        class="ti ti-hash text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" name="kode_guru" required
                                    placeholder="Contoh: AY-XYZ" style="text-transform: uppercase">
                            </div>
                            <small class="text-muted">Dapatkan kode dari pembimbing Anda</small>
                        </div>

                        <div class="mb-4">
                            <label for="password_siswa"
                                class="form-label fw-bold text-dark small text-uppercase">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i
                                        class="ti ti-key text-muted"></i></span>
                                <input type="password" class="form-control border-start-0" name="password" required
                                    placeholder="********">
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-modern btn-modern-primary fw-bold shadow-lg">
                                <i class="ti ti-login me-2"></i> Masuk Siswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Optional: Register Link if needed --}}
            <div class="text-center">
                <p class="text-muted small">Belum punya akun? <a href="{{ route('register') }}"
                        class="fw-bold text-primary text-decoration-none">Daftar</a></p>
            </div>
        </div>
    </div>
@endsection