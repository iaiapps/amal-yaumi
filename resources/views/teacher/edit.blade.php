@extends('layouts.app')
@section('title', 'Edit Guru')
@section('content')

<div class="card">
    <div class="card-header">
        <h5>Edit Guru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('teacher.update', $teacher) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $teacher->nama) }}" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $teacher->nip) }}">
                    @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jk" class="form-select @error('jk') is-invalid @enderror" required>
                        <option value="">Pilih</option>
                        <option value="L" {{ old('jk', $teacher->jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jk', $teacher->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telp" class="form-control @error('telp') is-invalid @enderror" value="{{ old('telp', $teacher->telp) }}">
                    @error('telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $teacher->user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Foto</label>
                    @if($teacher->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->nama }}" style="max-height: 100px;">
                    </div>
                    @endif
                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('teacher.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection
