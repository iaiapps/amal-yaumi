@extends('layouts.app')
@section('title', 'Home')
@section('content')

    <div class="card">
        <div class="card-body">
            <p class="fs-3 mb-0">Selamat datang di Aplikasi Amal Yaumi</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card bg-primary-dark dashnum-card dashnum-card-small text-white overflow-hidden">
                <span class="round bg-primary small"></span>
                <span class="round bg-primary big"></span>
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-lg">
                            <i class="text-white ti ti-credit-card"></i>
                        </div>
                        <div class="ms-2">
                            <p class="fs-4 mb-0">Total Siswa</p>
                            <h4 class="text-white fs-2 mb-0">02</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-secondary-dark dashnum-card dashnum-card-small text-white overflow-hidden">
                <span class="round bg-secondary small"></span>
                <span class="round bg-secondary big"></span>
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-lg">
                            <i class="text-white ti ti-credit-card"></i>
                        </div>
                        <div class="ms-2">
                            <p class="fs-4 mb-0">Total Mutabaah</p>
                            <h4 class="text-white fs-2 mb-0">02</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
