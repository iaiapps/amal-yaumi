@extends('layouts.app')
@section('title', 'Atur Urutan Item Mutabaah')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Atur Urutan Item Mutabaah</h5>
        <a href="{{ route('guru.mutabaah-item.index') }}" class="btn btn-secondary btn-sm">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="ti ti-info-circle me-1"></i> Masukkan nomor urutan untuk mengatur tampilan item di halaman santri. Item dengan nomor lebih kecil akan muncul lebih atas.
        </div>

        <form action="{{ route('guru.mutabaah-item.reorder.update') }}" method="POST">
            @csrf
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="100">Urutan</th>
                            <th>Kategori</th>
                            <th>Nama Item</th>
                            <th>Tipe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $currentCategory = ''; @endphp
                        @foreach($items as $item)
                            @if($currentCategory != $item->kategori)
                                <tr class="table-light">
                                    <td colspan="4" class="fw-bold text-primary">
                                        <i class="ti ti-folder me-1"></i> {{ ucwords(str_replace(['_', '-'], ' ', $item->kategori)) }}
                                    </td>
                                </tr>
                                @php $currentCategory = $item->kategori; @endphp
                            @endif
                            <tr>
                                <td>
                                    <input type="number" name="order[{{ $item->id }}]" class="form-control form-control-sm" value="{{ $item->urutan }}" min="1" required>
                                </td>
                                <td class="text-muted small">{{ $item->kategori }}</td>
                                <td><strong>{{ $item->nama }}</strong></td>
                                <td><span class="badge bg-light-info text-info">{{ ucfirst($item->tipe) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 border-top pt-3 text-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="ti ti-device-floppy me-1"></i> Simpan Semua Urutan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
