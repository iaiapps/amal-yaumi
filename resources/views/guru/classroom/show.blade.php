@extends('layouts.app')
@section('title', 'Detail Kelas')

@section('content')
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Kelas</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="100">Nama Kelas</th>
                            <td>: {{ $classroom->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tingkat</th>
                            <td>: {{ $classroom->tingkat }}</td>
                        </tr>
                        <tr>
                            <th>Wali Kelas</th>
                            <td>: {{ $classroom->teacher->nama ?? 'Belum Diatur' }}</td>
                        </tr>
                        <tr>
                            <th>Kapasitas</th>
                            <td>: {{ $classroom->students->count() }} / {{ $classroom->kapasitas }} Siswa</td>
                        </tr>
                    </table>
                    <div class="mt-3">
                        <a href="{{ route($role . '.classroom.index') }}" class="btn btn-secondary w-100">Kembali</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Daftar Siswa</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>NIS</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->nis }}</td>
                                        <td>{{ $student->nama }}</td>
                                        <td>{{ $student->jenis_kelamin }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="ti ti-users mb-2" style="font-size: 2rem;"></i> <br>
                                            Belum ada siswa di kelas ini
                                        </td>
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