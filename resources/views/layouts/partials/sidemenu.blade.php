@php
    $user = Auth::user();
    $role = $user->getRoleNames()->first();
    $name = $user->name;
@endphp

<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <div class="avtar avtar-sm bg-primary me-3"><i class=" text-white ti ti-user"></i></div>
            <a class="mb-0 link-offset-3"> {{ $name }}</a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                @switch($role)
                    @case('admin')
                        <li class="pc-item pc-caption">
                            <label>Monitoring</label>
                            <i class="ti ti-chart-bar"></i>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('home') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                                <span class="pc-mtext">Dashboard Admin</span>
                            </a>
                        </li>
                        <li class="pc-item pc-caption">
                            <label>Master Data</label>
                            <i class="ti ti-apps"></i>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('admin.user.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-users"></i></span>
                                <span class="pc-mtext">Data Guru</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('admin.classroom.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-sitemap"></i></span>
                                <span class="pc-mtext">Semua Kelas</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('admin.student.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-school"></i></span>
                                <span class="pc-mtext">Semua Siswa</span>
                            </a>
                        </li>
                        <li class="pc-item pc-caption">
                            <label>Sistem</label>
                            <i class="ti ti-settings"></i>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('admin.setting.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-settings"></i></span>
                                <span class="pc-mtext">Pengaturan</span>
                            </a>
                        </li>
                    @break

                    @case('guru')
                        <li class="pc-item pc-caption">
                            <label>Menu Guru</label>
                            <i class="ti ti-apps"></i>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('home') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                                <span class="pc-mtext">Dashboard Guru</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('guru.classroom.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-sitemap"></i></span>
                                <span class="pc-mtext">Kelas Saya</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('guru.student.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-school"></i></span>
                                <span class="pc-mtext">Siswa Saya</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('guru.mutabaah.calendar') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-calendar"></i></span>
                                <span class="pc-mtext">Monitoring Mutabaah</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('guru.mutabaah-item.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-list-check"></i></span>
                                <span class="pc-mtext">Item Mutabaah</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('guru.reports.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-file-analytics"></i></span>
                                <span class="pc-mtext">Laporan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('guru.import.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-file-upload"></i></span>
                                <span class="pc-mtext">Import Siswa</span>
                            </a>
                        </li>
                        <li class="pc-item pc-caption">
                            <label>Akun</label>
                            <i class="ti ti-user"></i>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('profile.edit') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-user"></i></span>
                                <span class="pc-mtext">Profil</span>
                            </a>
                        </li>
                    @break

                    @case('siswa')
                        <li class="pc-item pc-caption">
                            <label>Menu</label>
                            <i class="ti ti-apps"></i>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('home') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('siswa.amal.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-list-numbers"></i></span>
                                <span class="pc-mtext">Mutabaah Saya</span>
                            </a>
                        </li>
                        <li class="pc-item pc-caption">
                            <label>Pengaturan</label>
                            <i class="ti ti-settings"></i>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('profile.edit') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-user"></i></span>
                                <span class="pc-mtext">Profil</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('profile.password') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-lock"></i></span>
                                <span class="pc-mtext">Ganti Password</span>
                            </a>
                        </li>
                    @break

                    @default
                        <li class="pc-item pc-caption">
                            <label>None</label>
                            <i class="ti ti-apps"></i>
                        </li>
                @endswitch
            </ul>

            <div class="w-100 text-center mt-4">
                <div class="badge theme-version badge rounded-pill bg-light text-dark f-12"><small>versi 1.1</small>
                </div>
            </div>
        </div>
    </div>
</nav>
