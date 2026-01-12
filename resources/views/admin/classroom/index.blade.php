@extends('layouts.app')
@section('title', 'Data Kelas')
@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Daftar Kelas {{ $role == 'guru' ? 'Bimbingan Saya' : 'Keseluruhan' }}</h5>

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
                                <td><strong><a href="{{ route('admin.classroom.show', $k) }}"
                                            class="text-decoration-none">{{ $k->nama }}</a></strong></td>
                                <td>{{ $k->teacher->nama ?? 'Belum Diatur' }}</td>
                                <td>{{ $k->tingkat }}</td>
                                <td>{{ $k->kapasitas }}</td>
                                <td>
                                    <span class="badge bg-{{ $k->students_count >= $k->kapasitas ? 'danger' : 'success' }}">
                                        {{ $k->students_count }} / {{ $k->kapasitas }}
                                    </span>
                                </td>

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