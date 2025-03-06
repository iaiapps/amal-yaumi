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
                            <th>No</th>
                            <th class="text-center">Tanggal Pengisian</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($period as $date)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if ($mutabaahs->where('tanggal', $date->isoFormat('YYYY-MM-DD'))->first() == null)
                                    <td>
                                        -
                                    </td>
                                    <td></td>
                                @else
                                    @foreach ($mutabaahs->where('tanggal', $date->isoFormat('YYYY-MM-DD')) as $mutabaah)
                                        <td>
                                            {{ \Carbon\Carbon::parse($mutabaah->tanggal)->isoFormat('DD MMMM YYYY') }}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('amal.show', $mutabaah->id) }}"
                                                    class="btn btn-sm btn-primary"><i class="ti ti-info-circle"></i></a>
                                                <a href="{{ route('amal.edit', $mutabaah->id) }}"
                                                    class="btn btn-sm btn-warning"> <i class="ti ti-edit"></i></a>
                                                <form action="{{ route('amal.destroy', $mutabaah->id) }}" method="post"
                                                    class="d-inline-block"
                                                    onclick="return alert('apakah kamu yakin menghapus data?')">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i
                                                            class="ti ti-trash"></i> </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endforeach
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
