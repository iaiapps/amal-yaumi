@extends('layouts.app')
@section('title', 'Master User & Guru')
@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-circle-check me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary">Daftar Pengguna Sistem</h5>
            <span class="badge bg-light-primary text-primary">{{ $users->count() }} Total User</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="80" class="ps-4">No</th>
                        <th>Informasi Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="150" class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3 bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="ti ti-user fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <small class="text-muted">ID: #{{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary small">
                                    <i class="ti ti-mail me-1"></i> {{ $user->email }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $roleName = $user->getRoleNames()->first();
                                    $badgeColor = match($roleName) {
                                        'admin' => 'danger',
                                        'guru' => 'primary',
                                        'siswa' => 'success',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-light-{{ $badgeColor }} text-{{ $badgeColor }} rounded-pill px-3">
                                    {{ ucfirst($roleName) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('admin.user.reset', $user->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3" onclick="return confirm('Reset password user ini?')">
                                    <i class="ti ti-lock-open me-1"></i> Reset
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3 border-0">
        <small class="text-muted italic"><i class="ti ti-info-circle me-1"></i> Password setelah reset adalah <strong>password1234</strong></small>
    </div>
</div>

@endsection
