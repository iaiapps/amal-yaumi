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
            <a href="{{ route('student.create') }}" class="btn btn-primary">tambah siswa</a>
        </div>
        <div class="card-body">
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
                                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-sm btn-warning">edit</a>
                                <form action="{{ route('student.destroy', $student->id) }}" method="post"
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
@endsection
