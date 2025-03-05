@extends('layouts.app')
@section('title', 'Home')
@section('content')

    <div class="card">
        <div class="card-body">
            <p class="fs-3 mb-0">Selamat datang di Aplikasi Amal Yaumi</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <p class="fs-4 mb-0">Silahkan mengisi Mutabaah Amal Yaumi</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <a href="{{ route('amal.create') }}" class="btn btn-primary">Isi Amal Yaumi</a>
        </div>
    </div>

@endsection
