@extends('layouts.app')
@section('title', 'Pengaturan Sistem')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="ti ti-settings me-1"></i> Konfigurasi Batasan Platform</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.setting.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Maksimal Kelas Per Guru</label>
                                <div class="input-group">
                                    <input type="number" name="max_class_per_teacher" class="form-control border-0 bg-light"
                                        value="{{ old('max_class_per_teacher', $setting->max_class_per_teacher) }}" required
                                        min="1">
                                    <span class="input-group-text border-0 bg-light">Kelas</span>
                                </div>
                                <div class="form-text text-muted mt-2">
                                    <i class="ti ti-info-circle me-1"></i> Batas jumlah kelas yang bisa dibuat secara mandiri oleh setiap guru.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Maksimal Siswa Per Kelas</label>
                                <div class="input-group">
                                    <input type="number" name="max_students_per_class" class="form-control border-0 bg-light"
                                        value="{{ old('max_students_per_class', $setting->max_students_per_class ?? 30) }}"
                                        required min="1">
                                    <span class="input-group-text border-0 bg-light">Siswa</span>
                                </div>
                                <div class="form-text text-muted mt-2">
                                    <i class="ti ti-info-circle me-1"></i> Batas maksimal jumlah siswa dalam setiap satu rombel (Kelas).
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-end">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection