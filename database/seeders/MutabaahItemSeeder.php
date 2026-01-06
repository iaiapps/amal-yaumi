<?php

namespace Database\Seeders;

use App\Models\MutabaahItem;
use Illuminate\Database\Seeder;

class MutabaahItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Sholat Wajib
            ['nama' => 'Subuh', 'kategori' => 'sholat_wajib', 'tipe' => 'ya_tidak', 'urutan' => 1],
            ['nama' => 'Dhuhur', 'kategori' => 'sholat_wajib', 'tipe' => 'ya_tidak', 'urutan' => 2],
            ['nama' => 'Ashar', 'kategori' => 'sholat_wajib', 'tipe' => 'ya_tidak', 'urutan' => 3],
            ['nama' => 'Magrib', 'kategori' => 'sholat_wajib', 'tipe' => 'ya_tidak', 'urutan' => 4],
            ['nama' => 'Isya', 'kategori' => 'sholat_wajib', 'tipe' => 'ya_tidak', 'urutan' => 5],

            // Sholat Sunnah
            ['nama' => 'Dhuha', 'kategori' => 'sholat_sunnah', 'tipe' => 'ya_tidak', 'urutan' => 6],
            ['nama' => 'Tarawih', 'kategori' => 'sholat_sunnah', 'tipe' => 'ya_tidak', 'urutan' => 7],
            ['nama' => 'Tahajud', 'kategori' => 'sholat_sunnah', 'tipe' => 'ya_tidak', 'urutan' => 8],

            // Lainnya
            ['nama' => 'Puasa', 'kategori' => 'lainnya', 'tipe' => 'ya_tidak', 'urutan' => 9],
            ['nama' => 'Tilawah', 'kategori' => 'lainnya', 'tipe' => 'ya_tidak', 'urutan' => 10],
            ['nama' => 'Infaq', 'kategori' => 'lainnya', 'tipe' => 'ya_tidak', 'urutan' => 11],
            ['nama' => 'Birrul Walidain', 'kategori' => 'lainnya', 'tipe' => 'ya_tidak', 'urutan' => 12],

        ];

        foreach ($items as $item) {
            MutabaahItem::create($item);
        }
    }
}
