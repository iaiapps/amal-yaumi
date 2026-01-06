<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $kelas = Classroom::withCount('students')->get();
        return view('classroom.index', compact('kelas'));
    }

    public function create()
    {
        return view('classroom.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:classrooms,nama',
            'tingkat' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
        ]);

        Classroom::create($request->all());

        return redirect()->route('classroom.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit(Classroom $classroom)
    {
        return view('classroom.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'nama' => 'required|string|unique:classrooms,nama,' . $classroom->id,
            'tingkat' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
        ]);

        $classroom->update($request->all());

        return redirect()->route('classroom.index')->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('classroom.index')->with('success', 'Kelas berhasil dihapus');
    }
}
