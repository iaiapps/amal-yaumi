<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Mutabaah - {{ $student->nama }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 5px 0; }
        .info { margin-bottom: 15px; }
        .info table { width: 100%; }
        .info td { padding: 3px 0; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th, table.data td { border: 1px solid #000; padding: 5px; text-align: center; }
        table.data th { background-color: #f0f0f0; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $school->nama ?? 'SEKOLAH' }}</h2>
        <p>{{ $school->alamat ?? '' }}</p>
        <h3>LAPORAN MUTABAAH AMAL YAUMI</h3>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="20%">Nama</td>
                <td width="2%">:</td>
                <td>{{ $student->nama }}</td>
            </tr>
            <tr>
                <td>NIS</td>
                <td>:</td>
                <td>{{ $student->nis }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $student->kelas }}</td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Puasa</th>
                <th>Subuh</th>
                <th>Dhuhur</th>
                <th>Ashar</th>
                <th>Magrib</th>
                <th>Isya</th>
                <th>Dhuha</th>
                <th>Tarawih</th>
                <th>Tahajud</th>
                <th>Tilawah</th>
                <th>Infaq</th>
                <th>Birrul</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mutabaahs as $m)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($m->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $m->puasa }}</td>
                <td>{{ $m->subuh }}</td>
                <td>{{ $m->dhuhur }}</td>
                <td>{{ $m->ashar }}</td>
                <td>{{ $m->magrib }}</td>
                <td>{{ $m->isya }}</td>
                <td>{{ $m->dhuha }}</td>
                <td>{{ $m->tarawih }}</td>
                <td>{{ $m->tahajud }}</td>
                <td>{{ $m->tilawah }}</td>
                <td>{{ $m->infaq }}</td>
                <td>{{ $m->birrul }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="14">Tidak ada data mutabaah pada periode ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>{{ now()->format('d F Y') }}</p>
        <br><br><br>
        <p>{{ $school->kepala_sekolah ?? '_______________' }}</p>
        <p>Kepala Sekolah</p>
    </div>
</body>
</html>
