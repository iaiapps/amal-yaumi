<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'user_id' => '2',
            'nama' => 'Siswa',
            'nis' => '1111',
            'jk' => 'L',
            'kelas' => '5'
        ]);
    }
}
