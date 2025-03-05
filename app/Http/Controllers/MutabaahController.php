<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Mutabaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MutabaahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mutabaahs = Mutabaah::all();
        $students = Student::all();
        return view('mutabaah.index', compact('mutabaahs', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        return view('mutabaah.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Mutabaah::create($data);
        return redirect()->route('mutabaah.index')->with('success', 'Berhasil menambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mutabaah $mutabaah)
    {
        return view('mutabaah.show', compact('mutabaah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mutabaah $mutabaah)
    {
        $students = Student::all();
        return view('mutabaah.edit', compact('mutabaah', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mutabaah $mutabaah)
    {
        $data = $request->all();
        $mutabaah->update($data);
        return redirect()->route('mutabaah.index')->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mutabaah $mutabaah)
    {
        $mutabaah->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }

    // handle from user //
    public function amalIndex()
    {
        $user = Auth::user();
        $student = $user->student;
        $mutabaahs = Mutabaah::all();
        // $students = Student::all();
        return view('mutabaah.index_s', compact('mutabaahs', 'student'));
    }
    public function amalCreate()
    {
        return view('mutabaah.create');
    }
    public function amalStore(Request $request)
    {
        $data = $request->all();
        Mutabaah::create($data);
        return redirect()->route('home')->with('success', 'Berhasil menambah data');
    }
}
