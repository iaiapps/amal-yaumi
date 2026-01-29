<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Portal Amal Yaumi') }} - Masuk / Daftar</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing-custom.css') }}">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .auth-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .navbar-brand img {
            height: 32px;
        }
    </style>
</head>

<body class="bg-mesh">
    <!-- Simple Navbar -->
    {{-- <nav class="navbar navbar-light py-3 fixed-top">
        <div class="container">
            <a class="navbar-brand fw-extra-bold fs-5 d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/favicon.svg') }}" class="me-2" alt="Logo">
                Portal Amal Yaumi
            </a>
            <a href="{{ url('/') }}" class="btn btn-modern btn-modern-outline btn-sm">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </nav> --}}

    <!-- Main Content -->
    <main class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 position-relative">
                    <!-- Decor -->
                    <div class="position-absolute bg-primary rounded-circle opacity-10"
                        style="width: 200px; height: 200px; top: -50px; left: -50px; filter: blur(60px);"></div>

                    @yield('content')

                    <div class="text-center mt-4">
                        <p class="text-muted small">&copy; {{ date('Y') }} Portal Amal Yaumi. <br>Build for istiqomah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
</body>

</html>