@extends('layouts.app')
@section('title', 'Data Kelas')
@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Daftar Kelas {{ $role == 'guru' ? 'Bimbingan Saya' : 'Keseluruhan' }}</h5>
            @if($role == 'guru')
                <div class="d-flex align-items-center">
                    <span class="me-3 badge bg-light text-dark">Limit: {{ $kelas->count() }} / {{ $maxClasses }} Kelas</span>
                    @if($kelas->count() < $maxClasses)
                        <a href="{{ route('guru.classroom.create') }}" class="btn btn-primary btn-sm">
                            <i class="ti ti-plus"></i> Buat Kelas Baru
                        </a>
                    @endif
                </div>
            @endif
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            @if($role == 'admin')
                                <th>Guru Wali</th>
                            @endif
                            <th>Tingkat</th>
                            <th>Kapasitas</th>
                            <th>Jumlah Siswa</th>
                            @if($role == 'guru')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong><a href="{{ route($role . '.classroom.show', $k) }}"
                                            class="text-decoration-none">{{ $k->nama }}</a></strong></td>
                                @if($role == 'admin')
                                    <td>{{ $k->teacher->nama ?? 'Belum Diatur' }}</td>
                                @endif
                                <td>{{ $k->tingkat }}</td>
                                <td>{{ $k->kapasitas }}</td>
                                <td>
                                    <span class="badge bg-{{ $k->students_count >= $k->kapasitas ? 'danger' : 'success' }}">
                                        {{ $k->students_count }} / {{ $k->kapasitas }}
                                    </span>
                                </td>
                                @if($role == 'guru')
                                    <td>
                                        <a href="{{ route('guru.classroom.edit', $k) }}" class="btn btn-sm btn-warning">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('guru.classroom.destroy', $k) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin hapus kelas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $role == 'admin' ? 7 : 6 }}" class="text-center">Belum ada data kelas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection