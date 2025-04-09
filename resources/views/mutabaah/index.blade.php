@extends('layouts.app')
@section('title', 'Data Mutabaah')
@section('content')
    @session('success')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession
    <div class="card">
        <div class="ms-4 mt-4">
            <a href="{{ route('mutabaah.create') }}" class="btn btn-primary">tambah mutabaah</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @php
                    $period = \Carbon\CarbonPeriod::between(now()->startOfMonth(), now()->endOfMonth());

                @endphp
                <p class="fs-4">Mutabaah Bulan {{ \Carbon\Carbon::now()->isoFormat('MMMM YYYY') }}</p>

                <table class="table table-bordered table-sm">
                    <thead>
                        <tr class="bg-primary-subtle">
                            <th rowspan="2">No</th>
                            <th rowspan="2">Nama siswa</th>
                            <th colspan="31" class="text-center">Pengisian</th>
                            {{-- <th rowspan="2">Action</th> --}}
                        </tr>
                        <tr>
                            @for ($i = 1; $i <= 31; $i++)
                                <th>{{ $i }}</th>
                            @endfor
                        </tr>

                    </thead>

                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->nama }}</td>

                                @foreach ($period as $date)
                                    @php
                                        $mutabaah = $student->mutabaah
                                            ->where('tanggal', $date->isoFormat('YYYY-MM-DD'))
                                            ->first();
                                    @endphp
                                    <td>
                                        @if ($mutabaah == null)
                                            -
                                        @else
                                            {{ \Carbon\Carbon::parse($mutabaah->tanggal)->isoFormat('DD/MM/YYYY') }}
                                            <span>
                                                <div class="btn-group">
                                                    <a href="{{ route('mutabaah.show', $mutabaah->id) }}"
                                                        class="btn btn-sm btn-primary"><i class="ti ti-info-circle"></i></a>
                                                    <a href="{{ route('mutabaah.edit', $mutabaah->id) }}"
                                                        class="btn btn-sm btn-warning"> <i class="ti ti-edit"></i></a>
                                                    <form action="{{ route('mutabaah.destroy', $mutabaah->id) }}"
                                                        method="post" class="d-inline-block"
                                                        onclick="return alert('apakah kamu yakin menghapus data?')">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                                class="ti ti-trash"></i> </button>
                                                    </form>
                                                </div>
                                            </span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection
