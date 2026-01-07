<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amal Yaumi - Sistem Tracking Ibadah Harian</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing-custom.css') }}">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3 sticky-top"
        style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.8) !important;">
        <div class="container">
            <a class="navbar-brand fw-extra-bold fs-5 d-flex align-items-center" href="#">
                <img src="{{ asset('assets/images/favicon.svg') }}" width="32" height="32" class="me-2" alt="Logo">
                Portal Amal Yaumi
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="ti ti-menu-2 fs-2"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2 fw-bold">
                    <li class="nav-item"><a class="nav-link px-3" href="#info">Informasi</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#tutorial">Panduan</a></li>
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('login') }}" class="btn btn-modern btn-modern-primary px-4 shadow-primary">Login Portal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section ">
        <div class="container">
            <div class="row align-items-center text-center text-lg-start">
                <div class="col-lg-7 position-relative">
                    <span
                        class="badge bg-light-primary text-primary mb-3 px-3 py-2 rounded-pill fw-bold border border-primary border-opacity-25"
                        style="letter-spacing: 0.5px;">PORTAL INTERNAL SISWA & GURU</span>
                    <h1 class="hero-title fw-extra-bold">Selamat Datang di <br><span class="text-primary">Portal Mutabaah</span> Digital</h1>
                    <p class="hero-subtitle mx-auto mx-lg-0 mb-4 fs-5 opacity-90">Media monitoring ibadah harian untuk mendukung istiqomah dan perkembangan karakter seluruh siswa.</p>
                    <div
                        class="d-flex flex-column flex-sm-row gap-3 mt-4 justify-content-center justify-content-lg-start">
                        <a href="{{ route('login') }}"
                            class="btn btn-modern btn-modern-primary btn-lg px-5 py-3 shadow-lg fs-5 fw-bold">
                            Masuk ke Dashboard
                        </a>
                        <a href="#info" class="btn btn-modern btn-modern-outline btn-lg px-5 py-3 fs-5 fw-bold">
                            Lihat Informasi
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="position-relative">
                        <!-- Glass Mockup Decor -->
                        <div class="position-absolute bg-primary rounded-circle opacity-10"
                            style="width: 300px; height: 300px; top: -50px; left: -50px; filter: blur(60px);"></div>

                        <div class="card-modern shadow-2xl skew-y-3 p-4 border-0"
                            style="background: rgba(255,255,255,0.7); backdrop-filter: blur(20px);">
                            <div class="d-flex align-items-center gap-3 mb-4 text-start">
                                <div class="avtar avtar-md bg-primary text-white rounded-circle"
                                    style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                    <i class="ti ti-user fs-4"></i>
                                </div>
                                <div>
                                    <div class="fw-extra-bold fs-5 text-dark">Zaidan Ahmad</div>
                                    <div class="text-muted small fw-bold">Kelas 10-A</div>
                                </div>
                            </div>

                            <!-- Streak Mockup -->
                            <div class="streak-card mb-4 text-start border-0 shadow-lg">
                                <div class="small fw-bold opacity-75">Current Streak</div>
                                <div class="display-5 fw-extra-bold">12 Hari</div>
                                <div class="small fw-bold opacity-75 mt-1">Jangan kasih kendor! 🔥</div>
                            </div>

                            <!-- Badges Mockup -->
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="badge-item border-0 shadow-sm"
                                        style="background: rgba(255,255,255,0.8);">
                                        <span class="badge-icon">⭐</span>
                                        <span class="small fw-extra-bold text-dark">Istiqomah</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="badge-item border-0 shadow-sm"
                                        style="background: rgba(255,255,255,0.8);">
                                        <span class="badge-icon">🔥</span>
                                        <span class="small fw-extra-bold text-dark">On Fire</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information Section -->
    <section id="info" class="bg-mesh-bottom">
        <div class="container">
            <div class="text-center mb-5 max-w-700 mx-auto">
                <h2 class="display-6 fw-extra-bold mb-3">Informasi <span
                        class="text-primary border-bottom border-4 border-primary">Penting</span></h2>
                <p class="text-muted fs-5 fw-medium">Berikut adalah informasi utama mengenai penggunaan Portal Mutabaah Digital.</p>
            </div>
            <div class="row g-4 text-start">
                <div class="col-md-4">
                    <div class="card-modern h-100 border-0 shadow-sm"
                        style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);">
                        <div class="card-icon bg-primary text-white shadow-primary"
                            style="width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                            <i class="ti ti-clock fs-3"></i>
                        </div>
                        <h5 class="fw-bold mt-4">Waktu Pengisian</h5>
                        <p class="text-muted small fw-medium">Pastikan mengisi mutabaah harian sebelum pukul 21:00 WIB agar tercatat secara otomatis ke sistem.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-modern h-100 border-0 shadow-sm"
                        style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);">
                        <div class="card-icon bg-primary text-white shadow-primary"
                            style="width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                            <i class="ti ti-target fs-3"></i>
                        </div>
                        <h5 class="fw-bold mt-4">Target Ibadah</h5>
                        <p class="text-muted small fw-medium">Fokus pada kualitas sholat wajib tepat waktu dan amalan sunnah harian sesuai arahan pembimbing.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-modern h-100 border-0 shadow-sm"
                        style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);">
                        <div class="card-icon bg-primary text-white shadow-primary"
                            style="width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                            <i class="ti ti-info-circle fs-3"></i>
                        </div>
                        <h5 class="fw-bold mt-4">Butuh Bantuan?</h5>
                        <p class="text-muted small fw-medium">Jika mengalami kendala teknis saat login atau pengisian, silakan hubungi tim IT/Admin sekolah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tutorial Section -->
    <section id="tutorial" class="py-5 bg-mesh">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-extra-bold">Panduan <span
                        class="text-primary border-bottom border-4 border-primary">Pengisian</span></h2>
                <p class="text-muted mt-3 fw-medium">Ikuti langkah berikut untuk mengisi laporan mutabaah Anda.</p>
            </div>
            <div class="row text-center mt-5">
                <div class="col-md-4 mb-4">
                    <div class="card-modern border-0 shadow-sm py-5" style="background: rgba(255,255,255,0.4);">
                        <div class="avtar avtar-xl bg-primary text-white mx-auto mb-4 fs-3 shadow-primary"
                            style="width: 80px; height: 80px; border-radius: 20px;">1</div>
                        <h5 class="fw-bold">Login Portal</h5>
                        <p class="text-muted px-lg-4 small fw-medium">Gunakan email dan password yang telah didaftarkan oleh sekolah.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card-modern border-0 shadow-sm py-5 highlight-card"
                        style="background: rgba(255,255,255,0.8); transform: scale(1.05); z-index: 10;">
                        <div class="avtar avtar-xl bg-primary text-white mx-auto mb-4 fs-3 shadow-primary"
                            style="width: 80px; height: 80px; border-radius: 20px;">2</div>
                        <h5 class="fw-bold">Isi Checklist</h5>
                        <p class="text-muted px-lg-4 small fw-medium">Pilih tanggal dan centang amalan yang telah Anda laksanakan hari ini.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card-modern border-0 shadow-sm py-5" style="background: rgba(255,255,255,0.4);">
                        <div class="avtar avtar-xl bg-primary text-white mx-auto mb-4 fs-3 shadow-primary"
                            style="width: 80px; height: 80px; border-radius: 20px;">3</div>
                        <h5 class="fw-bold">Pantau Perkembangan</h5>
                        <p class="text-muted px-lg-4 small fw-medium">Lihat statistik, streak, dan badges yang Anda dapatkan di dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="bg-primary text-white py-5">
        <div class="container text-center py-4">
            <i class="ti ti-quote fs-huge opacity-25"></i>
            <h3 class="display-6 fst-italic mb-4">"Amal yang paling dicintai oleh Allah adalah amal yang berkelanjutan
                (istiqomah), walaupun sedikit."</h3>
            <p class="fs-5 opacity-75">— Hadits Riwayat Muslim</p>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-5 bg-mesh-bottom">
        <div class="container max-w-800">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-extra-bold">Pertanyaan <span
                        class="text-primary border-bottom border-4 border-primary">Umum</span></h2>
                <p class="text-muted mt-3 fw-medium">Segala hal yang perlu Anda ketahui tentang platform kami.</p>
            </div>
            <div class="accordion accordion-flush" id="faqAccordion">
                <div class="accordion-item card-modern mb-3 p-0 overflow-hidden border-0 shadow-sm"
                    style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold px-4 py-4 fs-5" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq1">
                            Apakah aplikasi ini bisa diakses di smartphone?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted px-4 pb-4 fw-medium">
                            Ya, Amal Yaumi didesain secara responsive (Mobile Friendly). Siswa dapat mengakses melalui
                            browser di HP dengan tampilan yang optimal.
                        </div>
                    </div>
                </div>
                <div class="accordion-item card-modern mb-3 p-0 overflow-hidden border-0 shadow-sm"
                    style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold px-4 py-4 fs-5" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq2">
                            Bagaimana cara mengekspor laporan?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted px-4 pb-4 fw-medium">
                            Admin dapat masuk ke menu Laporan, pilih rentang waktu, dan klik tombol Export ke PDF atau
                            Excel secara instan.
                        </div>
                    </div>
                </div>
                <div class="accordion-item card-modern mb-3 p-0 overflow-hidden border-0 shadow-sm"
                    style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold px-4 py-4 fs-5" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq3">
                            Apakah data siswa aman terjamin?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted px-4 pb-4 fw-medium">
                            Tentu, kami menggunakan teknologi Laravel terkini dengan sistem enkripsi dan role management
                            yang ketat untuk memastikan data tetap privat.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-4">Siap Melanjutkan <span class="text-primary">Amalan Hari Ini?</span>
            </h2>
            <p class="fs-5 mb-5 text-muted">Akses dashboard Anda sekarang untuk melihat statistik dan target harian.</p>
            <a href="{{ route('login') }}" class="btn btn-modern btn-modern-primary btn-lg px-5 py-3 shadow-lg">
                Masuk ke Dashboard
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center pt-5">
        <div class="container">
            <div class="row align-items-center border-top pt-4">
                <div class="col-md-12">
                    <p class="mb-0 text-muted fw-bold">&copy; {{ date('Y') }} Portal Amal Yaumi. Build for istiqomah.</p>
                </div>
            </div>
            <p class="mt-4 mb-0 pb-4 text-muted small">Media monitoring ibadah internal sekolah.</p>
        </div>
    </footer>

    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
</body>

</html>