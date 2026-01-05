@extends('layouts.app')
@section('title', 'Tambah Kelas')
@section('content')

<div class="card">
    <div class="card-header">
        <h5>Tambah Kelas</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('classroom.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Contoh: X-A" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tingkat <span class="text-danger">*</span></label>
                <select name="tingkat" class="form-select @error('tingkat') is-invalid @enderror" required>
                    <option value="">Pilih Tingkat</option>
                    <option value="X" {{ old('tingkat') == 'X' ? 'selected' : '' }}>X</option>
                    <option value="XI" {{ old('tingkat') == 'XI' ? 'selected' : '' }}>XI</option>
                    <option value="XII" {{ old('tingkat') == 'XII' ? 'selected' : '' }}>XII</option>
                </select>
                @error('tingkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kapasitas <span class="text-danger">*</span></label>
                <input type="number" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" value="{{ old('kapasitas', 30) }}" min="1" required>
                @error('kapasitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('classroom.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection
