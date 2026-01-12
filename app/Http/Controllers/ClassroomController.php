<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    private function getTeacherId()
    {
        $user = Auth::user();
        if (!$user instanceof User)
            return null;
        return $user->getRoleNames()->first() == 'guru' ? $user->teacher->id : null;
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user instanceof User)
            abort(401);
        $role = $user->getRoleNames()->first();
        $teacherId = $this->getTeacherId();

        $kelas = Classroom::when($role == 'guru', function ($q) use ($teacherId) {
            return $q->where('teacher_id', $teacherId);
        })->withCount('students')->get();

        $setting = Setting::first();
        $maxClasses = $setting ? $setting->max_class_per_teacher : 5;

        return view($role . '.classroom.index', compact('kelas', 'role', 'maxClasses'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user instanceof User)
            abort(401);
        $role = $user->getRoleNames()->first();

        if ($role != 'guru') {
            return redirect()->route($role . '.classroom.index')->with('error', 'Hanya Guru yang dapat membuat kelas baru.');
        }

        $teacherId = $this->getTeacherId();
        $myClassCount = Classroom::where('teacher_id', $teacherId)->count();
        $setting = Setting::first();
        $maxClasses = $setting ? $setting->max_class_per_teacher : 5;

        if ($myClassCount >= $maxClasses) {
            return redirect()->route($role . '.classroom.index')->with('error', 'Batas pembuatan kelas sudah tercapai (Maks: ' . $maxClasses . ' kelas).');
        }

        return view('guru.classroom.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user instanceof User)
            abort(401);
        $role = $user->getRoleNames()->first();

        if ($role != 'guru') {
            return redirect()->route($role . '.classroom.index')->with('error', 'Hanya Guru yang dapat membuat kelas baru.');
        }

        $teacherId = $this->getTeacherId();
        $myClassCount = Classroom::where('teacher_id', $teacherId)->count();
        $setting = School::first();
        $maxClasses = $setting ? $setting->max_class_per_teacher : 5;

        if ($myClassCount >= $maxClasses) {
            return redirect()->route($role . '.classroom.index')->with('error', 'Batas pembuatan kelas sudah tercapai.');
        }

        $request->validate([
            'nama' => 'required|string|unique:classrooms,nama',
            'tingkat' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $data['teacher_id'] = $teacherId;

        Classroom::create($data);

        return redirect()->route($role . '.classroom.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function show(Classroom $classroom)
    {
        $teacherId = $this->getTeacherId();
        if ($teacherId && $classroom->teacher_id != $teacherId) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $students = $classroom->students()->orderBy('nama')->get();
        $role = Auth::user()->getRoleNames()->first();

        return view($role . '.classroom.show', compact('classroom', 'students', 'role'));
    }

    public function edit(Classroom $classroom)
    {
        $teacherId = $this->getTeacherId();
        if ($teacherId && $classroom->teacher_id != $teacherId) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        return view('guru.classroom.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $teacherId = $this->getTeacherId();
        if ($teacherId && $classroom->teacher_id != $teacherId) {
            abort(403);
        }

        $request->validate([
            'nama' => 'required|string|unique:classrooms,nama,' . $classroom->id,
            'tingkat' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
        ]);

        $classroom->update($request->all());

        $role = Auth::user()->getRoleNames()->first();
        return redirect()->route($role . '.classroom.index')->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroy(Classroom $classroom)
    {
        $teacherId = $this->getTeacherId();
        if ($teacherId && $classroom->teacher_id != $teacherId) {
            abort(403);
        }

        $classroom->delete();
        $role = Auth::user()->getRoleNames()->first();
        return redirect()->route($role . '.classroom.index')->with('success', 'Kelas berhasil dihapus');
    }
}
