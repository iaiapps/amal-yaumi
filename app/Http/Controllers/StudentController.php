<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    private function getTeacherId()
    {
        $user = Auth::user();
        if (!$user instanceof User) return null;
        return $user->getRoleNames()->first() == 'guru' ? $user->teacher->id : null;
    }

    public function index()
    {
        $user = Auth::user();
        $role = $user instanceof User ? $user->getRoleNames()->first() : 'admin';
        $teacherId = $this->getTeacherId();

        $students = Student::when($role == 'guru', function($q) use ($teacherId) {
            return $q->whereIn('kelas', Classroom::where('teacher_id', $teacherId)->pluck('nama'));
        })->get();

        return view('student.index', compact('students', 'role'));
    }

    public function create()
    {
        $user = Auth::user();
        $role = $user instanceof User ? $user->getRoleNames()->first() : 'admin';
        $teacherId = $this->getTeacherId();

        $kelas = Classroom::when($role == 'guru', function($q) use ($teacherId) {
            return $q->where('teacher_id', $teacherId);
        })->get();

        return view('student.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string|unique:students,nis',
            'jk' => 'required|in:L,P',
            'kelas' => 'required|string',
        ]);

        $data = $request->all();

        $classroom = Classroom::where('nama', $request->kelas)->first();
        if ($classroom && $classroom->students()->count() >= $classroom->kapasitas) {
            return redirect()->back()->with('error', 'Kapasitas kelas sudah penuh (Maks: ' . $classroom->kapasitas . ')');
        }

        $id = User::create([
            'name' => $request->nama,
            'email' => $request->nis . '@gmail.com',
            'password' => Hash::make('password1234'),
        ])->assignRole('siswa')->id;

        $data['user_id'] = $id;
        Student::create($data);

        return redirect()->route('student.index')->with('success', 'Berhasil menambah data siswa');
    }

    public function edit(Student $student)
    {
        $user = Auth::user();
        $role = $user instanceof User ? $user->getRoleNames()->first() : 'admin';
        $teacherId = $this->getTeacherId();

        if ($role == 'guru') {
            $myClassNames = Classroom::where('teacher_id', $teacherId)->pluck('nama')->toArray();
            if (!in_array($student->kelas, $myClassNames)) {
                abort(403, 'Siswa ini bukan bagian dari kelas bimbingan Anda.');
            }
        }

        $kelas = Classroom::when($role == 'guru', function($q) use ($teacherId) {
            return $q->where('teacher_id', $teacherId);
        })->get();

        return view('student.edit', compact('student', 'kelas'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string|unique:students,nis,' . $student->id,
            'jk' => 'required|in:L,P',
            'kelas' => 'required|string',
        ]);

        $data = $request->all();
        $student->user->update([
            'name' => $request->nama,
            'email' => $request->nis . '@gmail.com',
        ]);
        $student->update($data);

        return redirect()->route('student.index')->with('success', 'Berhasil update data siswa');
    }

    public function destroy(Student $student)
    {
        $user = Auth::user();
        $role = $user instanceof User ? $user->getRoleNames()->first() : 'admin';
        $teacherId = $this->getTeacherId();

        if ($role == 'guru') {
            $myClassNames = Classroom::where('teacher_id', $teacherId)->pluck('nama')->toArray();
            if (!in_array($student->kelas, $myClassNames)) {
                abort(403);
            }
        }

        if ($student->user) {
            $student->user->delete();
        }
        $student->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus data siswa');
    }
}
