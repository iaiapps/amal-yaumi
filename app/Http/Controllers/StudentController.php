<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $id = User::create([
            'name' => $request->nama,
            'email' => $request->nis . '@gmail.com',
            'password' => Hash::make('password1234')
        ])->id;

        $data['user_id'] = $id;
        Student::create($data);
        return redirect()->route('student.index')->with('success', 'Berhasil menambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $data = $request->all();
        $student->user->update([
            'name' => $request->nama,
            'email' => $request->nis . '@gmail.com',
        ]);
        $student->update($data);
        return redirect()->route('student.index')->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->user->delete();
        $student->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
