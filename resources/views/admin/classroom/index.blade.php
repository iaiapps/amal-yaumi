@extends('layouts.app')
@section('title', 'Data Semua Kelas')
@section('content')

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold text-primary">Daftar Seluruh Kelas</h5>
            <small class="text-muted">Total {{ $kelas->count() }} kelas aktif dalam sistem</small>
        </div>
    </div>
    <div class="card-body p-0">
        @if (session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger m-3">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="80" class="ps-4">No</th>
                        <th>Informasi Kelas</th>
                        <th>Guru Wali</th>
                        <th>Kapasitas</th>
                        <th width="100" class="text-center pe-4">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $k)
                        <tr>
                            <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $k->nama }}</div>
                                <div class="badge bg-light-secondary text-secondary" style="font-size: 0.7rem;">Tingkat {{ $k->tingkat }}</div>
                            </td>
                            <td>
                                @if($k->teacher)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs me-2 bg-light-info text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.7rem;">
                                            {{ substr($k->teacher->nama, 0, 1) }}
                                        </div>
                                        <span class="small">{{ $k->teacher->nama }}</span>
                                    </div>
                                @else
                                    <span class="text-muted small italic">Belum ditentukan</span>
                                @endif
                            </td>
                            <td>
                                <div class="progress" style="height: 6px; width: 100px;">
                                    @php $percent = $k->kapasitas > 0 ? ($k->students_count / $k->kapasitas) * 100 : 0; @endphp
                                    <div class="progress-bar bg-{{ $percent >= 100 ? 'danger' : 'success' }}" role="progressbar" style="width: {{ $percent }}%"></div>
                                </div>
                                <small class="text-muted">{{ $k->students_count }} / {{ $k->kapasitas }} Siswa</small>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('admin.classroom.show', $k) }}" class="btn btn-sm btn-icon btn-light-primary rounded-circle">
                                    <i class="ti ti-chevron-right"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="ti ti-alert-circle fs-1 mb-2 d-block text-light-secondary"></i>
                                Belum ada data kelas yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection