<?php

namespace Database\Seeders;

use App\Models\MutabaahItem;
use Illuminate\Database\Seeder;

class MutabaahItemSeeder extends Seeder
{
    public function run(): void
    {
        $guru = \App\Models\Teacher::first();
        $teacherId = $guru ? $guru->id : null;

        $items = [
            // Sholat Fardhu
            ['nama' => 'Subuh', 'kategori' => 'sholat_wajib', 'tipe' => 'ya_tidak', 'urutan' => 1, 'teacher_id' => $teacherId],
            ['nama' => 'Dhuhur', 'kategori' => 'sholat_wajib', 'tipe' => 'ya_tidak', 'urutan' => 2, 'teacher_id' => $teacherId],
            ['nama' => 'Ashar', 'kategori' => 'sholat_wajib', 'tipe' => 'ya_tidak', 'urutan' => 3, 'teacher_id' => $teacherId],
            ['nama' => 'Magrib', 'kategori' => 'sholat_wajib', 'tipe' => 'ya_tidak', 'urutan' => 4, 'teacher_id' => $teacherId],
            ['nama' => 'Isya', 'kategori' => 'sholat_wajib', 'tipe' => 'ya_tidak', 'urutan' => 5, 'teacher_id' => $teacherId],
// Sholat Sunnah
['nama' => 'Shalat Sunnah Dhuha', 'kategori' => 'sholat_sunnah', 'tipe' => 'ya_tidak', 'urutan' => 11, 'teacher_id' => $teacherId],

            // Al-Qur'an
            ['nama' => 'Membaca Iqra/Al-Quran', 'kategori' => 'lainnya', 'tipe' => 'ya_tidak', 'urutan' => 6, 'teacher_id' => $teacherId],
            ['nama' => 'Hafalan Surat Pendek', 'kategori' => 'lainnya', 'tipe' => 'ya_tidak', 'urutan' => 7, 'teacher_id' => $teacherId],

            // Karakter
            ['nama' => 'Membantu Orang Tua', 'kategori' => 'lainnya', 'tipe' => 'ya_tidak', 'urutan' => 8, 'teacher_id' => $teacherId],
            ['nama' => 'Infaq Harian', 'kategori' => 'lainnya', 'tipe' => 'ya_tidak', 'urutan' => 9, 'teacher_id' => $teacherId],
            ['nama' => 'Membaca Buku', 'kategori' => 'lainnya', 'tipe' => 'ya_tidak', 'urutan' => 10, 'teacher_id' => $teacherId],

            // Adab
            ['nama' => 'Dzikir Pagi', 'kategori' => 'lainnya', 'tipe' => 'ya_tidak', 'urutan' => 12, 'teacher_id' => $teacherId],
        ];

        foreach ($items as $item) {
            MutabaahItem::create($item);
        }
    }
}
