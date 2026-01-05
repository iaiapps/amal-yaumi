# Dashboard Features - Fase 3

## Dashboard Admin

### Statistik Cards
- Total Siswa
- Total Guru  
- Mutabaah Hari Ini

### Grafik & Visualisasi
- **Grafik Line**: Mutabaah 7 hari terakhir
- **Grafik Doughnut**: Distribusi siswa per kelas

### Top 5 Siswa
- Ranking siswa berdasarkan total mutabaah bulan ini
- Badge medali untuk top 3

### Quick Actions
- Tambah Siswa
- Lihat Mutabaah

## Dashboard Siswa

### Statistik Personal
- Mutabaah Bulan Ini
- Streak (hari berturut-turut)
- Progress Persentase

### Grafik Personal
- **Grafik Bar**: Aktivitas 7 hari terakhir
- **Grafik Doughnut**: Progress bulan ini

### Mutabaah Terbaru
- Tabel 5 mutabaah terakhir
- Status badge untuk setiap ibadah

### Quick Actions
- Isi Mutabaah

## Teknologi
- Chart.js untuk visualisasi data
- Bootstrap 5 untuk UI
- Laravel Eloquent untuk query data

## Routes
- `/` - Auto redirect ke dashboard sesuai role
- Admin: `dashboard.admin` view
- Siswa: `dashboard.student` view
