@extends('layouts.app')
@section('title', 'Edit Kelas')
@section('content')

<div class="card">
    <div class="card-header">
        <h5>Edit Kelas</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('classroom.update', $kela) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $kela->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tingkat <span class="text-danger">*</span></label>
                <select name="tingkat" class="form-select @error('tingkat') is-invalid @enderror" required>
                    <option value="">Pilih Tingkat</option>
                    <option value="X" {{ old('tingkat', $kela->tingkat) == 'X' ? 'selected' : '' }}>X</option>
                    <option value="XI" {{ old('tingkat', $kela->tingkat) == 'XI' ? 'selected' : '' }}>XI</option>
                    <option value="XII" {{ old('tingkat', $kela->tingkat) == 'XII' ? 'selected' : '' }}>XII</option>
                </select>
                @error('tingkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kapasitas <span class="text-danger">*</span></label>
                <input type="number" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" value="{{ old('kapasitas', $kela->kapasitas) }}" min="1" required>
                @error('kapasitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('classroom.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection
