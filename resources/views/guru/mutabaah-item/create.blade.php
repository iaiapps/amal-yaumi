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
                <input list="categoryList" name="kategori" id="kategoriInput" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}" placeholder="Pilih atau ketik kategori baru" required>
                <datalist id="categoryList">
                    @foreach($existingCategories as $cat)
                        <option value="{{ $cat }}">{{ ucwords(str_replace(['_', '-'], ' ', $cat)) }}</option>
                    @endforeach
                </datalist>
                
                @if($existingCategories->count() > 0)
                    <div class="mt-2">
                        <small class="text-muted d-block mb-1">Kategori Tersedia (Klik untuk memilih):</small>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($existingCategories as $cat)
                                <span class="badge bg-light-primary text-primary border border-primary border-opacity-10 cursor-pointer category-suggestion" 
                                      style="cursor: pointer;"
                                      onclick="document.getElementById('kategoriInput').value = '{{ $cat }}'">
                                    {{ ucwords(str_replace(['_', '-'], ' ', $cat)) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @else
                    <small class="text-muted">Pilih atau buat kategori baru.</small>
                @endif
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
