<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Mutabaah;
// use App\Models\School;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MutabaahExport;
use App\Exports\StudentsExport;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('guru.reports.index', compact('students'));
    }

    public function studentPdf($id, Request $request)
    {
        $student = Student::with('teacher')->findOrFail($id);
        $items = \App\Models\MutabaahItem::active()->get();

        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        $mutabaahs = Mutabaah::where('student_id', $id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        $pdf = Pdf::loadView('reports.student-pdf', compact('student', 'mutabaahs', 'startDate', 'endDate', 'items'));

        return $pdf->download('laporan-' . $student->nama . '-' . now()->format('Y-m-d') . '.pdf');
    }

    public function allPdf(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        $students = Student::with([
            'mutabaah' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal', [$startDate, $endDate]);
            }
        ])->get();

        $pdf = Pdf::loadView('guru.reports.all-pdf', compact('students', 'startDate', 'endDate'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-semua-siswa-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportStudents()
    {
        return Excel::download(new StudentsExport, 'data-siswa-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function exportMutabaah(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        return Excel::download(new MutabaahExport($startDate, $endDate), 'data-mutabaah-' . now()->format('Y-m-d') . '.xlsx');
    }
}
