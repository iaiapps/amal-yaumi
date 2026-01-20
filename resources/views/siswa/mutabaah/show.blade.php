@extends('layouts.app')
@section('title', 'Detail Mutabaah')
@section('content')

    <div class="card">
        <div class="card-body">
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
            <div style="margin-left: 12px">
                @foreach ($items->groupBy('kategori') as $kategori => $groupItems)
                    @php
                        $displayKategori = ucwords(str_replace(['_', '-'], ' ', $kategori));
                    @endphp
                    <strong>
                        {{ $displayKategori }}
                    </strong>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 150px">Item</th>
                                    <th>Pelaksanaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupItems as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td>
                                            @php
                                                $value = $mutabaah->data[$item->id] ?? '-';
                                            @endphp
                                            @if ($value == 'Ya')
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
                @endforeach
            </div>

            <a href="{{ URL::previous() }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

@endsection
