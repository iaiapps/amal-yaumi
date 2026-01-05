<?php

namespace App\Exports;

use App\Models\Mutabaah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MutabaahExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Mutabaah::with('student')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Siswa',
            'Kelas',
            'Puasa',
            'Subuh',
            'Dhuhur',
            'Ashar',
            'Magrib',
            'Isya',
            'Dhuha',
            'Tarawih',
            'Tahajud',
            'Tilawah',
            'Infaq',
            'Birrul Walidain'
        ];
    }

    public function map($mutabaah): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            \Carbon\Carbon::parse($mutabaah->tanggal)->format('d-m-Y'),
            $mutabaah->student->nama,
            $mutabaah->student->kelas,
            $mutabaah->puasa,
            $mutabaah->subuh,
            $mutabaah->dhuhur,
            $mutabaah->ashar,
            $mutabaah->magrib,
            $mutabaah->isya,
            $mutabaah->dhuha,
            $mutabaah->tarawih,
            $mutabaah->tahajud,
            $mutabaah->tilawah,
            $mutabaah->infaq,
            $mutabaah->birrul
        ];
    }
}
