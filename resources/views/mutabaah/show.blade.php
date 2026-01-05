@extends('layouts.app')
@section('title', 'Detail Mutabaah')
@section('content')

<div class="card">
    <div class="card-header">
        <h5>Detail Mutabaah</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">Tanggal</th>
                        <td>: {{ $mutabaah->tanggal->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Nama Siswa</th>
                        <td>: {{ $mutabaah->student->nama }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>: {{ $mutabaah->student->kelas }}</td>
                    </tr>
                </table>
            </div>
        </div>

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
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupItems as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    @php
                                        $value = $mutabaah->data[$item->id] ?? '-';
                                    @endphp
                                    @if($value == 'Ya')
                                    <span class="badge bg-success">{{ $value }}</span>
                                    @elseif($value == 'Tidak')
                                    <span class="badge bg-secondary">{{ $value }}</span>
                                    @else
                                    {{ $value }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach

        <a href="{{ Auth::user()->getRoleNames()->first() == 'siswa' ? route('amal.index') : route('mutabaah.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

@endsection
