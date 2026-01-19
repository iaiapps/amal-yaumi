@extends('layouts.app')
@section('title', 'Kelola Item Mutabaah')
@section('content')

@if($role == 'guru' && $items->isEmpty() && $hasTemplates)
<div class="alert alert-primary d-flex align-items-center p-4 mb-4 border-0 shadow-sm" style="border-radius: 15px;">
    <div class="me-3 fs-1">🚀</div>
    <div>
        <h5 class="alert-heading fw-bold mb-1">Mulai Lebih Cepat!</h5>
        <p class="mb-2">Anda belum memiliki item mutabaah. Gunakan template standar dari sistem untuk langsung mulai tanpa perlu repot input satu per satu.</p>
        <a href="{{ route('guru.mutabaah-item.templates') }}" class="btn btn-primary shadow-sm">
            <i class="ti ti-copy me-1"></i> Lihat & Gunakan Template Sistem
        </a>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Kelola Item Mutabaah</h5>
            @if($role == 'admin')
            <small class="text-muted">Manajemen Master Template & Item Guru</small>
            @endif
        </div>
        <div class="d-flex gap-2">
            @if($role == 'guru')
                <a href="{{ route('guru.mutabaah-item.templates') }}" class="btn btn-outline-primary btn-sm">
                    <i class="ti ti-layout-grid"></i> Template Sistem
                </a>
                <a href="{{ route('guru.mutabaah-item.reorder') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ti ti-sort-ascending"></i> Urutan
                </a>
                <a href="{{ route('guru.mutabaah-item.create') }}" class="btn btn-primary btn-sm">
                    <i class="ti ti-plus"></i> Tambah Item
                </a>
            @else
                <a href="{{ route('guru.mutabaah-item.create') }}" class="btn btn-primary btn-sm">
                    <i class="ti ti-plus"></i> Tambah Master Template
                </a>
            @endif
        </div>
    </div>
    
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($role == 'admin')
            <h6 class="fw-bold text-primary mb-3">🛠️ Master Template Sistem (Global)</h6>
            @include('guru.mutabaah-item.partials.table', ['items' => $templates, 'showGuru' => false])

            <h6 class="fw-bold text-warning mt-5 mb-3">👨‍🏫 Item Spesifik Guru</h6>
            @include('guru.mutabaah-item.partials.table', ['items' => $items, 'showGuru' => true])
        @else
            @include('guru.mutabaah-item.partials.table', ['items' => $items, 'showGuru' => false])
        @endif
    </div>
</div>

@endsection
