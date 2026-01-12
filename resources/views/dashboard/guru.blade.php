@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('content')

<div class="row">
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-0">Selamat Datang, {{ $teacher->nama }}!</h3>
                <p class="text-muted">Monitoring kelas yang Anda bimbing</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body d-flex align-items-center">
                <i class="ti ti-school" style="font-size: 2.5rem;"></i>
                <div class="ms-3">
                    <h6 class="text-white mb-0">Total Siswa Bimbingan</h6>
                    <h2 class="text-white mb-0">{{ $totalStudents }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body d-flex align-items-center">
                <i class="ti ti-check" style="font-size: 2.5rem;"></i>
                <div class="ms-3">
                    <h6 class="text-white mb-0">Sudah Isi Hari Ini</h6>
                    <h2 class="text-white mb-0">{{ $todayMutabaah }} / {{ $totalStudents }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach($classStats as $class)
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Kelas {{ $class->nama }}</h5>
                <span class="badge bg-primary">{{ $class->students_count }} Siswa</span>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Rate Aktif Bulan Ini</span>
                        <span class="fw-bold">{{ $class->completion_rate }}%</span>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ route('student.index', ['kelas' => $class->nama]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="ti ti-users"></i> Lihat Siswa
                    </a>
                    <a href="{{ route('mutabaah.calendar', ['month' => now()->format('Y-m')]) }}" class="btn btn-sm btn-outline-info">
                        <i class="ti ti-calendar"></i> Kalender Mutabaah
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
