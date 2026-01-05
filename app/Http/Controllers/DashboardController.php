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
        
        // Siswa tidak aktif (tidak isi 3+ hari terakhir)
        $inactiveStudents = Student::whereDoesntHave('mutabaah', function($q) {
            $q->whereBetween('tanggal', [now()->subDays(3), now()]);
        })->limit(10)->get();
        
        // Completion rate bulan ini
        $daysInMonth = now()->day; // Hari yang sudah lewat
        $expectedEntries = $totalStudents * $daysInMonth;
        $actualEntries = Mutabaah::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
        $completionRate = $expectedEntries > 0 ? round(($actualEntries / $expectedEntries) * 100, 1) : 0;
        
        // Siswa aktif bulan ini (isi minimal 1x)
        $activeStudents = Student::whereHas('mutabaah', function($q) {
            $q->whereMonth('tanggal', now()->month)
              ->whereYear('tanggal', now()->year);
        })->count();
        
        // Avg mutabaah per siswa bulan ini
        $avgPerStudent = $totalStudents > 0 ? round($actualEntries / $totalStudents, 1) : 0;
        
        // Top 5 siswa bulan ini dengan streak
        $topStudents = Student::select('students.id', 'students.nama', 'students.kelas', DB::raw('COUNT(mutabaahs.id) as total_mutabaah'))
            ->leftJoin('mutabaahs', 'students.id', '=', 'mutabaahs.student_id')
            ->whereMonth('mutabaahs.tanggal', now()->month)
            ->whereYear('mutabaahs.tanggal', now()->year)
            ->groupBy('students.id', 'students.nama', 'students.kelas')
            ->orderBy('total_mutabaah', 'desc')
            ->limit(5)
            ->get()
            ->map(function($student) {
                $student->streak = $this->calculateStreak($student->id);
                return $student;
            });

        // Trend 30 hari terakhir (completion rate per hari)
        $trendData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = Mutabaah::whereDate('tanggal', $date)->count();
            $rate = $totalStudents > 0 ? round(($count / $totalStudents) * 100, 1) : 0;
            $trendData[] = [
                'date' => $date->format('d M'),
                'rate' => $rate
            ];
        }

        // Statistik per kelas
        $statsByClass = Student::select('kelas', DB::raw('COUNT(*) as total_students'))
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get()
            ->map(function($class) {
                $activeCount = Student::where('kelas', $class->kelas)
                    ->whereHas('mutabaah', function($q) {
                        $q->whereMonth('tanggal', now()->month)
                          ->whereYear('tanggal', now()->year);
                    })->count();
                $class->active_students = $activeCount;
                $class->completion_rate = $class->total_students > 0 
                    ? round(($activeCount / $class->total_students) * 100, 1) 
                    : 0;
                return $class;
            });

        return view('dashboard.admin', compact(
            'totalStudents',
            'totalTeachers',
            'todayMutabaah',
            'totalMutabaah',
            'inactiveStudents',
            'completionRate',
            'activeStudents',
            'avgPerStudent',
            'topStudents',
            'trendData',
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
        
        // Longest streak (rekor terbaik)
        $longestStreak = $this->calculateLongestStreak($student->id);

        // Progress ibadah (persentase dari hari dalam bulan)
        $daysInMonth = now()->daysInMonth;
        $progressPercentage = ($monthlyCount / $daysInMonth) * 100;

        // Calendar data bulan ini
        $calendarData = [];
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        
        for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
            $mutabaah = Mutabaah::where('student_id', $student->id)
                ->whereDate('tanggal', $date)
                ->first();
            
            $itemCount = $mutabaah ? count($mutabaah->data) : 0;
            
            // Color coding
            if ($itemCount >= 10) {
                $color = 'success'; // Hijau tua
            } elseif ($itemCount >= 5) {
                $color = 'warning'; // Kuning
            } elseif ($itemCount >= 1) {
                $color = 'orange'; // Orange
            } else {
                $color = 'secondary'; // Abu-abu
            }
            
            $calendarData[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('d'),
                'dayName' => $date->format('D'),
                'itemCount' => $itemCount,
                'color' => $color,
                'isFuture' => $date->isFuture(),
                'isToday' => $date->isToday(),
                'mutabaah' => $mutabaah
            ];
        }

        // Mutabaah terbaru
        $recentMutabaah = Mutabaah::where('student_id', $student->id)
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();
        
        // Achievement badges
        $badges = $this->calculateBadges($monthlyCount, $streak, $longestStreak);

        return view('dashboard.student', compact(
            'student',
            'monthlyCount',
            'streak',
            'longestStreak',
            'progressPercentage',
            'calendarData',
            'recentMutabaah',
            'badges'
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
    
    private function calculateLongestStreak($studentId)
    {
        $mutabaahs = Mutabaah::where('student_id', $studentId)
            ->orderBy('tanggal', 'asc')
            ->pluck('tanggal')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->toArray();
        
        if (empty($mutabaahs)) {
            return 0;
        }
        
        $longestStreak = 1;
        $currentStreak = 1;
        
        for ($i = 1; $i < count($mutabaahs); $i++) {
            $prevDate = Carbon::parse($mutabaahs[$i - 1]);
            $currDate = Carbon::parse($mutabaahs[$i]);
            
            if ($prevDate->addDay()->isSameDay($currDate)) {
                $currentStreak++;
                $longestStreak = max($longestStreak, $currentStreak);
            } else {
                $currentStreak = 1;
            }
        }
        
        return $longestStreak;
    }
    
    private function calculateBadges($monthlyCount, $streak, $longestStreak)
    {
        $badges = [];
        
        // Streak badges
        if ($longestStreak >= 100) {
            $badges[] = ['icon' => '👑', 'name' => 'Istiqomah Master', 'desc' => '100 hari berturut-turut'];
        } elseif ($longestStreak >= 30) {
            $badges[] = ['icon' => '⭐', 'name' => 'Konsisten Sebulan', 'desc' => '30 hari berturut-turut'];
        } elseif ($longestStreak >= 7) {
            $badges[] = ['icon' => '🔥', 'name' => 'Semangat Seminggu', 'desc' => '7 hari berturut-turut'];
        }
        
        // Monthly badges
        if ($monthlyCount >= now()->daysInMonth) {
            $badges[] = ['icon' => '💯', 'name' => 'Perfect Month', 'desc' => 'Lengkap sebulan penuh'];
        } elseif ($monthlyCount >= 25) {
            $badges[] = ['icon' => '🌟', 'name' => 'Rajin Banget', 'desc' => '25+ hari bulan ini'];
        } elseif ($monthlyCount >= 15) {
            $badges[] = ['icon' => '✨', 'name' => 'Terus Semangat', 'desc' => '15+ hari bulan ini'];
        }
        
        return $badges;
    }
}
