@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')

<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">Dashboard Amal Yaumi</h4>
                        <p class="text-muted mb-0">Selamat datang, {{ auth()->user()->name }}</p>
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
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="ti ti-school" style="font-size: 3rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-white">Total Siswa</h6>
                        <h2 class="mb-0 text-white">{{ $totalStudents }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="ti ti-user-check" style="font-size: 3rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-white">Total Guru</h6>
                        <h2 class="mb-0 text-white">{{ $totalTeachers }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="ti ti-list-check" style="font-size: 3rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-white">Mutabaah Hari Ini</h6>
                        <h2 class="mb-0 text-white">{{ $todayMutabaah }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header">
                <h5>Grafik Mutabaah 7 Hari Terakhir</h5>
            </div>
            <div class="card-body">
                <canvas id="weeklyChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h5>Statistik Per Kelas</h5>
            </div>
            <div class="card-body">
                <canvas id="classChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Top 5 Siswa Bulan Ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Ranking</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Total Mutabaah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topStudents as $student)
                            <tr>
                                <td>
                                    @if($loop->iteration == 1)
                                    <span class="badge bg-warning">🥇 #{{ $loop->iteration }}</span>
                                    @elseif($loop->iteration == 2)
                                    <span class="badge bg-secondary">🥈 #{{ $loop->iteration }}</span>
                                    @elseif($loop->iteration == 3)
                                    <span class="badge bg-danger">🥉 #{{ $loop->iteration }}</span>
                                    @else
                                    <span class="badge bg-light text-dark">#{{ $loop->iteration }}</span>
                                    @endif
                                </td>
                                <td>{{ $student->nama }}</td>
                                <td>{{ $student->kelas }}</td>
                                <td><span class="badge bg-primary">{{ $student->total_mutabaah }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data</td>
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
@endpush

@push('js')
<script>
// Weekly Chart
const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
new Chart(weeklyCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($weeklyData, 'date')) !!},
        datasets: [{
            label: 'Jumlah Mutabaah',
            data: {!! json_encode(array_column($weeklyData, 'count')) !!},
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Class Chart
const classCtx = document.getElementById('classChart').getContext('2d');
new Chart(classCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($statsByClass->pluck('kelas')) !!},
        datasets: [{
            data: {!! json_encode($statsByClass->pluck('total')) !!},
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
