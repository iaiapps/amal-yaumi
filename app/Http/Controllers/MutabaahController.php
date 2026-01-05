<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Mutabaah;
use App\Models\MutabaahItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MutabaahController extends Controller
{
    // Admin Methods
    public function index()
    {
        $mutabaahs = Mutabaah::with('student')->latest('tanggal')->get();
        return view('mutabaah.index', compact('mutabaahs'));
    }

    public function create(Request $request)
    {
        $students = Student::all();
        $items = MutabaahItem::active()->get();
        $defaultDate = $request->query('date', date('Y-m-d'));
        return view('mutabaah.create', compact('students', 'items', 'defaultDate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'tanggal' => 'required|date',
            'data' => 'nullable|array',
        ]);

        // Handle checkbox: unchecked = "Tidak", checked = "Ya"
        $allItems = MutabaahItem::active()->pluck('id');
        $data = [];
        
        foreach ($allItems as $itemId) {
            if (isset($request->data[$itemId])) {
                $data[$itemId] = $request->data[$itemId];
            } else {
                // Checkbox unchecked or empty input
                $item = MutabaahItem::find($itemId);
                if ($item && $item->tipe == 'ya_tidak') {
                    $data[$itemId] = 'Tidak';
                }
            }
        }
        
        $validated['data'] = $data;

        Mutabaah::create($validated);

        return redirect()->route('mutabaah.index')->with('success', 'Berhasil menambah data');
    }

    public function show(Mutabaah $mutabaah)
    {
        $items = MutabaahItem::active()->get();
        return view('mutabaah.show', compact('mutabaah', 'items'));
    }

    public function edit(Mutabaah $mutabaah)
    {
        $students = Student::all();
        $items = MutabaahItem::active()->get();
        return view('mutabaah.edit', compact('mutabaah', 'students', 'items'));
    }

    public function update(Request $request, Mutabaah $mutabaah)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'tanggal' => 'required|date',
            'data' => 'required|array',
        ]);

        $mutabaah->update($validated);

        return redirect()->route('mutabaah.index')->with('success', 'Berhasil update data');
    }

    public function destroy(Mutabaah $mutabaah)
    {
        $mutabaah->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }

    // Student Methods
    public function amalIndex()
    {
        $student = Auth::user()->student;
        $mutabaahs = Mutabaah::where('student_id', $student->id)->latest('tanggal')->get();
        return view('mutabaah.index_s', compact('mutabaahs'));
    }

    public function amalCreate(Request $request)
    {
        $items = MutabaahItem::active()->get();
        $defaultDate = $request->query('date', date('Y-m-d'));
        return view('mutabaah.create', compact('items', 'defaultDate'));
    }

    public function amalStore(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'data' => 'nullable|array',
        ]);

        // Handle checkbox: unchecked = "Tidak", checked = "Ya"
        $allItems = MutabaahItem::active()->pluck('id');
        $data = [];
        
        foreach ($allItems as $itemId) {
            if (isset($request->data[$itemId])) {
                $data[$itemId] = $request->data[$itemId];
            } else {
                // Checkbox unchecked or empty input
                $item = MutabaahItem::find($itemId);
                if ($item && $item->tipe == 'ya_tidak') {
                    $data[$itemId] = 'Tidak';
                }
            }
        }
        
        $validated['data'] = $data;
        $validated['student_id'] = Auth::user()->student->id;

        Mutabaah::create($validated);

        return redirect()->route('amal.index')->with('success', 'Berhasil menambah data');
    }

    public function amalShow(Mutabaah $mutabaah)
    {
        return $this->show($mutabaah);
    }

    public function amalEdit(Mutabaah $mutabaah)
    {
        $items = MutabaahItem::active()->get();
        return view('mutabaah.edit', compact('mutabaah', 'items'));
    }

    public function amalUpdate(Request $request, Mutabaah $mutabaah)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'data' => 'required|array',
        ]);

        $mutabaah->update($validated);

        return redirect()->route('amal.index')->with('success', 'Berhasil update data');
    }

    public function amalDestroy(Mutabaah $mutabaah)
    {
        $mutabaah->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
