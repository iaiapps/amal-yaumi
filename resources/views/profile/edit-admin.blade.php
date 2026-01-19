@extends('layouts.app')
@section('title', 'Profile Admin')
@section('content')

    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h6 class="mb-3">Informasi Akun Admin</h6>
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
