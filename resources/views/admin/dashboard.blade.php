@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3>Selamat Datang, {{ auth()->user()->name }}!</h3>
                    <p class="text-muted mb-0">Ringkasan statistik pengguna dan aktivitas sistem.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body d-flex align-items-center">
                    <i class="ti ti-users fs-1"></i>
                    <div class="ms-3">
                        <h6 class="text-white mb-0">Total Pengguna</h6>
                        <h3 class="text-white mb-0">{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body d-flex align-items-center">
                    <i class="ti ti-school fs-1"></i>
                    <div class="ms-3">
                        <h6 class="text-white mb-0">Total Guru</h6>
                        <h3 class="text-white mb-0">{{ $totalTeachers }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body d-flex align-items-center">
                    <i class="ti ti-user-check fs-1"></i>
                    <div class="ms-3">
                        <h6 class="text-white mb-0">Total Siswa</h6>
                        <h3 class="text-white mb-0">{{ $totalStudents }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body d-flex align-items-center">
                    <i class="ti ti-user-plus fs-1"></i>
                    <div class="ms-3">
                        <h6 class="text-white mb-0">User Baru (Bulan Ini)</h6>
                        <h3 class="text-white mb-0">+{{ $newUsersThisMonth }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">📈 Pertumbuhan Pengguna (6 Bulan Terakhir)</h5>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">📊 Distribusi Role</h5>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="roleChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">🏆 Guru Teraktif (Berdasarkan Siswa)</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Guru</th>
                                    <th class="text-center">Total Siswa</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeTeachers as $t)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-xs bg-light-primary text-primary rounded-circle me-2">
                                                    {{ substr($t->nama, 0, 1) }}
                                                </div>
                                                <strong>{{ $t->nama }}</strong>
                                            </div>
                                        </td>
                                        <td class="text-center"><span class="badge bg-primary">{{ $t->students_count }}</span>
                                        </td>
                                        <td class="text-center"><a href="#" class="btn btn-sm btn-link-primary">Detail</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">🆕 Pengguna Terbaru</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($recentUsers as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div class="d-flex align-items-center">
                                    <div class="avtar avtar-sm bg-light-secondary text-secondary rounded-circle me-3">
                                        <i class="ti ti-user"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                                <span class="text-muted small">{{ $user->created_at->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var growthLabels = @json($growthLabels);
        var growthData = @json($growthValues);

        var roleLabels = ['Admin', 'Guru', 'Siswa'];
        var roleData = @json($roleCounts);

        new Chart(document.getElementById('growthChart'), {
            type: 'line',
            data: {
                labels: growthLabels,
                datasets: [{
                    label: 'Pengguna Baru',
                    data: growthData,
                    borderColor: '#10b981', // Emerald Primary
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
            }
        });

        new Chart(document.getElementById('roleChart'), {
            type: 'doughnut',
            data: {
                labels: roleLabels,
                datasets: [{
                    data: roleData,
                    backgroundColor: ['#6366f1', '#10b981', '#3b82f6'] // Indigo, Emerald, Blue
                }]
            },
            options: {
                maintainAspectRatio: false,
            }
        });
    </script>
@endpush