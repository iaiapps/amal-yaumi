@extends('layouts.app')
@section('title', 'Template Mutabaah Sistem')
@section('content')

<div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
    <div class="card-header bg-primary py-4 text-white">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 text-white fw-bold">Template Standar Mutabaah</h4>
                <p class="mb-0 opacity-75">Gunakan item standar yang sudah disiapkan sistem untuk mempercepat proses setup kelas Anda.</p>
            </div>
            <a href="{{ route('guru.mutabaah-item.index') }}" class="btn btn-light btn-sm rounded-pill px-3">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    
    <div class="card-body p-4">
        @if($templates->isEmpty())
            <div class="text-center py-5">
                <img src="https://img.freepik.com/free-vector/empty-concept-illustration_114360-1253.jpg" alt="No templates" style="width: 250px;">
                <h5 class="mt-4">Belum Ada Template</h5>
                <p class="text-muted">Admin belum menyiapkan template standar untuk sistem ini.</p>
            </div>
        @else
            <div class="alert alert-light-info border-0 p-3 mb-4 d-flex align-items-center" style="border-radius: 10px;">
                <i class="ti ti-info-circle fs-2 me-3 text-info"></i>
                <div class="small">
                    Klik tombol <strong>"Salin Semua"</strong> di bawah untuk memasukkan semua item ini ke daftar mutabaah Anda. 
                    Anda tetap bisa mengubah atau menghapus item setelah disalin.
                </div>
            </div>

            @php $currentCategory = ''; @endphp
            <div class="row g-4">
                @foreach($templates->groupBy('kategori') as $kategori => $group)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border border-light-subtle shadow-none" style="border-radius: 12px; transition: 0.3s;">
                        <div class="card-header bg-light border-0 py-3 d-flex justify-content-between align-items-center">
                            @php
                                $badgeColor = match($kategori) {
                                    'sholat_fardhu' => 'primary',
                                    'sholat_sunnah' => 'success',
                                    'interaksi_al_quran' => 'info',
                                    'dzikir_spiritual' => 'warning',
                                    'adab_karakter' => 'danger',
                                    'kemandirian_sosial' => 'dark',
                                    default => 'secondary'
                                };
                            @endphp
                            <h6 class="mb-0 fw-bold text-{{ $badgeColor }}">
                                <i class="ti ti-folder me-1"></i> {{ ucwords(str_replace(['_', '-'], ' ', $kategori)) }}
                            </h6>
                            <span class="badge bg-{{ $badgeColor }} rounded-pill">{{ $group->count() }} item</span>
                        </div>
                        <div class="card-body py-2">
                            <ul class="list-group list-group-flush">
                                @foreach($group as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-circle-check text-success me-2"></i>
                                        <span class="small font-weight-medium">{{ $item->nama }}</span>
                                    </div>
                                    <span class="badge bg-light-secondary text-secondary small" style="font-size: 0.7rem;">{{ ucfirst($item->tipe) }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5 mb-3">
                <form action="{{ route('guru.mutabaah-item.copy-template') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow rounded-pill" onclick="return confirm('Salin semua template ini ke akun Anda?')">
                        <i class="ti ti-copy me-2"></i> Salin Semua ke Akun Saya
                    </button>
                    <p class="text-muted small mt-3 italic">*Peringatan: Jika Anda sudah memiliki item dengan nama yang sama, data akan tetap disalin sebagai item baru.</p>
                </form>
            </div>
        @endif
    </div>
</div>

@endsection

@push('css')
<style>
    .list-group-item { background: transparent; }
    /* .card:hover { border-color: var(--bs-primary) !important; transform: translateY(-5px); } */
</style>
@endpush
