@extends('layouts.app')
@section('title', 'Edit Item Mutabaah')
@section('content')

<div class="card">
    <div class="card-header">
        <h5>Edit Item Mutabaah</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('mutabaah-item.update', $mutabaahItem) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Item <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $mutabaahItem->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                    <option value="">Pilih Kategori</option>
                    <option value="sholat_wajib" {{ old('kategori', $mutabaahItem->kategori) == 'sholat_wajib' ? 'selected' : '' }}>Sholat Wajib</option>
                    <option value="sholat_sunnah" {{ old('kategori', $mutabaahItem->kategori) == 'sholat_sunnah' ? 'selected' : '' }}>Sholat Sunnah</option>
                    <option value="lainnya" {{ old('kategori', $mutabaahItem->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tipe Input <span class="text-danger">*</span></label>
                <select name="tipe" class="form-select @error('tipe') is-invalid @enderror" required>
                    <option value="">Pilih Tipe</option>
                    <option value="ya_tidak" {{ old('tipe', $mutabaahItem->tipe) == 'ya_tidak' ? 'selected' : '' }}>Ya/Tidak</option>
                    <option value="angka" {{ old('tipe', $mutabaahItem->tipe) == 'angka' ? 'selected' : '' }}>Angka</option>
                    <option value="text" {{ old('tipe', $mutabaahItem->tipe) == 'text' ? 'selected' : '' }}>Text</option>
                </select>
                @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Urutan <span class="text-danger">*</span></label>
                <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', $mutabaahItem->urutan) }}" required>
                @error('urutan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $mutabaahItem->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('mutabaah-item.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection
