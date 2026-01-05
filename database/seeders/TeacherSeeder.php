<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user admin yang sudah ada
        $admin = User::where('email', 'admin@gmail.com')->first();
        
        if ($admin) {
            Teacher::create([
                'user_id' => $admin->id,
                'nama' => 'Admin',
                'nip' => '123456789',
                'jk' => 'L',
                'telp' => '081234567890',
            ]);
        }
    }
}
