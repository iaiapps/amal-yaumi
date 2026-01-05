@extends('layouts.applogin')

@section('content')
    <div class="auth-main">
        <div class="auth-wrapper v3">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        @if (isset($status))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    {{-- <button type="submit" class="ms-2 btn btn-danger">logout</button> --}}
                                    <strong>{{ $status }}</strong>
                                    <button type="submit" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </form>
                            </div>
                        @endif
                        <a href="#" class="d-flex justify-content-center">
                            <img src="{{ asset('/assets/images/favicon.svg') }}" alt="image"
                                class="img-fluid brand-logo" />
                        </a>
                        <br>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <div class="auth-header">
                                    <h2 class="text-secondary mt-2 text-center"><b>Selamat Datang di Aplikasi Amal Yaumi</b>
                                    </h2>
                                    <p class=" mt-2 text-center">Silahkan masukkan email/username dan kata sandi untuk
                                        melanjutkan
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    id="email" placeholder="Email address / Username" />
                                <label for="email">Email address / Username</label>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="password" id="password" placeholder="********">
                                <label for="password">Password</label>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-secondary">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
