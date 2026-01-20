<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    private $rowCount = 0;
    private $successCount = 0;
    private $failedCount = 0;
    private $errors = [];
    private $teacherId;

    public function __construct($teacherId = null)
    {
        $this->teacherId = $teacherId;
    }

    public function model(array $row)
    {
        $this->rowCount++;

        try {
            // Check if NIS already exists
            if (Student::where('nis', $row['nis'])->exists()) {
                $this->failedCount++;
                $this->errors[] = "Baris {$this->rowCount}: NIS {$row['nis']} sudah ada";
                return null;
            }

            // Validate class belongs to teacher
            if ($this->teacherId) {
                $myClassCount = \App\Models\Classroom::where('teacher_id', $this->teacherId)
                    ->where('nama', $row['kelas'])
                    ->count();
                if ($myClassCount == 0) {
                    $this->failedCount++;
                    $this->errors[] = "Baris {$this->rowCount}: Kelas {$row['kelas']} bukan bagian dari bimbingan Anda";
                    return null;
                }
            }

            // Create user
            $user = User::create([
                'name' => $row['nama'],
                'email' => $row['nis'] . '@student.com',
                'password' => Hash::make('password1234'),
            ]);
            $user->assignRole('siswa');

            // Create student
            $student = new Student([
                'user_id' => $user->id,
                'teacher_id' => $this->teacherId,
                'nama' => $row['nama'],
                'nis' => $row['nis'],
                'jk' => strtoupper($row['jk']),
                'kelas' => $row['kelas'],
            ]);

            $this->successCount++;
            return $student;
        } catch (\Exception $e) {
            $this->failedCount++;
            $this->errors[] = "Baris {$this->rowCount}: {$e->getMessage()}";
            return null;
        }
    }

    public function prepareForValidation($data, $index)
    {
        if (isset($data['nis'])) {
            $data['nis'] = (string) $data['nis'];
        }
        return $data;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            'nis' => 'required|string',
            'jk' => 'required|in:L,P,l,p',
            'kelas' => 'required|string',
        ];
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getFailedCount()
    {
        return $this->failedCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
