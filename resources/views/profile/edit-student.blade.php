@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    @if ($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto Profil" class="rounded-circle mb-3"
                            width="150" height="150" style="object-fit: cover;">
                    @else
                        <div class="avtar avtar-xl bg-light-primary mb-3 mx-auto">
                            <i class="ti ti-user" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                    <h4>{{ $student->nama }}</h4>
                    <p class="text-muted mb-0">{{ $student->kelas }}</p>
                    <p class="text-muted">NIS: {{ $student->nis }}</p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Guru</h5>
                </div>
                <div class="card-body">
                    @if ($student->teacher)
                        <div class="d-flex align-items-center">
                            @if ($student->teacher->photo)
                                <img src="{{ asset('storage/' . $student->teacher->photo) }}" alt="Foto Guru"
                                    class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                            @else
                                <div class="avtar avtar-s bg-light-secondary me-3">
                                    <i class="ti ti-user"></i>
                                </div>
                            @endif
                            <div>
                                <strong>{{ $student->teacher->nama }}</strong>
                                <br>
                                <small class="text-muted">{{ $student->teacher->telp ?? '-' }}</small>
                            </div>
                        </div>
                    @else
                        <p class="text-muted mb-0">Belum ada guru pembimbing</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Profil</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="profile_photo"
                                class="form-control @error('profile_photo') is-invalid @enderror" accept="image/*">
                            @error('profile_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Max 2MB (JPG, PNG)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Nama ini akan digunakan di seluruh sistem.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" readonly>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" class="form-control bg-light" value="{{ $student->nis }}" disabled>
                            <small class="text-muted">NIS dikelola oleh Guru/Admin.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control bg-light" value="{{ $student->kelas }}" disabled>
                            <small class="text-muted">Kelas dikelola oleh Guru/Admin.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ $student->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}" disabled>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('profile.password') }}" class="btn btn-warning">
                                <i class="ti ti-lock"></i> Ganti Password
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
