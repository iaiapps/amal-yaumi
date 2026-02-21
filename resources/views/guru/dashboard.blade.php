@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('content')

    <div class="row">
        <!-- Welcome Card -->
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #16595a 0%, #0a2e2f 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h2 class="text-white fw-bold mb-2">Selamat datang, {{ $teacher->nama }}!</h2>
                            <p class="text-white text-opacity-75 mb-3 fs-5">Semoga hari ini penuh keberkahan.</p>

                            <div class="d-inline-flex align-items-center bg-white bg-opacity-10 border border-white border-opacity-20 rounded-3 p-2 mb-3">
                                <span class="text-white text-opacity-75 small me-2 ps-2">KODE GURU:</span>
                                <span class="badge bg-warning text-dark fw-bold fs-6 px-3 py-2">{{ $teacher->getTeacherCode() }}</span>
                                <button class="btn btn-sm btn-link text-white text-opacity-50 ms-1" onclick="copyToClipboard('{{ $teacher->getTeacherCode() }}')">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('guru.mutabaah.calendar') }}" class="btn btn-light text-primary fw-bold">
                                    <i class="ti ti-calendar-event"></i> Kalender
                                </a>
                                <a href="{{ route('guru.reports.index') }}" class="btn btn-outline-light">
                                    <i class="ti ti-file-analytics"></i> Laporan
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5 mt-4 mt-md-0">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center">
                                        <div class="text-white text-opacity-50 small mb-1">TINGKAT PENGISIAN</div>
                                        <div class="h3 mb-0 text-white fw-bold">{{ $submissionRateToday }}%</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center">
                                        <div class="text-white text-opacity-50 small mb-1">DATA BULAN INI</div>
                                        <div class="h3 mb-0 text-white fw-bold">{{ $monthlyTotal }}</div>
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
        <div class="col-6 col-lg mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-sm bg-light-primary text-primary rounded-3 me-3">
                            <i class="ti ti-users fs-3"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Total Siswa</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalStudents }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-sm bg-light-success text-success rounded-3 me-3">
                            <i class="ti ti-check fs-3"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Isi Hari Ini</h6>
                            <h4 class="mb-0 fw-bold">{{ $todayMutabaah }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-sm bg-light-warning text-warning rounded-3 me-3">
                            <i class="ti ti-alert-triangle fs-3"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Belum Isi</h6>
                            <h4 class="mb-0 fw-bold text-danger">{{ $totalStudents - $todayMutabaah }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-sm bg-light-danger text-danger rounded-3 me-3">
                            <i class="ti ti-flame fs-3"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Streak Tertinggi</h6>
                            <h4 class="mb-0 fw-bold">{{ $highestStreak }} <span class="small text-muted">hari</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-sm bg-light-success text-success rounded-3 me-3">
                            <i class="ti ti-chart-pie fs-3"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Rata-rata Pengisian</h6>
                            <h4 class="mb-0 fw-bold">{{ round($avgCompletionRate) }}%</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8 mb-4">
            <!-- Trend Chart -->
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-chart-line me-1"></i> Tren Keaktifan</h5>
                    <small class="text-muted">14 hari terakhir</small>
                </div>
                <div class="card-body px-3 pb-3">
                    <div style="height: 220px;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Perkembangan Kelas + Liga Kelas -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold"><i class="ti ti-school me-1"></i> Perkembangan Kelas</h5>
                        <small class="text-muted">Ringkasan per kelas</small>
                    </div>
                    <a href="{{ route('guru.classroom.index') }}" class="btn btn-sm btn-link text-decoration-none">Kelola Kelas</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($classStats as $class)
                            <div class="col-md-6 mb-3">
                                <div class="border rounded-3 p-3 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold mb-1">Kelas {{ $class->nama }}</h6>
                                            <small class="text-muted">{{ $class->students_count }} Siswa</small>
                                        </div>
                                        <span class="badge {{ $class->completion_rate >= 75 ? 'bg-success' : ($class->completion_rate >= 50 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $class->completion_rate }}%
                                        </span>
                                    </div>
                                    <div class="progress rounded-pill mb-2" style="height: 6px;">
                                        <div class="progress-bar {{ $class->completion_rate >= 75 ? 'bg-success' : ($class->completion_rate >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                            role="progressbar" style="width: {{ $class->completion_rate }}%"></div>
                                    </div>
                                    @if(isset($leaderboards[$class->nama]) && count($leaderboards[$class->nama]) > 0)
                                        <div class="mt-2 pt-2 border-top">
                                            <small class="text-muted d-block mb-1">Top 3:</small>
                                            @foreach($leaderboards[$class->nama]->take(3) as $idx => $leader)
                                                <span class="badge bg-light text-dark me-1">
                                                    @if($idx == 0)🥇@elseif($idx == 1)🥈@elseif($idx == 2)🥉@endif
                                                    {{ $leader->nama }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4 mb-4">
            <!-- Perlu Perhatian -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold text-danger"><i class="ti ti-urgent me-1"></i> Perlu Perhatian</h5>
                    <small class="text-muted">Tidak mengisi >3 hari</small>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($inactiveStudents as $student)
                            <li class="list-group-item d-flex align-items-center px-3 py-2 border-0">
                                <div class="avtar avtar-s bg-light-danger text-danger rounded-circle me-2">
                                    {{ substr($student->nama, 0, 1) }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 small">{{ $student->nama }}</h6>
                                    <span class="badge bg-light-secondary text-muted" style="font-size: 9px;">{{ $student->kelas }}</span>
                                </div>
                                <a href="{{ route('guru.mutabaah.student-calendar', $student->id) }}" class="btn btn-icon btn-light-danger btn-sm">
                                    <i class="ti ti-eye"></i>
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-4 text-muted border-0">
                                <i class="ti ti-circle-check fs-1 text-success"></i>
                                <p class="mb-0 small mt-2">Semua siswa aktif!</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Siswa Inspiratif -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-award me-1 text-warning"></i> Siswa Inspiratif</h5>
                    <small class="text-muted">Top 5 bulan ini</small>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($topStudents as $student)
                            <li class="list-group-item d-flex align-items-center px-3 py-2 border-0">
                                <div class="position-relative me-2">
                                    <div class="avtar avtar-s bg-light-warning text-warning rounded-circle fw-bold">
                                        {{ substr($student->nama, 0, 1) }}
                                    </div>
                                    @if($loop->first)
                                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-warning" style="font-size: 8px;">1</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 small">{{ $student->nama }}</h6>
                                    <small class="text-muted">{{ $student->kelas }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success">{{ $student->mutabaah_count }} hari</span>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-4 text-muted border-0">Belum ada data</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('trendChart').getContext('2d');
            
            var gradient = ctx.createLinearGradient(0, 0, 0, 200);
            gradient.addColorStop(0, 'rgba(22, 89, 90, 0.4)');
            gradient.addColorStop(1, 'rgba(22, 89, 90, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_column($trendData, 'date')) !!},
                    datasets: [{
                        label: 'Persentase',
                        data: {!! json_encode(array_column($trendData, 'rate')) !!},
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: '#16595a',
                        borderWidth: 2,
                        tension: 0.4,
                        pointBackgroundColor: '#16595a',
                        pointRadius: 3,
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(22, 89, 90, 0.9)',
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + '% Siswa Mengisi';
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: {
                            beginAtZero: true,
                            suggestedMax: 100,
                            ticks: {
                                stepSize: 20,
                                callback: function(value) { return value + '%'; }
                            },
                            grid: { color: '#f1f1f1' }
                        }
                    }
                }
            });
        });

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Kode Guru disalin ke clipboard!');
            });
        }
    </script>
@endpush
