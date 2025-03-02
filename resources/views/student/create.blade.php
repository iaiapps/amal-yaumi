@extends('layouts.app')
@section('title', 'Tambah Siswa')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('student.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Siswa</label>
                    <input id="nama" type="text" class="form-control" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="nis" class="form-label">NIS</label>
                    <input id="nis" type="text" class="form-control" name="nis" required>
                </div>
                <div class="mb-3">
                    <label for="jk" class="form-label">Jenis Kelamin</label>
                    <input id="jk" type="text" class="form-control" name="jk" required>
                </div>
                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input id="kelas" type="text" class="form-control" name="kelas" required>
                </div>

                <button type="submit" class="btn btn-primary">simpan data</button>
            </form>
        </div>
    </div>
@endsection
