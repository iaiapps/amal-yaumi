@extends('layouts.app')
@section('title', 'Dashboard Siswa')
@section('content')

<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">Dashboard Amal Yaumi</h4>
                        <p class="text-muted mb-0">Selamat datang, {{ $student->nama }} - {{ $student->kelas }}</p>
                    </div>
                    <div>
                        <a href="{{ route('amal.create') }}" class="btn btn-primary btn-sm">
                            <i class="ti ti-plus"></i> Isi Mutabaah
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
                        <i class="ti ti-calendar-month" style="font-size: 3rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-white">Mutabaah Bulan Ini</h6>
                        <h2 class="mb-0 text-white">{{ $monthlyCount }}</h2>
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
                        <i class="ti ti-flame" style="font-size: 3rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-white">Streak</h6>
                        <h2 class="mb-0 text-white">{{ $streak }} Hari</h2>
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
                        <i class="ti ti-chart-pie" style="font-size: 3rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-white">Progress Bulan Ini</h6>
                        <h2 class="mb-0 text-white">{{ number_format($progressPercentage, 0) }}%</h2>
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
                <h5>Grafik Personal 7 Hari Terakhir</h5>
            </div>
            <div class="card-body">
                <canvas id="personalChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h5>Progress Bulan Ini</h5>
            </div>
            <div class="card-body text-center">
                <div class="position-relative d-inline-block">
                    <canvas id="progressChart" width="200" height="200"></canvas>
                </div>
                <p class="mt-3 mb-0">{{ $monthlyCount }} dari {{ now()->daysInMonth }} hari</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Mutabaah Terbaru</h5>
                <a href="{{ route('amal.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Puasa</th>
                                <th>Subuh</th>
                                <th>Dhuhur</th>
                                <th>Ashar</th>
                                <th>Magrib</th>
                                <th>Isya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMutabaah as $m)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($m->tanggal)->format('d M Y') }}</td>
                                <td><span class="badge bg-{{ $m->puasa == 'Ya' ? 'success' : 'secondary' }}">{{ $m->puasa }}</span></td>
                                <td><span class="badge bg-{{ $m->subuh == 'Ya' ? 'success' : 'secondary' }}">{{ $m->subuh }}</span></td>
                                <td><span class="badge bg-{{ $m->dhuhur == 'Ya' ? 'success' : 'secondary' }}">{{ $m->dhuhur }}</span></td>
                                <td><span class="badge bg-{{ $m->ashar == 'Ya' ? 'success' : 'secondary' }}">{{ $m->ashar }}</span></td>
                                <td><span class="badge bg-{{ $m->magrib == 'Ya' ? 'success' : 'secondary' }}">{{ $m->magrib }}</span></td>
                                <td><span class="badge bg-{{ $m->isya == 'Ya' ? 'success' : 'secondary' }}">{{ $m->isya }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data mutabaah</td>
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
// Personal Chart
const personalCtx = document.getElementById('personalChart').getContext('2d');
new Chart(personalCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($personalData, 'date')) !!},
        datasets: [{
            label: 'Mutabaah Terisi',
            data: {!! json_encode(array_column($personalData, 'filled')) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 1,
                ticks: {
                    stepSize: 1,
                    callback: function(value) {
                        return value === 1 ? 'Terisi' : 'Kosong';
                    }
                }
            }
        }
    }
});

// Progress Chart
const progressCtx = document.getElementById('progressChart').getContext('2d');
new Chart(progressCtx, {
    type: 'doughnut',
    data: {
        labels: ['Terisi', 'Belum'],
        datasets: [{
            data: [{{ $monthlyCount }}, {{ now()->daysInMonth - $monthlyCount }}],
            backgroundColor: [
                'rgba(75, 192, 192, 0.8)',
                'rgba(201, 203, 207, 0.8)'
            ]
        }]
    },
    options: {
        responsive: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endpush
