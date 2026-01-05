<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amal Yaumi - Sistem Tracking Ibadah Harian</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
</head>
<body>
    <!-- Hero Section -->
    <section class="bg-primary-dark" style="min-height: 100vh; display: flex; align-items: center;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white">
                    <h1 class="display-3 fw-bold mb-4">Amal Yaumi</h1>
                    <p class="fs-5 mb-4">Sistem tracking ibadah harian untuk siswa. Pantau, catat, dan tingkatkan konsistensi ibadah dengan mudah.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                            <i class="ti ti-login"></i> Login
                        </a>
                        <a href="#features" class="btn btn-outline-light btn-lg">
                            <i class="ti ti-info-circle"></i> Pelajari Lebih
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-white">
                    <i class="ti ti-mosque" style="font-size: 15rem; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Fitur Unggulan</h2>
                <p class="text-muted">Solusi lengkap untuk administrasi dan monitoring ibadah</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="avtar avtar-xl bg-light-primary mb-3 mx-auto">
                                <i class="ti ti-chart-line text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="card-title">Dashboard Analytics</h5>
                            <p class="card-text text-muted">Grafik dan statistik real-time untuk monitoring progress ibadah siswa</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="avtar avtar-xl bg-light-success mb-3 mx-auto">
                                <i class="ti ti-file-analytics text-success" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="card-title">Laporan PDF & Excel</h5>
                            <p class="card-text text-muted">Export laporan lengkap dalam format PDF dan Excel dengan mudah</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="avtar avtar-xl bg-light-warning mb-3 mx-auto">
                                <i class="ti ti-file-upload text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="card-title">Import Data</h5>
                            <p class="card-text text-muted">Import data siswa secara bulk menggunakan file Excel</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="avtar avtar-xl bg-light-danger mb-3 mx-auto">
                                <i class="ti ti-flame text-danger" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="card-title">Streak Tracking</h5>
                            <p class="card-text text-muted">Hitung hari berturut-turut siswa mengisi mutabaah</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="avtar avtar-xl bg-light-info mb-3 mx-auto">
                                <i class="ti ti-trophy text-info" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="card-title">Ranking Siswa</h5>
                            <p class="card-text text-muted">Sistem ranking untuk memotivasi siswa lebih konsisten</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="avtar avtar-xl bg-light-secondary mb-3 mx-auto">
                                <i class="ti ti-shield-check text-secondary" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="card-title">Role Management</h5>
                            <p class="card-text text-muted">Akses berbeda untuk admin dan siswa dengan keamanan terjamin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 text-center mb-4">
                    <h2 class="display-4 fw-bold text-primary">13</h2>
                    <p class="text-muted">Jenis Ibadah</p>
                </div>
                <div class="col-md-3 text-center mb-4">
                    <h2 class="display-4 fw-bold text-success">100%</h2>
                    <p class="text-muted">Responsive</p>
                </div>
                <div class="col-md-3 text-center mb-4">
                    <h2 class="display-4 fw-bold text-warning">24/7</h2>
                    <p class="text-muted">Akses Online</p>
                </div>
                <div class="col-md-3 text-center mb-4">
                    <h2 class="display-4 fw-bold text-info">∞</h2>
                    <p class="text-muted">Data Storage</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-primary py-5">
        <div class="container text-center text-white">
            <h2 class="display-5 fw-bold mb-4">Siap Memulai?</h2>
            <p class="fs-5 mb-4">Tingkatkan monitoring ibadah siswa di sekolah Anda</p>
            <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                <i class="ti ti-login"></i> Login Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-dark text-white text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Amal Yaumi. Sistem Tracking Ibadah Harian.</p>
        </div>
    </footer>

    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
</body>
</html>
