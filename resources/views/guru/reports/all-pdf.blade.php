<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Mutabaah Semua Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 5px 0; font-size: 16px; }
        .header h3 { margin: 5px 0; font-size: 14px; }
        .info { margin-bottom: 10px; font-size: 11px; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th, table.data td { border: 1px solid #000; padding: 3px; text-align: center; font-size: 9px; }
        table.data th { background-color: #f0f0f0; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN MUTABAAH SEMUA SISWA</h2>
    </div>

    <div class="info">
        <strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
    </div>

    <table class="data">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Kelas</th>
                <th colspan="5">Sholat Wajib</th>
                <th colspan="3">Sholat Sunnah</th>
                <th colspan="3">Lainnya</th>
                <th rowspan="2">Total</th>
            </tr>
            <tr>
                <th>Sb</th>
                <th>Dh</th>
                <th>As</th>
                <th>Mg</th>
                <th>Is</th>
                <th>Dha</th>
                <th>Trw</th>
                <th>Thj</th>
                <th>Tlw</th>
                <th>Inf</th>
                <th>Bir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            @php
                $mutabaahs = $student->mutabaah;
                $total = $mutabaahs->count();
                $subuh = $mutabaahs->where('subuh', 'Ya')->count();
                $dhuhur = $mutabaahs->where('dhuhur', 'Ya')->count();
                $ashar = $mutabaahs->where('ashar', 'Ya')->count();
                $magrib = $mutabaahs->where('magrib', 'Ya')->count();
                $isya = $mutabaahs->where('isya', 'Ya')->count();
                $dhuha = $mutabaahs->where('dhuha', 'Ya')->count();
                $tarawih = $mutabaahs->where('tarawih', 'Ya')->count();
                $tahajud = $mutabaahs->where('tahajud', 'Ya')->count();
                $tilawah = $mutabaahs->where('tilawah', 'Ya')->count();
                $infaq = $mutabaahs->where('infaq', 'Ya')->count();
                $birrul = $mutabaahs->where('birrul', 'Ya')->count();
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="text-align: left;">{{ $student->nama }}</td>
                <td>{{ $student->kelas }}</td>
                <td>{{ $subuh }}</td>
                <td>{{ $dhuhur }}</td>
                <td>{{ $ashar }}</td>
                <td>{{ $magrib }}</td>
                <td>{{ $isya }}</td>
                <td>{{ $dhuha }}</td>
                <td>{{ $tarawih }}</td>
                <td>{{ $tahajud }}</td>
                <td>{{ $tilawah }}</td>
                <td>{{ $infaq }}</td>
                <td>{{ $birrul }}</td>
                <td><strong>{{ $total }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>{{ now()->format('d F Y') }}</p>
        <br><br>
        <p>{{ auth()->user()->name }}</p>
        <p>Admin</p>
    </div>
</body>
</html>
