@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('content')

    <div class="row">
        <!-- Welcome & Stats -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm overflow-hidden" 
                style="background: linear-gradient(135deg, #16595a 0%, #0a2e2f 100%); border-radius: 15px;">
                <div class="card-body p-4 position-relative">
                    <div class="row align-items-center position-relative z-index-1">
                        <div class="col-md-7">
                            <h2 class="text-white fw-bold mb-2">Ahlan wa Sahlan, {{ $teacher->nama }}! 👋</h2>
                            <p class="text-white text-opacity-75 mb-4 fs-5">Semoga hari ini penuh keberkahan dalam membimbing para santri.</p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('guru.mutabaah.calendar') }}" class="btn btn-light text-primary fw-bold">
                                    <i class="ti ti-calendar-event"></i> Kalender Monitoring
                                </a>
                                <a href="{{ route('guru.reports.index') }}" class="btn btn-outline-light">
                                    <i class="ti ti-file-analytics"></i> Laporan
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5 mt-4 mt-md-0">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center border border-white border-opacity-10">
                                        <div class="text-white text-opacity-50 small mb-1">TINGKAT PENGISIAN</div>
                                        <div class="h2 mb-0 text-white fw-bold">{{ $submissionRateToday }}%</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center border border-white border-opacity-10">
                                        <div class="text-white text-opacity-50 small mb-1">TOTAL DATA BULAN INI</div>
                                        <div class="h2 mb-0 text-white fw-bold">{{ $monthlyTotal }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avtar avtar-s bg-light-primary text-primary rounded-circle me-2">
                            <i class="ti ti-users"></i>
                        </div>
                        <h6 class="mb-0 text-muted">Total Siswa</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h3 class="mb-0 fw-bold">{{ $totalStudents }}</h3>
                        <span class="ms-2 text-muted small">santri</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avtar avtar-s bg-light-success text-success rounded-circle me-2">
                            <i class="ti ti-check"></i>
                        </div>
                        <h6 class="mb-0 text-muted">Isi Hari Ini</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h3 class="mb-0 fw-bold">{{ $todayMutabaah }}</h3>
                        <span class="ms-2 text-muted small">santri</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avtar avtar-s bg-light-warning text-warning rounded-circle me-2">
                            <i class="ti ti-alert-triangle"></i>
                        </div>
                        <h6 class="mb-0 text-muted">Belum Isi</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h3 class="mb-0 fw-bold text-danger">{{ $totalStudents - $todayMutabaah }}</h3>
                        <span class="ms-2 text-muted small">santri</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avtar avtar-s bg-light-info text-info rounded-circle me-2">
                            <i class="ti ti-layout-grid"></i>
                        </div>
                        <h6 class="mb-0 text-muted">Kelas Binaan</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h3 class="mb-0 fw-bold">{{ $classrooms->count() }}</h3>
                        <span class="ms-2 text-muted small">kelas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Trend Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-chart-line me-1"></i> Tren Keaktifan Siswa</h5>
                    <small class="text-muted">Persentase pengisian mutabaah 14 hari terakhir</small>
                </div>
                <div class="card-body px-2">
                    <div id="trendChart"></div>
                </div>
            </div>
        </div>

        <!-- Inactive Students Alert -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-danger"><i class="ti ti-urgent me-1"></i> Perlu Perhatian</h5>
                    </div>
                    <small class="text-muted">Siswa tidak mengisi lebih dari 3 hari</small>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($inactiveStudents as $student)
                            <li class="list-group-item d-flex align-items-center px-4 py-3 border-0">
                                <div class="avtar avtar-s bg-light-danger text-danger rounded-circle me-3">
                                    {{ substr($student->nama, 0, 1) }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 text-truncate" style="max-width: 150px;">{{ $student->nama }}</h6>
                                    <span class="badge bg-light-secondary text-muted" style="font-size: 10px;">{{ $student->kelas }}</span>
                                </div>
                                <a href="{{ route('guru.mutabaah.student-calendar', $student->id) }}" class="btn btn-icon btn-light-danger btn-sm rounded-circle">
                                    <i class="ti ti-eye"></i>
                                </a>
                            </li>
                        @empty
                            <div class="text-center py-5">
                                <div class="avtar avtar-l bg-light-success text-success rounded-circle mb-3">
                                    <i class="ti ti-circle-check" style="font-size: 2rem;"></i>
                                </div>
                                <p class="text-muted small">Alhamdulillah, semua santri aktif!</p>
                            </div>
                        @endforelse
                    </ul>
                </div>
                @if($inactiveStudents->count() > 0)
                    <div class="card-footer bg-transparent border-0 text-center pb-4">
                        <a href="{{ route('guru.student.index') }}" class="btn btn-link btn-sm text-danger text-decoration-none fw-bold">Follow up semua siswa</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Class Stats -->
        <div class="col-lg-8 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold"><i class="ti ti-school me-1"></i> Perkembangan Kelas</h5>
                <a href="{{ route('guru.classroom.index') }}" class="btn btn-sm btn-link text-decoration-none">Kelola Kelas</a>
            </div>
            <div class="row">
                @foreach($classStats as $class)
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 shadow-sm h-100 overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="fw-bold mb-1">Kelas {{ $class->nama }}</h5>
                                        <p class="text-muted small mb-0">{{ $class->students_count }} Siswa terdaftar</p>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-icon btn-link-secondary dropdown-toggle arrow-none" data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                            <li><a class="dropdown-item" href="{{ route('guru.student.index', ['kelas' => $class->nama]) }}"><i class="ti ti-users me-2"></i> Daftar Siswa</a></li>
                                            <li><a class="dropdown-item" href="{{ route('guru.mutabaah.calendar') }}"><i class="ti ti-calendar me-2"></i> Monitor Harian</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="mb-3 mt-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small fw-bold">Target Kepatuhan Bulan Ini</span>
                                        <span class="small fw-bold {{ $class->completion_rate >= 75 ? 'text-success' : ($class->completion_rate >= 50 ? 'text-warning' : 'text-danger') }}">
                                            {{ $class->completion_rate }}%
                                        </span>
                                    </div>
                                    <div class="progress rounded-pill" style="height: 10px;">
                                        <div class="progress-bar {{ $class->completion_rate >= 75 ? 'bg-success' : ($class->completion_rate >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                            role="progressbar" style="width: {{ $class->completion_rate }}%"></div>
                                    </div>
                                </div>

                                <div class="row g-2 text-center mt-2">
                                    <div class="col-6">
                                        <div class="bg-light rounded-3 p-2 border border-light">
                                            <div class="h5 mb-0 fw-bold text-primary">{{ $class->active_students }}</div>
                                            <div class="text-muted" style="font-size: 9px; letter-spacing: 0.5px;">SISWA AKTIF</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light rounded-3 p-2 border border-light">
                                            <div class="h5 mb-0 fw-bold text-secondary">{{ $class->students_count - $class->active_students }}</div>
                                            <div class="text-muted" style="font-size: 9px; letter-spacing: 0.5px;">TIDAK AKTIF</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Side Cards: Top Students & Recent Activity -->
        <div class="col-lg-4">
            <!-- Top Students -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-award me-1 text-warning"></i> Siswa Inspiratif</h5>
                    <small class="text-muted">Keaktifan tertinggi bulan ini</small>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($topStudents as $student)
                            <li class="list-group-item d-flex align-items-center px-4 py-3 border-0">
                                <div class="position-relative">
                                    <div class="avtar avtar-s bg-light-warning text-warning rounded-circle me-3 fw-bold">
                                        {{ substr($student->nama, 0, 1) }}
                                    </div>
                                    @if($loop->first)
                                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-warning" style="font-size: 8px;">1</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 text-truncate" style="max-width: 140px;">{{ $student->nama }}</h6>
                                    <small class="text-muted" style="font-size: 11px;">{{ $student->kelas }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-success" style="font-size: 12px;">{{ $student->mutabaah_count }} Hari</div>
                                    <div class="small text-muted" style="font-size: 10px;">🔥 {{ $student->streak }} Hari</div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-4 text-muted border-0">Belum ada data bulan ini.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-history me-1"></i> Aktivitas Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentActivities as $activity)
                            <div class="list-group-item px-4 py-3 border-0 border-bottom">
                                <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0 fw-bold text-truncate" style="max-width: 150px;">
                                        {{ $activity->student->nama }}</h6>
                                    <small class="text-muted" style="font-size: 10px;">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 small text-muted">Baru saja mengisi mutabaah harian untuk kelas <span class="text-primary fw-bold">{{ $activity->student->kelas }}</span></p>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">Belum ada aktivitas baru.</div>
                        @endforelse
                    </div>
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