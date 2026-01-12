@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('content')

    <div class="row">
        <!-- Welcome & Stats -->
        <div class="col-12 mb-4">
            <div class="card bg-primary text-white overflow-hidden"
                style="background: linear-gradient(45deg, #16595a, #0f4c4d);">
                <div class="card-body position-relative">
                    <!-- <div class="position-absolute end-0 top-0 opacity-10" style="margin-right: -20px; margin-top: -20px;">
                        <i class="ti ti-school" style="font-size: 10rem;"></i>
                    </div> -->
                    <div class="row align-items-center position-relative z-index-1">
                        <div class="col-md-8">
                            <h3 class="text-white fw-bold mb-1">Selamat Datang, {{ $teacher->nama }}!</h3>
                            <p class="text-white text-opacity-75 mb-0">Pantau perkembangan ibadah siswa bimbingan Anda hari
                                ini.</p>
                        </div>
                        <div class="col-md-4 mt-3 mt-md-0 text-md-end d-flex gap-4">
                            <div class="w-100 d-inline-block bg-white bg-opacity-25 rounded p-3 text-start">
                                <div class="text-white text-opacity-75">Total Siswa</div>
                                <div class="h3 mb-0 text-white">{{ $totalStudents }}</div>
                            </div>
                             <div class="w-100 d-inline-block bg-white bg-opacity-25 rounded p-3 text-start">
                                <div class="text-white text-opacity-75">Mengisi Hari Ini</div>
                                <div class="h3 mb-0 text-white">{{ $todayMutabaah }} <span class="fs-6 opacity-50">/
                                        {{ $totalStudents }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Trend Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tren Keaktifan Siswa (14 Hari Terakhir)</h5>
                </div>
                <div class="card-body">
                    <div id="trendChart"></div>
                </div>
            </div>
        </div>

        <!-- Top Students -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">🔥 Siswa Terrajin Bulan Ini</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($topStudents as $student)
                            <li class="list-group-item d-flex align-items-center px-4 py-3">
                                <div class="avtar avtar-s bg-light-primary text-primary rounded-circle me-3">
                                    {{ substr($student->nama, 0, 1) }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 text-truncate" style="max-width: 150px;">{{ $student->nama }}</h6>
                                    <small class="text-muted">{{ $student->kelas }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-light-success text-success mb-1">{{ $student->mutabaah_count }}
                                        Isi</span>
                                    <div class="small text-muted fw-bold">🔥 {{ $student->streak }} Hari</div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-4 text-muted">Belum ada data bulan ini.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Class Stats -->
        <div class="col-lg-8 mb-4">
            <h5 class="mb-3">Statistik Kelas Binaan</h5>
            <div class="row">
                @foreach($classStats as $class)
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 border-start border-4 border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="fw-bold mb-1">Kelas {{ $class->nama }}</h5>
                                        <span class="text-muted small">{{ $class->students_count }} Siswa</span>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('guru.student.index', ['kelas' => $class->nama]) }}">Lihat
                                                    Siswa</a></li>
                                            <li><a class="dropdown-item" href="{{ route('guru.mutabaah.calendar') }}">Kalender</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small text-muted">Keaktifan Bulan Ini</span>
                                        <span
                                            class="small fw-bold {{ $class->completion_rate >= 75 ? 'text-success' : ($class->completion_rate >= 50 ? 'text-warning' : 'text-danger') }}">
                                            {{ $class->completion_rate }}%
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar {{ $class->completion_rate >= 75 ? 'bg-success' : ($class->completion_rate >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                            role="progressbar" style="width: {{ $class->completion_rate }}%"></div>
                                    </div>
                                </div>

                                <div class="row g-2 text-center">
                                    <div class="col-6">
                                        <div class="bg-light rounded p-2">
                                            <div class="h5 mb-0">{{ $class->active_students }}</div>
                                            <div class="small text-muted" style="font-size: 10px;">SISWA AKTIF</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light rounded p-2">
                                            <div class="h5 mb-0">{{ $class->students_count - $class->active_students }}</div>
                                            <div class="small text-muted" style="font-size: 10px;">BELUM AKTIF</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4 mb-4">
            <h5 class="mb-3">Aktivitas Terbaru</h5>
            <div class="card">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentActivities as $activity)
                            <div class="list-group-item px-4 py-3">
                                <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0 fw-bold text-truncate" style="max-width: 150px;">
                                        {{ $activity->student->nama }}</h6>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 small text-muted">Mengisi Mutabaah Harian</p>
                                <small class="text-primary">{{ $activity->student->kelas }}</small>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">Belum ada aktivitas baru.</div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer text-center bg-transparent border-top-0 pb-3">
                    <a href="{{ route('guru.reports.index') }}" class="btn btn-link btn-sm text-decoration-none">Lihat Semua
                        Laporan</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var options = {
                series: [{
                    name: "Persentase Mengisi",
                    data: {!! json_encode(array_column($trendData, 'rate')) !!}
                }],
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif',
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: {!! json_encode(array_column($trendData, 'date')) !!},
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    max: 100,
                    tickAmount: 5,
                    labels: {
                        formatter: function (val) { return val.toFixed(0) + "%"; }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.2,
                        stops: [0, 90, 100]
                    }
                },
                colors: ['#16595a'],
                grid: {
                    borderColor: '#f1f1f1',
                    padding: { top: 0, right: 0, bottom: 0, left: 10 }
                },
                tooltip: {
                    y: {
                        formatter: function (val) { return val + "% Siswa" }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#trendChart"), options);
            chart.render();
        });
    </script>
@endpush