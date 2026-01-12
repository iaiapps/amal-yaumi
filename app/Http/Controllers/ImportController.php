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
        $imports = Import::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.import.index', compact('imports'));
    }

    public function template()
    {
        return Excel::download(new class implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            public function array(): array
            {
                return [
                    ['Ahmad Fauzi', '20240001', 'L', 'X-A'],
                    ['Siti Nurhaliza', '20240002', 'P', 'X-A'],
                    ['Muhammad Rizki', '20240003', 'L', 'X-B'],
                ];
            }

            public function headings(): array
            {
                return ['nama', 'nis', 'jk', 'kelas'];
            }
        }, 'template-siswa.xlsx');
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

            return redirect()->route('import.index')->with('success', 'Import berhasil! ' . $import->getSuccessCount() . ' data berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}
