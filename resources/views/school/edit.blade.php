@extends('layouts.app')
@section('title', 'Profil Sekolah')
@section('content')

<div class="card">
    <div class="card-header">
        <h5>Profil Sekolah</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('school.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $school->nama) }}" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $school->email) }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $school->alamat) }}</textarea>
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telp" class="form-control @error('telp') is-invalid @enderror" value="{{ old('telp', $school->telp) }}">
                    @error('telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Website</label>
                    <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $school->website) }}">
                    @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kepala Sekolah</label>
                    <input type="text" name="kepala_sekolah" class="form-control @error('kepala_sekolah') is-invalid @enderror" value="{{ old('kepala_sekolah', $school->kepala_sekolah) }}">
                    @error('kepala_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">NIP Kepala Sekolah</label>
                    <input type="text" name="nip_kepala" class="form-control @error('nip_kepala') is-invalid @enderror" value="{{ old('nip_kepala', $school->nip_kepala) }}">
                    @error('nip_kepala')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Logo Sekolah</label>
                    @if($school->logo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" style="max-height: 100px;">
                    </div>
                    @endif
                    <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                    @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

@endsection
