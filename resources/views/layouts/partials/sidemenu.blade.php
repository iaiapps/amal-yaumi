@php
    $user = Auth::user();
    $role = $user->getRoleNames()->first();
    $name = $user->name;
    // dd($role);
@endphp

<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <div class="avtar avtar-sm bg-primary me-3"><i class=" text-white ti ti-user"></i></div>
            <a class="mb-0 link-offset-3"> {{ $name }}</a>

        </div>
        {{-- <div class="m-header">
            <a href="../dashboard/index.html" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ asset('berry/dist/assets/images/logo-dark.svg') }} " alt="logo" class="logo logo-lg" />
            </a>
        </div> --}}
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>Dashboard</label>
                    <i class="ti ti-dashboard"></i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('home') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-smart-home"></i></span>
                        <span class="pc-mtext">Home</span></a>
                </li>

                @switch($role)
                    @case('admin')
                        <li class="pc-item pc-caption">
                            <label>Component</label>
                            <i class="ti ti-apps"></i>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('student.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-school"></i></span>
                                <span class="pc-mtext">Siswa</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('mutabaah.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-list-numbers"></i></span>
                                <span class="pc-mtext">Mutabaah</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('reports.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-file-analytics"></i></span>
                                <span class="pc-mtext">Laporan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('import.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-file-upload"></i></span>
                                <span class="pc-mtext">Import Data</span>
                            </a>
                        </li>
                        {{-- <li class="pc-item">
                            <a href="../elements/icon-tabler.html" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-message-2"></i></span>
                                <span class="pc-mtext">Jawaban</span>
                            </a>
                        </li> --}}
                        <li class="pc-item pc-caption">
                            <label>Others</label>
                            <i class="ti ti-apps"></i>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('user.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-users"></i></span>
                                <span class="pc-mtext">Master User</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('profile.edit') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-user"></i></span>
                                <span class="pc-mtext">Profile</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('school.edit') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-building"></i></span>
                                <span class="pc-mtext">Profil Sekolah</span>
                            </a>
                        </li>
                    @break

                    @case('siswa')
                        <li class="pc-item pc-caption">
                            <label>Component</label>
                            <i class="ti ti-apps"></i>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('amal.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-list-numbers"></i></span>
                                <span class="pc-mtext">Mutabaah</span>
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
                <div class="badge theme-version badge rounded-pill bg-light text-dark f-12"><small>versi 1.0</small>
                </div>
            </div>
        </div>
    </div>
</nav>
