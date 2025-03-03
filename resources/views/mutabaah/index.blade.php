@extends('layouts.app')
@section('title', 'Data Mutabaah')
@section('content')
    @session('success')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession
    <div class="card">
        <div class="ms-4 mt-4">
            <a href="{{ route('mutabaah.create') }}" class="btn btn-primary">tambah mutabaah</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr class="bg-primary-subtle">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mutabaahs as $mutabaah)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mutabaah->student->nama }}</td>
                            <td>{{ $mutabaah->tanggal }}</td>
                            <td>
                                <a href="{{ route('mutabaah.edit', $mutabaah->id) }}"
                                    class="btn btn-sm btn-warning">edit</a>
                                <form action="{{ route('mutabaah.destroy', $mutabaah->id) }}" method="post"
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
