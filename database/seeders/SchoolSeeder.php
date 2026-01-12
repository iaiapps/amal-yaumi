<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        School::create([
            'nama' => 'Amal Yaumi School',
            'alamat' => 'Jl. Contoh No. 123',
            'telp' => '021-12345678',
            'email' => 'info@amalyaumi.sch.id',
            'website' => 'https://amalyaumi.sch.id',
            'kepala_sekolah' => 'Nama Kepala Sekolah',
            'nip_kepala' => '123456789',
            'max_class_per_teacher' => 5,
        ]);
    }
}
