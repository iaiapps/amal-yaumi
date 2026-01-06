@extends('layouts.app')
@section('title', 'Laporan')
@section('content')

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="card-title"><i class="ti ti-file-spreadsheet"></i> Export Data Siswa</h6>
                            <p class="card-text text-muted">Export semua data siswa ke format Excel</p>
                            <a href="{{ route('reports.students.export') }}" class="btn btn-success btn-sm">
                                <i class="ti ti-download"></i> Download Excel
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="card-title"><i class="ti ti-file-text"></i> Export Data Mutabaah</h6>
                            <p class="card-text text-muted">Export data mutabaah dengan filter tanggal</p>
                            <form action="{{ route('reports.mutabaah.export') }}" method="GET" class="d-inline">
                                <div class="row g-2 mb-2">
                                    <div class="col-md-6">
                                        <input type="date" name="start_date" class="form-control form-control-sm"
                                            value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" name="end_date" class="form-control form-control-sm"
                                            value="{{ now()->endOfMonth()->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="ti ti-download"></i> Download Excel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="card-title"><i class="ti ti-file-pdf"></i> Laporan PDF Semua Siswa</h6>
                            <p class="card-text text-muted">Generate laporan PDF untuk semua siswa</p>
                            <form action="{{ route('reports.all.pdf') }}" method="GET" class="d-inline">
                                <div class="row g-2 mb-2">
                                    <div class="col-md-3">
                                        <input type="date" name="start_date" class="form-control form-control-sm"
                                            value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" name="end_date" class="form-control form-control-sm"
                                            value="{{ now()->endOfMonth()->format('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="ti ti-file-pdf"></i> Download PDF
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="card">
        <div class="card-header">
            <h5>Laporan Per Siswa</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->nama }}</td>
                                <td>{{ $student->nis }}</td>
                                <td>{{ $student->kelas }}</td>
                                <td>
                                    <form action="{{ route('reports.student.pdf', $student->id) }}" method="GET"
                                        class="d-inline">
                                        <input type="date" name="start_date"
                                            class="form-control form-control-sm d-inline-block" style="width: 140px;"
                                            value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                                        <input type="date" name="end_date"
                                            class="form-control form-control-sm d-inline-block" style="width: 140px;"
                                            value="{{ now()->endOfMonth()->format('Y-m-d') }}">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="ti ti-file-pdf"></i> PDF
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

@endsection
