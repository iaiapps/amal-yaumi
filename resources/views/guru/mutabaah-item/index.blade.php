@extends('layouts.app')
@section('title', 'Kelola Item Mutabaah')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Kelola Item Mutabaah</h5>
        @if($role == 'guru')
        <a href="{{ route('mutabaah-item.create') }}" class="btn btn-primary btn-sm">
            <i class="ti ti-plus"></i> Tambah Item
        </a>
        @endif
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
                        @if($role == 'admin')
                        <th>Guru Pembimbing</th>
                        @endif
                        <th>Nama Item</th>
                        <th>Kategori</th>
                        <th>Tipe Input</th>
                        <th>Status</th>
                        @if($role == 'guru')
                        <th width="150">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $item->urutan }}</td>
                        @if($role == 'admin')
                        <td>{{ $item->teacher->nama ?? 'Sistem' }}</td>
                        @endif
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
                        <td>{{ ucfirst(str_replace('_', '/', $item->tipe)) }}</td>
                        <td>
                            @if($role == 'guru')
                            <form action="{{ route('mutabaah-item.toggle', $item) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-{{ $item->is_active ? 'success' : 'secondary' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                            @else
                            <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            @endif
                        </td>
                        @if($role == 'guru')
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
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $role == 'guru' ? 6 : 6 }}" class="text-center">Belum ada item mutabaah</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
