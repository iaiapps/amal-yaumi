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
            <a href="{{ route('amal.create') }}" class="btn btn-primary">tambah mutabaah</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @php
                    $period = \Carbon\CarbonPeriod::create('2025-03-01', '2025-03-31');

                @endphp
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr class="bg-primary-subtle">
                            <th rowspan="2">No</th>


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
                        @foreach ($period as $date)
                            {{-- <td>{{ $loop->iteration }}</td> --}}
                            @php
                                $mutabaah = $student->mutabaah
                                    ->where('tanggal', $date->isoFormat('YYYY-MM-DD'))
                                    ->first();
                            @endphp
                            @foreach ($mutabaahs as $mutabaah)
                                <tr>
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
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection
