@extends('layouts.app')
@section('title', 'Edit Mutabaah')
@section('content')

@php
    $user = Auth::user();
    $role = $user->getRoleNames()->first();
    $url = $role == 'siswa' ? route('siswa.amal.update', $mutabaah->id) : route('mutabaah.update', $mutabaah->id);
@endphp

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ $url }}" method="POST" id="mutabaahForm">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="form-label fw-bold small">Tanggal Mutabaah <span class="text-danger">*</span></label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $mutabaah->tanggal->format('Y-m-d')) }}" required>
            </div>

            @if($role == 'admin')
            <div class="mb-4">
                <label class="form-label fw-bold small">Nama Siswa <span class="text-danger">*</span></label>
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

            @php
                $colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
                $colorIndex = 0;
            @endphp

            @foreach($items->groupBy('kategori') as $kategori => $groupItems)
                @php
                    $currentColor = $colors[$colorIndex % count($colors)];
                    $colorIndex++;
                    $displayKategori = ucwords(str_replace(['_', '-'], ' ', $kategori));
                @endphp
                <div class="card mb-4 shadow-sm border-0 border-top border-4 border-{{ $currentColor }}">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-{{ $currentColor }}">
                            <i class="ti ti-bookmark me-1"></i> {{ $displayKategori }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($groupItems as $item)
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">{{ $item->nama }}</label>
                                    
                                    @if($item->tipe == 'ya_tidak')
                                        <div class="form-check form-check-lg habit-check">
                                            <input type="checkbox" class="form-check-input habit-checkbox"
                                                id="item_{{ $item->id }}" name="data[{{ $item->id }}]"
                                                value="Ya" {{ ($mutabaah->data[$item->id] ?? '') == 'Ya' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="item_{{ $item->id }}">
                                                Sudah Dikerjakan
                                            </label>
                                        </div>
                                    
                                    @elseif($item->tipe == 'angka')
                                        <input type="number" name="data[{{ $item->id }}]" class="form-control habit-input" 
                                            value="{{ $mutabaah->data[$item->id] ?? '' }}" placeholder="Masukkan angka">
                                    
                                    @else
                                        <input type="text" name="data[{{ $item->id }}]" class="form-control habit-input" 
                                            value="{{ $mutabaah->data[$item->id] ?? '' }}" placeholder="Masukkan text">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="card mt-4 border-0 shadow-sm bg-light">
                <div class="card-body p-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ $role == 'siswa' ? route('siswa.amal.index') : route('mutabaah.index') }}" class="btn btn-light px-4 py-2">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js')
<style>
    .habit-check {
        padding: 12px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s ease;
        background: #fff;
    }
    .habit-check:hover {
        border-color: #4680FF;
        background: #f8f9fa;
    }
    .habit-check .form-check-input {
        width: 20px;
        height: 20px;
        margin-top: 0;
        cursor: pointer;
    }
    .habit-check .form-check-input:checked {
        background-color: #2CA87F;
        border-color: #2CA87F;
    }
    .habit-check .form-check-label {
        cursor: pointer;
        margin-left: 8px;
        font-size: 0.9rem;
    }
</style>
@endpush

@endsection
