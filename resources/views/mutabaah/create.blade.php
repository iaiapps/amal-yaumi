@extends('layouts.app')
@section('title', 'Tambah Mutabaah')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('mutabaah.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Mutabaah</label>
                    <input id="tanggal" type="date" class="form-control" name="tanggal" required>
                </div>
                <div class="mb-3">
                    <label for="nama_siswa" class="form-label">Nama siswa</label>
                    <select class="form-select" name="student_id" id="nama_siswa" required>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="puasa" class="form-label">Puasa</label>
                    <select class="form-select" name="puasa" id="puasa" required>
                        <option disabled>--- pilih ---</option>
                        <option value="iya">Iya</option>
                        <option value="tidak">Tidak</option>
                    </select>
                </div>
                <div class="border border-1 border-warning rounded mb-3 p-3">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Jenis Sholat</td>
                                    <td>Berjamaah</td>
                                    <td>Sendirian</td>
                                    <td>Tidak Sholat</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sholat Subuh</td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="1" name="subuh"
                                            id="subuh">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="2" name="subuh"
                                            id="subuh">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="3" name="subuh"
                                            id="subuh">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sholat Dhuhur</td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="1" name="dhuhur"
                                            id="dhuhur">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="2" name="dhuhur"
                                            id="dhuhur">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="3" name="dhuhur"
                                            id="dhuhur">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sholat Ashar</td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="1" name="ashar"
                                            id="ashar">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="2" name="ashar"
                                            id="ashar">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="3" name="ashar"
                                            id="ashar">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sholat Magrib</td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="1" name="magrib"
                                            id="magrib">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="2" name="magrib"
                                            id="magrib">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="3" name="magrib"
                                            id="magrib">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sholat Isya'</td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="1" name="isya"
                                            id="isya">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="2" name="isya"
                                            id="isya">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="3" name="isya"
                                            id="isya">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Solat Dhuha</td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="1" name="dhuha"
                                            id="dhuha">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="2" name="dhuha"
                                            id="dhuha">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="3" name="dhuha"
                                            id="dhuha">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sholat Tarawih</td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="1" name="tarawih"
                                            id="tarawih">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="2" name="tarawih"
                                            id="tarawih">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="3" name="tarawih"
                                            id="tarawih">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sholat Tahajud</td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="1" name="tahajud"
                                            id="tahajud">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="2" name="tahajud"
                                            id="tahajud">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" value="3" name="tahajud"
                                            id="tahajud">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="tilawah" class="form-label">Tilawah Qur'an</label>
                    <input id="tilawah" type="text" class="form-control" name="tilawah" required
                        placeholder="Tuliskan berapa halaman/lembar/juz">
                </div>
                <div class="mb-3">
                    <label for="infaq" class="form-label">Sedekah/Infaq</label>
                    <select class="form-select" name="infaq" id="infaq" required>
                        <option disabled>--- pilih ---</option>
                        <option value="iya">Iya</option>
                        <option value="tidak">Tidak</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="birrul" class="form-label">Birrul Walidain</label>
                    <input id="birrul" type="text" class="form-control" name="birrul" required
                        placeholder="Tuliskan jenis Birrul Walidainnya">
                </div>
                <button type="submit" class="btn btn-primary">simpan data</button>
            </form>
        </div>
    </div>
@endsection
