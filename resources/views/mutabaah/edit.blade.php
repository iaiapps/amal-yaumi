@extends('layouts.app')
@section('title', 'Edit Mutabaah')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('mutabaah.update', $mutabaah->id) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Mutabaah</label>
                    <input id="tanggal" type="date" class="form-control" name="tanggal" value="{{ $mutabaah->tanggal }}"
                        required>
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
                        <option value="sholat berjamaah">Iya</option>
                        <option value="sholat berjamaah">Tidak</option>
                    </select>
                </div>
                <div class="border border-1 border-warning rounded mb-3 p-3">
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
                                        id="subuh" {{ $mutabaah->subuh == 1 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="2" name="subuh"
                                        id="subuh" {{ $mutabaah->subuh == 2 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="3" name="subuh"
                                        id="subuh" {{ $mutabaah->subuh == 3 ? 'checked' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Sholat Dhuhur</td>
                                <td>
                                    <input class="form-check-input" type="radio" value="1" name="dhuhur"
                                        id="dhuhur" {{ $mutabaah->duhur == 1 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="2" name="dhuhur"
                                        id="dhuhur" {{ $mutabaah->duhur == 2 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="3" name="dhuhur"
                                        id="dhuhur" {{ $mutabaah->duhur == 3 ? 'checked' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Sholat Ashar</td>
                                <td>
                                    <input class="form-check-input" type="radio" value="1" name="ashar"
                                        id="ashar" {{ $mutabaah->ashar == 1 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="2" name="ashar"
                                        id="ashar" {{ $mutabaah->ashar == 2 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="3" name="ashar"
                                        id="ashar" {{ $mutabaah->ashar == 3 ? 'checked' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Sholat Magrib</td>
                                <td>
                                    <input class="form-check-input" type="radio" value="1" name="magrib"
                                        id="magrib" {{ $mutabaah->magrib == 1 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="2" name="magrib"
                                        id="magrib" {{ $mutabaah->magrib == 2 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="3" name="magrib"
                                        id="magrib" {{ $mutabaah->magrib == 3 ? 'checked' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Sholat Isya'</td>
                                <td>
                                    <input class="form-check-input" type="radio" value="1" name="isya"
                                        id="isya" {{ $mutabaah->isya == 1 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="2" name="isya"
                                        id="isya" {{ $mutabaah->isya == 2 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="3" name="isya"
                                        id="isya" {{ $mutabaah->isya == 3 ? 'checked' : '' }}>
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
                                        id="dhuha" {{ $mutabaah->dhuha == 1 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="2" name="dhuha"
                                        id="dhuha" {{ $mutabaah->dhuha == 2 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="3" name="dhuha"
                                        id="dhuha" {{ $mutabaah->dhuha == 3 ? 'checked' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Sholat Tarawih</td>
                                <td>
                                    <input class="form-check-input" type="radio" value="1" name="tarawih"
                                        id="tarawih" {{ $mutabaah->tarawih == 1 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="2" name="tarawih"
                                        id="tarawih" {{ $mutabaah->tarawih == 2 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="3" name="tarawih"
                                        id="tarawih" {{ $mutabaah->tarawih == 3 ? 'checked' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Sholat Tahajud</td>
                                <td>
                                    <input class="form-check-input" type="radio" value="1" name="tahajud"
                                        id="tahajud" {{ $mutabaah->tahajud == 1 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="2" name="tahajud"
                                        id="tahajud" {{ $mutabaah->tahajud == 2 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input class="form-check-input" type="radio" value="3" name="tahajud"
                                        id="tahajud" {{ $mutabaah->tahajud == 3 ? 'checked' : '' }}>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mb-3">
                    <label for="tilawah" class="form-label">Tilawah Qur'an</label>
                    <input id="tilawah" type="text" class="form-control" name="tilawah" required
                        placeholder="Tuliskan berapa halaman/lembar/juz" value="{{ $mutabaah->tilawah }}">
                </div>
                <div class="mb-3">
                    <label for="infaq" class="form-label">Sedekah/Infaq</label>
                    <select class="form-select" name="infaq" id="infaq" required>
                        <option value="sholat berjamaah">Iya</option>
                        <option value="sholat berjamaah">Tidak</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="birrul" class="form-label">Birrul Walidain</label>
                    <input id="birrul" type="text" class="form-control" name="birrul" required
                        placeholder="Tuliskan jenis Birrul Walidainnya" value="{{ $mutabaah->birrul }}">
                </div>

                <button type="submit" class="btn btn-primary">simpan data</button>
            </form>
        </div>
    </div>
@endsection
