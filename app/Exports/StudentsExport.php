<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Student::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'NIS',
            'Jenis Kelamin',
            'Kelas',
            'Email'
        ];
    }

    public function map($student): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $student->nama,
            $student->nis,
            $student->jk,
            $student->kelas,
            $student->user ? $student->user->email : '-'
        ];
    }
}
