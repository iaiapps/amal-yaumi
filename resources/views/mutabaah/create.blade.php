@extends('layouts.app')
@section('title', 'Tambah Mutabaah')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('mutabaah.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Mutabaah</label>
                    <input id="nama" type="text" class="form-control" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Mutabaah</label>
                    <input id="jenis" type="text" class="form-control" name="jenis" required>
                </div>
                <button type="submit" class="btn btn-primary">simpan data</button>
            </form>
        </div>
    </div>
@endsection
