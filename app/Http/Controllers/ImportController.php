<?php

namespace App\Http\Controllers;

use App\Models\Import;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ImportController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $classrooms = \App\Models\Classroom::where('teacher_id', $teacher->id)->get();
        $imports = Import::with('user')->orderBy('created_at', 'desc')->get();
        return view('guru.import.index', compact('imports', 'classrooms'));
    }

    public function template(Request $request)
    {
        $className = '5A'; // Default example
        if ($request->has('classroom_id')) {
            $classroom = \App\Models\Classroom::find($request->classroom_id);
            if ($classroom) {
                $className = $classroom->nama;
            }
        }

        return Excel::download(new class($className) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $className;

            public function __construct($className)
            {
                $this->className = $className;
            }

            public function array(): array
            {
                return [
                    ['Ahmad Fauzi', '20240001', 'L', $this->className],
                    ['Siti Nurhaliza', '20240002', 'P', $this->className],
                ];
            }

            public function headings(): array
            {
                return ['nama', 'nis', 'jk', 'kelas'];
            }
        }, 'template-siswa-' . $className . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            $import = new StudentsImport();
            Excel::import($import, $file);

            Import::create([
                'user_id' => Auth::id(),
                'type' => 'students',
                'file_name' => $fileName,
                'total_rows' => $import->getRowCount(),
                'success_rows' => $import->getSuccessCount(),
                'failed_rows' => $import->getFailedCount(),
                'errors' => json_encode($import->getErrors()),
            ]);

            return redirect()->route('guru.import.index')->with('success', 'Import berhasil! ' . $import->getSuccessCount() . ' data berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}
