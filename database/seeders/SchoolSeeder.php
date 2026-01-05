<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        School::create([
            'nama' => 'Sekolah Islam Terpadu',
            'alamat' => 'Jl. Contoh No. 123',
            'telp' => '021-12345678',
            'email' => 'info@sekolah.sch.id',
            'website' => 'https://sekolah.sch.id',
            'kepala_sekolah' => 'Nama Kepala Sekolah',
            'nip_kepala' => '123456789',
        ]);
    }
}
