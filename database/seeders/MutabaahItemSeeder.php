<?php

namespace Database\Seeders;

use App\Models\MutabaahItem;
use Illuminate\Database\Seeder;

class MutabaahItemSeeder extends Seeder
{
    public function run(): void
    {
       
        $items = [
            // Sholat Fardhu
            ['nama' => 'Subuh', 'kategori' => 'sholat_fardhu', 'tipe' => 'ya_tidak', 'urutan' => 1, 'teacher_id' => null],
            ['nama' => 'Dzuhur', 'kategori' => 'sholat_fardhu', 'tipe' => 'ya_tidak', 'urutan' => 2, 'teacher_id' => null],
            ['nama' => 'Ashar', 'kategori' => 'sholat_fardhu', 'tipe' => 'ya_tidak', 'urutan' => 3, 'teacher_id' => null],
            ['nama' => 'Maghrib', 'kategori' => 'sholat_fardhu', 'tipe' => 'ya_tidak', 'urutan' => 4, 'teacher_id' => null],
            ['nama' => 'Isya', 'kategori' => 'sholat_fardhu', 'tipe' => 'ya_tidak', 'urutan' => 5, 'teacher_id' => null],
            
            // Sholat Sunnah
            ['nama' => 'Sholat Dhuha', 'kategori' => 'sholat_sunnah', 'tipe' => 'ya_tidak', 'urutan' => 6, 'teacher_id' => null],
            ['nama' => 'Sholat Tahajud & Witir', 'kategori' => 'sholat_sunnah', 'tipe' => 'ya_tidak', 'urutan' => 7, 'teacher_id' => null],
            ['nama' => 'Sholat Rawatib', 'kategori' => 'sholat_sunnah', 'tipe' => 'ya_tidak', 'urutan' => 8, 'teacher_id' => null],

            // Interaksi Al-Qur'an
            ['nama' => 'Tilawah Al-Qur\'an', 'kategori' => 'interaksi_al_quran', 'tipe' => 'angka', 'urutan' => 9, 'teacher_id' => null],
            ['nama' => 'Hafalan Baru (Ziyadah)', 'kategori' => 'interaksi_al_quran', 'tipe' => 'text', 'urutan' => 10, 'teacher_id' => null],
            ['nama' => 'Muroja\'ah Hafalan', 'kategori' => 'interaksi_al_quran', 'tipe' => 'ya_tidak', 'urutan' => 11, 'teacher_id' => null],

            // Dzikir & Spiritual
            ['nama' => 'Dzikir Pagi', 'kategori' => 'dzikir_spiritual', 'tipe' => 'ya_tidak', 'urutan' => 12, 'teacher_id' => null],
            ['nama' => 'Dzikir Petang', 'kategori' => 'dzikir_spiritual', 'tipe' => 'ya_tidak', 'urutan' => 13, 'teacher_id' => null],
            ['nama' => 'Membaca Al-Ma\'tsurat', 'kategori' => 'dzikir_spiritual', 'tipe' => 'ya_tidak', 'urutan' => 14, 'teacher_id' => null],

            // Adab & Karakter
            ['nama' => 'Membantu Orang Tua', 'kategori' => 'adab_karakter', 'tipe' => 'ya_tidak', 'urutan' => 15, 'teacher_id' => null],
            ['nama' => 'Berkata Sopan & Jujur', 'kategori' => 'adab_karakter', 'tipe' => 'ya_tidak', 'urutan' => 16, 'teacher_id' => null],
            ['nama' => 'Merapikan Tempat Tidur', 'kategori' => 'adab_karakter', 'tipe' => 'ya_tidak', 'urutan' => 17, 'teacher_id' => null],
            ['nama' => 'Tidur Tepat Waktu', 'kategori' => 'adab_karakter', 'tipe' => 'ya_tidak', 'urutan' => 18, 'teacher_id' => null],

            // Kemandirian & Sosial
            ['nama' => 'Belajar Mandiri / PR', 'kategori' => 'kemandirian_sosial', 'tipe' => 'ya_tidak', 'urutan' => 19, 'teacher_id' => null],
            ['nama' => 'Infaq Harian', 'kategori' => 'kemandirian_sosial', 'tipe' => 'ya_tidak', 'urutan' => 20, 'teacher_id' => null],
            ['nama' => 'Membaca Buku', 'kategori' => 'kemandirian_sosial', 'tipe' => 'ya_tidak', 'urutan' => 21, 'teacher_id' => null],
            ['nama' => 'Berolahraga', 'kategori' => 'kemandirian_sosial', 'tipe' => 'ya_tidak', 'urutan' => 22, 'teacher_id' => null],
        ];

        foreach ($items as $item) {
            MutabaahItem::create($item);
        }
    }
}
