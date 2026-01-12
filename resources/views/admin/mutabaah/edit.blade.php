@extends('layouts.app')
@section('title', 'Edit Mutabaah')
@section('content')

@php
    $user = Auth::user();
    $role = $user->getRoleNames()->first();
    $url = $role == 'siswa' ? route('amal.update', $mutabaah->id) : route('mutabaah.update', $mutabaah->id);
@endphp

<div class="card">
    <div class="card-header">
        <h5>Edit Mutabaah</h5>
    </div>
    <div class="card-body">
        <form action="{{ $url }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $mutabaah->tanggal->format('Y-m-d')) }}" required>
            </div>

            @if($role == 'admin')
            <div class="mb-3">
                <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                <select name="student_id" class="form-select" required>
                    <option value="">Pilih Siswa</option>
                    @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ $mutabaah->student_id == $student->id ? 'selected' : '' }}>
                        {{ $student->nama }} - {{ $student->kelas }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif

            @foreach($items->groupBy('kategori') as $kategori => $groupItems)
            <div class="card mb-3">
                <div class="card-header">
                    <strong>
                        @if($kategori == 'sholat_wajib') Sholat Wajib
                        @elseif($kategori == 'sholat_sunnah') Sholat Sunnah
                        @else Lainnya
                        @endif
                    </strong>
                </div>
                <div class="card-body">
                    @foreach($groupItems as $item)
                    <div class="mb-3">
                        <label class="form-label">{{ $item->nama }}</label>
                        
                        @if($item->tipe == 'ya_tidak')
                        <select name="data[{{ $item->id }}]" class="form-select" required>
                            <option value="">Pilih</option>
                            <option value="Ya" {{ ($mutabaah->data[$item->id] ?? '') == 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ ($mutabaah->data[$item->id] ?? '') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        
                        @elseif($item->tipe == 'angka')
                        <input type="number" name="data[{{ $item->id }}]" class="form-control" value="{{ $mutabaah->data[$item->id] ?? '' }}" placeholder="Masukkan angka" required>
                        
                        @else
                        <input type="text" name="data[{{ $item->id }}]" class="form-control" value="{{ $mutabaah->data[$item->id] ?? '' }}" placeholder="Masukkan text" required>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ $role == 'siswa' ? route('amal.index') : route('mutabaah.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection
