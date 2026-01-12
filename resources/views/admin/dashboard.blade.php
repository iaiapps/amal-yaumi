@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3>Selamat Datang, {{ auth()->user()->name }}!</h3>
                <p class="text-muted">Ringkasan operasional sistem Amal Yaumi</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body d-flex align-items-center">
                <i class="ti ti-school fs-1"></i>
                <div class="ms-3">
                    <h6 class="text-white mb-0">Total Siswa</h6>
                    <h3 class="text-white mb-0">{{ $totalStudents }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body d-flex align-items-center">
                <i class="ti ti-user-check fs-1"></i>
                <div class="ms-3">
                    <h6 class="text-white mb-0">Siswa Aktif</h6>
                    <h3 class="text-white mb-0">{{ $activeStudents }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body d-flex align-items-center">
                <i class="ti ti-percentage fs-1"></i>
                <div class="ms-3">
                    <h6 class="text-white mb-0">Completion Rate</h6>
                    <h3 class="text-white mb-0">{{ $completionRate }}%</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body d-flex align-items-center">
                <i class="ti ti-users fs-1"></i>
                <div class="ms-3">
                    <h6 class="text-white mb-0">Total Guru</h6>
                    <h3 class="text-white mb-0">{{ $totalTeachers }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Monitoring Performa Guru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Guru</th>
                                <th class="text-center">Kelas Dibimbing</th>
                                <th class="text-center">Total Siswa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachersList as $t)
                            <tr>
                                <td><strong>{{ $t->nama }}</strong></td>
                                <td class="text-center"><span class="badge bg-primary">{{ $t->classrooms_count }} Kelas</span></td>
                                <td class="text-center"><span class="badge bg-success">{{ $t->students_count }} Siswa</span></td>
                                <td><a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-outline-info">Detail</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">📈 Trend Completion Rate (30 Hari)</h5>
            </div>
            <div class="card-body">
                <canvas id="trendChart" height="150"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">📊 Distribusi Siswa</h5>
            </div>
            <div class="card-body">
                <canvas id="classChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">🏆 Top 5 Siswa Bulan Ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr><th>Nama</th><th>Kelas</th><th>Total</th><th>Streak</th></tr>
                        </thead>
                        <tbody>
                            @foreach($topStudents as $s)
                            <tr><td>{{ $s->nama }}</td><td>{{ $s->kelas }}</td><td>{{ $s->total_mutabaah }}</td><td>🔥 {{ $s->streak }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card h-100 text-warning border-warning">
            <div class="card-header border-warning bg-warning-subtle">
                <h5 class="mb-0 text-warning-emphasis">⚠️ Siswa Tidak Aktif (3 Hari Terakhir)</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($inactiveStudents as $s)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $s->nama }} <span class="badge bg-warning">{{ $s->kelas }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted">Semua siswa aktif mengisi!</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var trendDataArr = JSON.parse('{!! json_encode(array_column($trendData, "rate")) !!}');
    var trendLabelsArr = JSON.parse('{!! json_encode(array_column($trendData, "date")) !!}');
    var classDataArr = JSON.parse('{!! json_encode($statsByClass->pluck("total_students")) !!}');
    var classLabelsArr = JSON.parse('{!! json_encode($statsByClass->pluck("kelas")) !!}');

    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: trendLabelsArr,
            datasets: [{
                label: 'Rate (%)',
                data: trendDataArr,
                borderColor: '#4680FF',
                backgroundColor: 'rgba(70, 128, 255, 0.1)',
                tension: 0.4,
                fill: true
            }]
        }
    });

    new Chart(document.getElementById('classChart'), {
        type: 'doughnut',
        data: {
            labels: classLabelsArr,
            datasets: [{
                data: classDataArr,
                backgroundColor: ['#4680FF', '#2CA87F', '#FFB64D', '#FF5370', '#62d1f3']
            }]
        }
    });
</script>
@endpush
