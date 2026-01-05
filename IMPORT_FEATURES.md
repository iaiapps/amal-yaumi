# Import Features - Fase 5

## Import Data Siswa

### Fitur Upload
- Upload file Excel (xlsx, xls, csv)
- Maksimal ukuran: 2MB
- Validasi format file
- Preview sebelum import (via template)

### Template Excel
- Download template dengan contoh data
- Format kolom: nama, nis, jk, kelas
- 3 baris contoh data
- Header row included

### Validasi Data
- **Nama**: Required, string
- **NIS**: Required, unique (tidak boleh duplikat)
- **Jenis Kelamin**: Required, L atau P (case insensitive)
- **Kelas**: Required, string

### Auto Create User
- Email: {nis}@student.com
- Password default: "password"
- Auto assign role: "siswa"

### Error Handling
- Track row yang gagal
- Simpan error message per row
- Partial import (lanjut meski ada error)
- Log semua import activity

### Riwayat Import
- Tanggal & waktu import
- Nama file
- User yang import
- Total rows
- Success count
- Failed count
- Status badge (Sukses/Partial)
- Detail error (modal popup)

## Import Log Database
- Table: `imports`
- Fields:
  - user_id (siapa yang import)
  - type (students/mutabaahs)
  - file_name
  - total_rows
  - success_rows
  - failed_rows
  - errors (JSON)
  - timestamps

## UI Features
- Panduan import step-by-step
- Contoh format tabel
- Alert success/error
- Modal untuk detail error
- Bootstrap 5 styling

## Routes
- `/import` - Halaman import
- `/import/template` - Download template
- `POST /import` - Process upload

## Security
- Auth middleware
- Role admin only
- File validation
- Max file size limit
- CSRF protection

## Teknologi
- Laravel Excel (Maatwebsite)
- PhpSpreadsheet
- WithHeadingRow (auto map columns)
- WithValidation (validate per row)
- ToModel (convert to Eloquent)
