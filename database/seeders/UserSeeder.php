<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@amalyaumi.com',
            'password' => Hash::make('passwordamalyaumi')
        ]);
        $admin->assignRole('admin');

        // $guruUser = User::create([
        //     'name' => 'Guru Dummy',
        //     'email' => 'guru@gmail.com',
        //     'password' => Hash::make('password')
        // ]);
        // $guruUser->assignRole('guru');

        // $guru = \App\Models\Teacher::create([
        //     'user_id' => $guruUser->id,
        //     'nama' => 'Guru Dummy',
        //     'nip' => '12345678',
        //     'jk' => 'L',
        // ]);

        // $kelas = \App\Models\Classroom::create([
        //     'teacher_id' => $guru->id,
        //     'nama' => '5A',
        //     'tingkat' => '5',
        //     'kapasitas' => 30,
        // ]);

        // $siswaUser = User::create([
        //     'name' => 'Siswa Dummy',
        //     'email' => 'siswa@gmail.com',
        //     'password' => Hash::make('password')
        // ]);
        // $siswaUser->assignRole('siswa');

        // \App\Models\Student::create([
        //     'user_id' => $siswaUser->id,
        //     'nama' => 'Siswa Dummy',
        //     'nis' => '20240001',
        //     'jk' => 'L',
        //     'kelas' => '5A',
        // ]);
    }
}
