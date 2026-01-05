@extends('layouts.app')
@section('title', 'Kelola Item Mutabaah')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Kelola Item Mutabaah</h5>
        <a href="{{ route('mutabaah-item.create') }}" class="btn btn-primary btn-sm">
            <i class="ti ti-plus"></i> Tambah Item
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">Urutan</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Tipe Input</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $item->urutan }}</td>
                        <td><strong>{{ $item->nama }}</strong></td>
                        <td>
                            @if($item->kategori == 'sholat_wajib')
                            <span class="badge bg-primary">Sholat Wajib</span>
                            @elseif($item->kategori == 'sholat_sunnah')
                            <span class="badge bg-success">Sholat Sunnah</span>
                            @else
                            <span class="badge bg-info">Lainnya</span>
                            @endif
                        </td>
                        <td>
                            @if($item->tipe == 'ya_tidak')
                            Ya/Tidak
                            @elseif($item->tipe == 'angka')
                            Angka
                            @else
                            Text
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('mutabaah-item.toggle', $item) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-{{ $item->is_active ? 'success' : 'secondary' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('mutabaah-item.edit', $item) }}" class="btn btn-sm btn-warning">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form action="{{ route('mutabaah-item.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada item mutabaah</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
