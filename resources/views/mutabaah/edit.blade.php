@extends('layouts.app')
@section('title', 'Edit Mutabaah')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('mutabaah.update', $mutabaah->id) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Mutabaah</label>
                    <input id="nama" type="text" class="form-control" name="nama" value="{{ $mutabaah->nama }}">
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Mutabaah</label>
                    <input id="jenis" type="text" class="form-control" name="jenis" value="{{ $mutabaah->jenis }}">
                </div>

                <button type="submit" class="btn btn-primary">simpan data</button>
            </form>
        </div>
    </div>
@endsection
