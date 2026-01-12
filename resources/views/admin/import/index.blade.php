@extends('layouts.app')
@section('title', 'Import Data')
@section('content')

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="ti ti-info-circle"></i>
                        <strong>Panduan Import:</strong>
                        <ol class="mb-0 mt-2">
                            <li>Download template Excel terlebih dahulu</li>
                            <li>Isi data siswa sesuai format</li>
                            <li>Kolom: nama, nis, jk (L/P), kelas</li>
                            <li>Upload file Excel (xlsx, xls, csv)</li>
                            <li>Maksimal ukuran file: 2MB</li>
                        </ol>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('import.template') }}" class="btn btn-success btn-sm">
                            <i class="ti ti-download"></i> Download Template
                        </a>
                    </div>
                    <hr>
                    <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pilih File Excel</label>
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
                                accept=".xlsx,.xls,.csv" required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: xlsx, xls, csv (Max: 2MB)</small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-upload"></i> Upload & Import
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5>Format Template</h5>
                    <p class="text-muted">Contoh format data yang benar:</p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>nama</th>
                                    <th>nis</th>
                                    <th>jk</th>
                                    <th>kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ahmad Fauzi</td>
                                    <td>20240001</td>
                                    <td>L</td>
                                    <td>5A</td>
                                </tr>
                                <tr>
                                    <td>Siti Nurhaliza</td>
                                    <td>20240002</td>
                                    <td>P</td>
                                    <td>5A</td>
                                </tr>
                                <tr>
                                    <td>Muhammad Rizki</td>
                                    <td>20240003</td>
                                    <td>L</td>
                                    <td>5B</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-warning mt-3">
                        <strong>Catatan:</strong>
                        <ul class="mb-0">
                            <li>Jenis Kelamin: L (Laki-laki) atau P (Perempuan)</li>
                            <li>NIS harus unik (tidak boleh duplikat)</li>
                            <li>Semua kolom wajib diisi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Riwayat Import</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>File</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Berhasil</th>
                            <th>Gagal</th>
                            <th>Status</th>
                            <th>Error</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($imports as $import)
                            <tr>
                                <td>{{ $import->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $import->file_name }}</td>
                                <td>{{ $import->user->name }}</td>
                                <td><span class="badge bg-secondary">{{ $import->total_rows }}</span></td>
                                <td><span class="badge bg-success">{{ $import->success_rows }}</span></td>
                                <td><span class="badge bg-danger">{{ $import->failed_rows }}</span></td>
                                <td>
                                    @if ($import->failed_rows == 0)
                                        <span class="badge bg-success">Sukses</span>
                                    @else
                                        <span class="badge bg-warning">Partial</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($import->errors && $import->errors != '[]')
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#errorModal{{ $import->id }}">
                                            <i class="ti ti-alert-circle"></i> Lihat
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="errorModal{{ $import->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Error Details</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="list-unstyled">
                                                            @foreach (json_decode($import->errors) as $error)
                                                                <li class="text-danger"><i class="ti ti-x"></i>
                                                                    {{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada riwayat import</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
