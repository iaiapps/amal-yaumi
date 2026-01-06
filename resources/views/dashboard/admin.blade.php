@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-column flex-sm-row">
                        <div>
                            <h3 class="text-muted mb-0">Selamat datang, {{ auth()->user()->name }}!</h3>
                        </div>
                        <div>
                            <a href="{{ route('student.create') }}" class="btn btn-primary btn-sm me-2">
                                <i class="ti ti-plus"></i> Tambah Siswa
                            </a>
                            <a href="{{ route('mutabaah.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="ti ti-list"></i> Lihat Mutabaah
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex">
                        <div class="p-3 border profil me-2 d-flex justify-content-center align-items-center"> <i
                                class="ti ti-user display-4"></i> </div>
                        <table class="table table-bordered mb-0">
                            <tr>
                                <td>Nama Guru</td>
                                <td>{{ $teacher->nama ?? 'belum diisi' }}</td>
                            </tr>
                            <tr>
                                <td>No Handphone</td>
                                <td>{{ $teacher->telp ?? 'belum diisi' }}</td>

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Siswa Tidak Aktif --}}
    @if ($inactiveStudents->count() > 0)
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="ti ti-alert-triangle me-2" style="font-size: 1.5rem;"></i>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading mb-2">⚠️ {{ $inactiveStudents->count() }} Siswa Perlu Perhatian</h5>
                            <p class="mb-2">Siswa berikut tidak mengisi mutabaah dalam 3 hari terakhir:</p>
                            <ul class="mb-0">
                                @foreach ($inactiveStudents->take(5) as $student)
                                    <li>
                                        <strong>{{ $student->nama }}</strong> ({{ $student->kelas }})
                                        <a href="{{ route('student.show', $student->id) }}"
                                            class="btn btn-sm btn-outline-warning ms-2">
                                            <i class="ti ti-eye"></i> Lihat
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            @if ($inactiveStudents->count() > 5)
                                <small class="text-muted">Dan {{ $inactiveStudents->count() - 5 }} siswa lainnya...</small>
                            @endif
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-school" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white">Total Siswa</h6>
                            <h2 class="mb-0 text-white">{{ $totalStudents }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-user-check" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white">Siswa Aktif (<small
                                    class="text-white">{{ $totalStudents > 0 ? round(($activeStudents / $totalStudents) * 100, 1) : 0 }}%</small>)
                            </h6>
                            <h2 class="mb-0 text-white">{{ $activeStudents }}</h2>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-percentage" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white">Tingkat Penyelesaian</h6>
                            <h2 class="mb-0 text-white">{{ $completionRate }}%</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-chart-bar" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white">Avg per Siswa</h6>
                            <h2 class="mb-0 text-white">{{ $avgPerStudent }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Trend Chart --}}
    <div class="row">
        <div class="col-md-8 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5>📈 Trend Completion Rate 30 Hari Terakhir</h5>
                </div>
                <div class="card-body">
                    <canvas id="trendChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5>📊 Distribusi Siswa Per Kelas</h5>
                </div>
                <div class="card-body">
                    <canvas id="classChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats per Kelas & Top 5 --}}
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5>📊 Statistik Per Kelas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kelas</th>
                                    <th>Total</th>
                                    <th>Aktif</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statsByClass as $class)
                                    <tr>
                                        <td><strong>{{ $class->kelas }}</strong></td>
                                        <td>{{ $class->total_students }}</td>
                                        <td>{{ $class->active_students }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $class->completion_rate >= 80 ? 'success' : ($class->completion_rate >= 60 ? 'warning' : 'danger') }}">
                                                {{ $class->completion_rate }}%
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5>🏆 Top 5 Siswa Bulan Ini</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Total</th>
                                    <th>Streak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topStudents as $student)
                                    <tr>
                                        <td>
                                            @if ($loop->iteration == 1)
                                                <span class="badge bg-warning">🥇</span>
                                            @elseif($loop->iteration == 2)
                                                <span class="badge bg-secondary">🥈</span>
                                            @elseif($loop->iteration == 3)
                                                <span class="badge bg-danger">🥉</span>
                                            @else
                                                <span class="badge bg-light text-dark">#{{ $loop->iteration }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $student->nama }}</td>
                                        <td>{{ $student->kelas }}</td>
                                        <td><span class="badge bg-primary">{{ $student->total_mutabaah }}</span></td>
                                        <td><span class="badge bg-success">🔥 {{ $student->streak }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .profil {
            width: 100px;
            height: 100px;
        }
    </style>
@endpush

@push('js')
    <script>
        // Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($trendData, 'date')) !!},
                datasets: [{
                    label: 'Completion Rate (%)',
                    data: {!! json_encode(array_column($trendData, 'rate')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + '%';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });

        // Doughnut Chart - Distribusi Siswa Per Kelas
        const classCtx = document.getElementById('classChart').getContext('2d');
        new Chart(classCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statsByClass->pluck('kelas')) !!},
                datasets: [{
                    data: {!! json_encode($statsByClass->pluck('total_students')) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endpush
