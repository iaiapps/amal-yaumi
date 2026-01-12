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
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0"><i class="ti ti-school" style="font-size: 2.5rem;"></i></div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-white">Total Siswa Bimbingan</h6>
                        <h2 class="mb-0 text-white">{{ $totalStudents }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0"><i class="ti ti-check" style="font-size: 2.5rem;"></i></div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 text-white">Sudah Isi Hari Ini</h6>
                        <h2 class="mb-0 text-white">{{ $todayMutabaah }} / {{ $totalStudents }}</h2>
                    </div>
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
                    <div class="progress" style="height: 10px;">
                        @php
                            $rateClass = 'danger';
                            if($class->completion_rate >= 80) $rateClass = 'success';
                            elseif($class->completion_rate >= 50) $rateClass = 'warning';
                        @endphp
                        <div class="progress-bar bg-{{ $rateClass }}" 
                             role="progressbar" style="width: {{ $class->completion_rate }}%"></div>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ route('student.index', ['kelas' => $class->nama]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="ti ti-users"></i> Lihat Siswa
                    </a>
                    <a href="{{ route('mutabaah-item.index', ['classroom_id' => $class->id]) }}" class="btn btn-sm btn-outline-info">
                        <i class="ti ti-list-check"></i> Kelola Item Mutabaah
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
