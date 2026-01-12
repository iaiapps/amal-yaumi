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
            {{-- Admin View: Read Only --}}
        </div>
        <hr>
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

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection