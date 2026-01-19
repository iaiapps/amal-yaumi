<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'nama' => 'SD IT Amal Mulia',
            'alamat' => 'Jl. Contoh No. 123',
            'telp' => '021-12345678',
            'email' => 'info@amalyaumi.sch.id',
            'website' => 'https://amalyaumi.sch.id',
            'max_class_per_teacher' => 2,
            'max_students_per_class' => 30,
        ]);
    }
}
