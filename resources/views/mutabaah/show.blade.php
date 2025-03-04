@extends('layouts.app')
@section('title', 'Detail Mutabaah')
@section('content')
    <div class="card">
        <div class="card-body">
            <p>Tanggal {{ \Carbon\Carbon::parse($mutabaah->tanggal)->isoFormat('DD-MMMM-YYYY') }}</p>
            <table class="table tablestriped table-bordered">
                <thead>
                    <tr>
                        <th>Kegiatan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Puasa</td>
                        <td>{{ $mutabaah->puasa }}</td>
                    </tr>
                    <tr>
                        <td>Solat Subuh</td>
                        <td>
                            @if ($mutabaah->subuh == 1)
                                Berjamaah
                            @elseif($mutabaah->subuh == 2)
                                Sendirian
                            @elseif($mutabaah->subuh == 3)
                                Tidak Sholat
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Solat Dhuhur</td>
                        <td>
                            @if ($mutabaah->dhuhur == 1)
                                Berjamaah
                            @elseif($mutabaah->dhuhur == 2)
                                Sendirian
                            @elseif($mutabaah->dhuhur == 3)
                                Tidak Sholat
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Solat Ashar</td>
                        <td>
                            @if ($mutabaah->ashar == 1)
                                Berjamaah
                            @elseif($mutabaah->ashar == 2)
                                Sendirian
                            @elseif($mutabaah->ashar == 3)
                                Tidak Sholat
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Solat Magrib</td>
                        <td>
                            @if ($mutabaah->magrib == 1)
                                Berjamaah
                            @elseif($mutabaah->magrib == 2)
                                Sendirian
                            @elseif($mutabaah->magrib == 3)
                                Tidak Sholat
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Solat Isya</td>
                        <td>
                            @if ($mutabaah->isya == 1)
                                Berjamaah
                            @elseif($mutabaah->isya == 2)
                                Sendirian
                            @elseif($mutabaah->isya == 3)
                                Tidak Sholat
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Solat Dhuha</td>
                        <td>
                            @if ($mutabaah->dhuha == 1)
                                Berjamaah
                            @elseif($mutabaah->dhuha == 2)
                                Sendirian
                            @elseif($mutabaah->dhuha == 3)
                                Tidak Sholat
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Solat Tarawih</td>
                        <td>
                            @if ($mutabaah->tarawih == 1)
                                Berjamaah
                            @elseif($mutabaah->tarawih == 2)
                                Sendirian
                            @elseif($mutabaah->tarawih == 3)
                                Tidak Sholat
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Solat Tahajud</td>
                        <td>
                            @if ($mutabaah->tahajud == 1)
                                Berjamaah
                            @elseif($mutabaah->tahajud == 2)
                                Sendirian
                            @elseif($mutabaah->tahajud == 3)
                                Tidak Sholat
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Tilawah</td>
                        <td>
                            {{ $mutabaah->tilawah }}
                        </td>
                    </tr>
                    <tr>
                        <td>Infaq</td>
                        <td>
                            {{ $mutabaah->infaq }}
                        </td>
                    </tr>
                    <tr>
                        <td>Birrul Walidain</td>
                        <td>
                            {{ $mutabaah->birrul }}
                        </td>
                    </tr>
                </tbody>
            </table>
            {{-- <form action="{{ route('mutabaah.update', $mutabaah->id) }}" method="post">
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
                        <option value="iya">Iya</option>
                        <option value="tidak">Tidak</option>
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
                        <option value="iya">Iya</option>
                        <option value="tidak">Tidak</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="birrul" class="form-label">Birrul Walidain</label>
                    <input id="birrul" type="text" class="form-control" name="birrul" required
                        placeholder="Tuliskan jenis Birrul Walidainnya" value="{{ $mutabaah->birrul }}">
                </div>

                <button type="submit" class="btn btn-primary">simpan data</button>
            </form> --}}
        </div>
    </div>
@endsection
