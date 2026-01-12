@extends('layouts.app')
@section('title', 'Pengaturan Sistem')
@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Pengaturan Aplikasi & Batasan</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Aplikasi/Sekolah</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $school->nama) }}" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $school->email) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telp" class="form-control" value="{{ old('telp', $school->telp) }}">
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-primary mb-3">Konfigurasi Batasan (Saas Ready)</h6>
                    
                    <div class="mb-3">
                        <label class="form-label">Maksimal Kelas Per Guru</label>
                        <div class="input-group">
                            <input type="number" name="max_class_per_teacher" class="form-control" value="{{ old('max_class_per_teacher', $school->max_class_per_teacher) }}" required min="1">
                            <span class="input-group-text">Kelas</span>
                        </div>
                        <small class="text-muted">Membatasi jumlah kelas yang bisa dibuat secara mandiri oleh tiap Guru.</small>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Logo Aplikasi</h5>
            </div>
            <div class="card-body text-center">
                @if($school->logo)
                    <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" class="img-fluid mb-3" style="max-height: 150px;">
                @else
                    <div class="p-5 bg-light mb-3">No Logo</div>
                @endif
                <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nama" value="{{ $school->nama }}">
                    <input type="hidden" name="max_class_per_teacher" value="{{ $school->max_class_per_teacher }}">
                    <input type="file" name="logo" class="form-control mb-2" accept="image/*">
                    <button type="submit" class="btn btn-sm btn-outline-primary">Update Logo</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
