<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Mutabaah;
use Illuminate\Http\Request;

class MutabaahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mutabaahs = Mutabaah::all();
        return view('mutabaah.index', compact('mutabaahs'));
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
        //
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
}
