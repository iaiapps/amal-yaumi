<?php

namespace App\Exports;

use App\Models\Mutabaah;
use App\Models\MutabaahItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MutabaahExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;
    protected $items;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->items = MutabaahItem::active()->get();
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
        $headers = ['No', 'Tanggal', 'Nama Siswa', 'Kelas'];
        
        foreach ($this->items as $item) {
            $headers[] = $item->nama;
        }
        
        return $headers;
    }

    public function map($mutabaah): array
    {
        static $no = 0;
        $no++;
        
        $row = [
            $no,
            \Carbon\Carbon::parse($mutabaah->tanggal)->format('d-m-Y'),
            $mutabaah->student->nama,
            $mutabaah->student->kelas,
        ];

        foreach ($this->items as $item) {
            $row[] = $mutabaah->data[$item->id] ?? '-';
        }
        
        return $row;
    }
}
