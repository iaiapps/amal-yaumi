@extends('layouts.app')
@section('title', 'Data Kelas')
@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="{{ route('classroom.create') }}" class="btn btn-primary btn-sm">
                <i class="ti ti-plus"></i> Tambah Kelas
            </a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Kapasitas</th>
                            <th>Jumlah Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $k->nama }}</strong></td>
                                <td>{{ $k->tingkat }}</td>
                                <td>{{ $k->kapasitas }}</td>
                                <td>
                                    <span class="badge bg-{{ $k->students_count >= $k->kapasitas ? 'danger' : 'success' }}">
                                        {{ $k->students_count }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('classroom.edit', $k) }}" class="btn btn-sm btn-warning">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <form action="{{ route('classroom.destroy', $k) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus kelas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data kelas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
