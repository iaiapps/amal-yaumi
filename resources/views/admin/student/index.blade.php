@extends('layouts.app')
@section('title', 'Data Semua Siswa')
@section('content')

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold text-primary">Daftar Seluruh Siswa</h5>
            <small class="text-muted">Total {{ $students->count() }} siswa terdaftar dalam sistem</small>
        </div>
    </div>
    <div class="card-body p-0">
        @if (session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="80" class="ps-4">No</th>
                        <th>Student Information</th>
                        <th>NIS</th>
                        <th>Gender</th>
                        <th>Kelas</th>
                        <th width="120" class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $student->nama }}</div>
                                <small class="text-muted">{{ $student->user->email ?? '' }}</small>
                            </td>
                            <td><span class="text-monospace">{{ $student->nis }}</span></td>
                            <td>
                                <span class="badge bg-light-{{ $student->jk == 'L' ? 'info' : 'danger' }} text-{{ $student->jk == 'L' ? 'info' : 'danger' }}">
                                    {{ $student->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill px-3">{{ $student->kelas }}</span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('admin.mutabaah.student-calendar', $student) }}" class="btn btn-sm btn-light-info rounded-pill px-3">
                                    <i class="ti ti-calendar-stats me-1"></i> Monitor
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection