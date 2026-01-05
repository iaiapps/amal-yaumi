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

    public function edit(Kelas $kela)
    {
        return view('classroom.edit', compact('kela'));
    }

    public function update(Request $request, Classroom $kela)
    {
        $request->validate([
            'nama' => 'required|string|unique:classrooms,nama,' . $kela->id,
            'tingkat' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
        ]);

        $kela->update($request->all());

        return redirect()->route('classroom.index')->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroy(Classroom $kela)
    {
        $kela->delete();
        return redirect()->route('classroom.index')->with('success', 'Kelas berhasil dihapus');
    }
}
