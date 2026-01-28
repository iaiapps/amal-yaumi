@extends('layouts.app')
@section('title', 'Data Siswa')
@section('content')
    @session('success')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession
    <div class="card">
        <div class="ms-4 mt-4">
            <a href="{{ route('guru.student.create') }}" class="btn btn-primary btn-sm"> <i class="ti ti-plus"></i> tambah
                siswa</a>
        </div>
        <hr>
        <div class="px-4">
            <p class="mb-0">Username login aplikasi adalah <b>NIS</b> atau <b>NIS@amal.web.id</b></p>
            <p class="mb-0">Password default adalah <b>password1234</b></p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr class="bg-primary-subtle">
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Jenis Kelamin</th>
                            <th>Kelas</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->nama }}</td>
                                <td>{{ $student->nis }}</td>
                                <td>{{ $student->jk }}</td>
                                <td>{{ $student->kelas }}</td>
                                <td>
                                    <a href="{{ route('guru.student.edit', $student->id) }}"
                                        class="btn btn-sm btn-warning">edit</a>
                                    <form action="{{ route('guru.student.destroy', $student->id) }}" method="post"
                                        class="d-inline-block" onclick="return alert('apakah kamu yakin menghapus data?')">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
