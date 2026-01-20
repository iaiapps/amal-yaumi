<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'max_class_per_teacher' => 2,
            'max_students_per_class' => 30,
        ]);
    }
}
