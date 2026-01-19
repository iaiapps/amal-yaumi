@extends('layouts.app')
@section('title', 'Profile Guru')
@section('content')

    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h6 class="mb-3">Informasi Akun</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Foto Profile</label>
                        @if ($user->profile_photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile"
                                    style="max-height: 100px;" class="rounded">
                            </div>
                        @endif
                        <input type="file" name="profile_photo"
                            class="form-control @error('profile_photo') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                        @error('profile_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <hr class="my-4">

                <h6 class="mb-3">Detail Profil Guru</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                            value="{{ old('nip', $teacher->nip ?? '') }}">
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jk" class="form-select @error('jk') is-invalid @enderror">
                            <option value="">Pilih</option>
                            <option value="L" {{ old('jk', $teacher->jk ?? '') == 'L' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="P" {{ old('jk', $teacher->jk ?? '') == 'P' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                        @error('jk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telp" class="form-control @error('telp') is-invalid @enderror"
                            value="{{ old('telp', $teacher->telp ?? '') }}">
                        @error('telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto Guru/Identitas</label>
                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror"
                            accept="image/*">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex align-items-center mb-3">
                    <h6 class="mb-0">Identitas Sekolah</h6>
                    <span class="badge bg-light-info text-info ms-2">Multi-Tenant</span>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Sekolah</label>
                        <input type="text" name="nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror"
                            value="{{ old('nama_sekolah', $teacher->nama_sekolah ?? '') }}" placeholder="Contoh: SD IT Amal Mulia">
                        @error('nama_sekolah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Logo Sekolah</label>
                        @if ($teacher && $teacher->logo_sekolah)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $teacher->logo_sekolah) }}" alt="Logo Sekolah"
                                    style="max-height: 60px;" class="rounded border p-1">
                            </div>
                        @endif
                        <input type="file" name="logo_sekolah" class="form-control @error('logo_sekolah') is-invalid @enderror"
                            accept="image/*">
                        <small class="text-muted">Logo akan muncul di dashboard siswa & laporan PDF.</small>
                        @error('logo_sekolah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat Sekolah</label>
                        <textarea name="alamat_sekolah" class="form-control @error('alamat_sekolah') is-invalid @enderror" rows="2">{{ old('alamat_sekolah', $teacher->alamat_sekolah ?? '') }}</textarea>
                        @error('alamat_sekolah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('profile.password') }}" class="btn btn-warning">
                        <i class="ti ti-lock"></i> Ganti Password
                    </a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

@endsection
