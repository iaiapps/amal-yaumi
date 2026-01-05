<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Mutabaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $todayMutabaah = Mutabaah::whereDate('tanggal', today())->count();
        $totalMutabaah = Mutabaah::count();
        
        // Top 5 siswa bulan ini
        $topStudents = Student::select('students.id', 'students.nama', 'students.kelas', DB::raw('COUNT(mutabaahs.id) as total_mutabaah'))
            ->leftJoin('mutabaahs', 'students.id', '=', 'mutabaahs.student_id')
            ->whereMonth('mutabaahs.tanggal', now()->month)
            ->whereYear('mutabaahs.tanggal', now()->year)
            ->groupBy('students.id', 'students.nama', 'students.kelas')
            ->orderBy('total_mutabaah', 'desc')
            ->limit(5)
            ->get();

        // Data untuk grafik mingguan (7 hari terakhir)
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = Mutabaah::whereDate('tanggal', $date)->count();
            $weeklyData[] = [
                'date' => $date->format('d M'),
                'count' => $count
            ];
        }

        // Statistik per kelas
        $statsByClass = Student::select('kelas', DB::raw('COUNT(*) as total'))
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get();

        return view('dashboard.admin', compact(
            'totalStudents',
            'totalTeachers',
            'todayMutabaah',
            'totalMutabaah',
            'topStudents',
            'weeklyData',
            'statsByClass'
        ));
    }

    public function student()
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            return redirect()->route('home');
        }

        // Total mutabaah bulan ini
        $monthlyCount = Mutabaah::where('student_id', $student->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        // Streak (hari berturut-turut)
        $streak = $this->calculateStreak($student->id);

        // Progress ibadah (persentase dari hari dalam bulan)
        $daysInMonth = now()->daysInMonth;
        $progressPercentage = ($monthlyCount / $daysInMonth) * 100;

        // Data untuk grafik personal (7 hari terakhir)
        $personalData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $mutabaah = Mutabaah::where('student_id', $student->id)
                ->whereDate('tanggal', $date)
                ->first();
            
            $personalData[] = [
                'date' => $date->format('d M'),
                'filled' => $mutabaah ? 1 : 0
            ];
        }

        // Mutabaah terbaru
        $recentMutabaah = Mutabaah::where('student_id', $student->id)
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.student', compact(
            'student',
            'monthlyCount',
            'streak',
            'progressPercentage',
            'personalData',
            'recentMutabaah'
        ));
    }

    private function calculateStreak($studentId)
    {
        $streak = 0;
        $date = Carbon::today();
        
        while (true) {
            $exists = Mutabaah::where('student_id', $studentId)
                ->whereDate('tanggal', $date)
                ->exists();
            
            if (!$exists) {
                break;
            }
            
            $streak++;
            $date->subDay();
        }
        
        return $streak;
    }
}
