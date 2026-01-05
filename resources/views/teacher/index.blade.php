@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Data Guru</h5>
                    <a href="{{ route('teacher.create') }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-plus"></i> Tambah Guru
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>JK</th>
                                    <th>Telp</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teachers as $teacher)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($teacher->photo)
                                                <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Foto"
                                                    class="img-thumbnail" width="50">
                                            @else
                                                <div class="avtar avtar-xs bg-light-secondary">
                                                    <i class="ti ti-user"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $teacher->nama }}</td>
                                        <td>{{ $teacher->nip ?? '-' }}</td>
                                        <td>{{ $teacher->jk }}</td>
                                        <td>{{ $teacher->telp ?? '-' }}</td>
                                        <td>{{ $teacher->user->email }}</td>
                                        <td>
                                            <a href="{{ route('teacher.edit', $teacher) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('teacher.destroy', $teacher) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
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
                                        <td colspan="8" class="text-center">Tidak ada data guru</td>
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
