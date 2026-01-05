# Report Features - Fase 4

## Laporan PDF

### Laporan Per Siswa
- PDF individual untuk setiap siswa
- Filter berdasarkan tanggal (start & end date)
- Informasi lengkap: Nama, NIS, Kelas
- Tabel detail mutabaah harian
- Header dengan logo sekolah
- Tanda tangan kepala sekolah

### Laporan Semua Siswa
- PDF landscape untuk semua siswa
- Ringkasan statistik per siswa
- Kolom: Sholat Wajib, Sholat Sunnah, Lainnya
- Total mutabaah per siswa
- Filter periode tanggal

## Export Excel

### Export Data Siswa
- Format: XLSX
- Kolom: No, Nama, NIS, JK, Kelas, Guru Pembina, Email
- Include relasi dengan guru dan user

### Export Data Mutabaah
- Format: XLSX
- Filter berdasarkan tanggal
- Kolom lengkap semua ibadah
- Include nama siswa dan kelas
- Sorted by tanggal descending

## Fitur Tambahan
- Date picker untuk filter tanggal
- Default periode: bulan berjalan
- Download langsung (tidak preview)
- Nama file dengan timestamp

## Routes
- `/reports` - Halaman laporan
- `/reports/student/{id}/pdf` - PDF per siswa
- `/reports/all/pdf` - PDF semua siswa
- `/reports/students/export` - Excel data siswa
- `/reports/mutabaah/export` - Excel data mutabaah

## Packages
- `barryvdh/laravel-dompdf` - Generate PDF
- `maatwebsite/excel` - Export Excel
