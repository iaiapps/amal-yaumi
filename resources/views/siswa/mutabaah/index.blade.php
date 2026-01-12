@extends('layouts.app')
@section('title', 'Mutabaah Saya')
@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="{{ route('siswa.amal.create') }}" class="btn btn-primary btn-sm">
                <i class="ti ti-plus"></i> Isi Mutabaah
            </a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Total Item</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mutabaahs as $mutabaah)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mutabaah->tanggal->format('d M Y') }}</td>
                                <td><span class="badge bg-primary">{{ count($mutabaah->data) }} item</span></td>
                                <td>
                                    <a href="{{ route('amal.show', $mutabaah) }}" class="btn btn-sm btn-info">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="{{ route('amal.edit', $mutabaah) }}" class="btn btn-sm btn-warning">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <form action="{{ route('amal.destroy', $mutabaah) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus data ini?')">
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
                                <td colspan="4" class="text-center">Belum ada data mutabaah</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection