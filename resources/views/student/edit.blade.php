@extends('layouts.app')
@section('title', 'Edit Siswa')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('student.update', $student->id) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Siswa</label>
                    <input id="nama" type="text" class="form-control" name="nama" value="{{ $student->nama }}">
                </div>
                <div class="mb-3">
                    <label for="nis" class="form-label">NIS</label>
                    <input id="nis" type="text" class="form-control" name="nis" value="{{ $student->nis }}">
                </div>
                <div class="mb-3">
                    <label for="jk" class="form-label">Jenis Kelamin</label>
                    <input id="jk" type="text" class="form-control" name="jk" value="{{ $student->jk }}">
                </div>
                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <select id="kelas" class="form-select" name="kelas" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->nama }}" {{ $student->kelas == $k->nama ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">simpan data</button>
            </form>
        </div>
    </div>
@endsection
