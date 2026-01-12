@extends('layouts.app')
@section('title', 'Tambah Item Mutabaah')
@section('content')

<div class="card">
    <div class="card-header">
        <h5>Tambah Item Mutabaah</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('guru.mutabaah-item.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Item <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                    <option value="">Pilih Kategori</option>
                    <option value="sholat_wajib" {{ old('kategori') == 'sholat_wajib' ? 'selected' : '' }}>Sholat Wajib</option>
                    <option value="sholat_sunnah" {{ old('kategori') == 'sholat_sunnah' ? 'selected' : '' }}>Sholat Sunnah</option>
                    <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tipe Input <span class="text-danger">*</span></label>
                <select name="tipe" class="form-select @error('tipe') is-invalid @enderror" required>
                    <option value="">Pilih Tipe</option>
                    <option value="ya_tidak" {{ old('tipe') == 'ya_tidak' ? 'selected' : '' }}>Ya/Tidak</option>
                    <option value="angka" {{ old('tipe') == 'angka' ? 'selected' : '' }}>Angka</option>
                    <option value="text" {{ old('tipe') == 'text' ? 'selected' : '' }}>Text</option>
                </select>
                @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Urutan <span class="text-danger">*</span></label>
                <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', 1) }}" required>
                @error('urutan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('guru.mutabaah-item.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection
