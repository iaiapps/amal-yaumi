<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Mutabaah;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        // Statistik Global (Original)
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClassrooms = Classroom::count();
        $todayMutabaah = Mutabaah::whereDate('tanggal', today())->count();
        $totalMutabaah = Mutabaah::count();

        // Siswa tidak aktif (Original)
        $inactiveStudents = Student::whereDoesntHave('mutabaah', function ($q) {
            $q->whereBetween('tanggal', [now()->subDays(3), now()]);
        })->limit(10)->get();

        // Completion rate bulan ini (Original)
        $daysInMonth = now()->day;
        $expectedEntries = $totalStudents * $daysInMonth;
        $actualEntries = Mutabaah::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
        $completionRate = $expectedEntries > 0 ? round(($actualEntries / $expectedEntries) * 100, 1) : 0;

        // Siswa aktif bulan ini (Original)
        $activeStudents = Student::whereHas('mutabaah', function ($q) {
            $q->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year);
        })->count();

        $avgPerStudent = $totalStudents > 0 ? round($actualEntries / $totalStudents, 1) : 0;

        // Top 5 siswa (Original)
        $topStudents = Student::select('students.id', 'students.nama', 'students.kelas', DB::raw('COUNT(mutabaahs.id) as total_mutabaah'))
            ->leftJoin('mutabaahs', 'students.id', '=', 'mutabaahs.student_id')
            ->whereMonth('mutabaahs.tanggal', now()->month)
            ->whereYear('mutabaahs.tanggal', now()->year)
            ->groupBy('students.id', 'students.nama', 'students.kelas')
            ->orderBy('total_mutabaah', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($student) {
                $student->streak = $this->calculateStreak($student->id);
                return $student;
            });

        // Trend 30 hari (Original)
        $trendData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = Mutabaah::whereDate('tanggal', $date)->count();
            $rate = $totalStudents > 0 ? round(($count / $totalStudents) * 100, 1) : 0;
            $trendData[] = ['date' => $date->format('d M'), 'rate' => $rate];
        }

        // Statistik per kelas (Original)
        $statsByClass = Student::select('kelas', DB::raw('COUNT(*) as total_students'))
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get()
            ->map(function ($class) {
                $activeCount = Student::where('kelas', $class->kelas)
                    ->whereHas('mutabaah', function ($q) {
                        $q->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year);
                    })->count();
                $class->active_students = $activeCount;
                $class->completion_rate = $class->total_students > 0 ? round(($activeCount / $class->total_students) * 100, 1) : 0;
                return $class;
            });

        // Data Monitoring Guru (New Requirement)
        $teachersList = Teacher::withCount(['classrooms', 'students'])->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalClassrooms',
            'todayMutabaah',
            'totalMutabaah',
            'inactiveStudents',
            'completionRate',
            'activeStudents',
            'avgPerStudent',
            'topStudents',
            'trendData',
            'statsByClass',
            'teachersList'
        ));
    }

    public function guru()
    {
        $user = Auth::user();
        if (!$user instanceof User)
            abort(401);

        $teacher = $user->teacher;
        if (!$teacher)
            abort(403, 'Profil guru tidak ditemukan.');

        $classrooms = Classroom::where('teacher_id', $teacher->id)->withCount('students')->get();
        $totalStudents = $classrooms->sum('students_count');

        $classNames = $classrooms->pluck('nama')->toArray();
        $todayMutabaah = Mutabaah::whereIn('student_id', function ($query) use ($classNames) {
            $query->select('id')->from('students')->whereIn('kelas', $classNames);
        })->whereDate('tanggal', today())->count();

        $classStats = $classrooms->map(function ($class) {
            $activeCount = Student::where('kelas', $class->nama)
                ->whereHas('mutabaah', function ($q) {
                    $q->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year);
                })->count();
            $class->active_students = $activeCount;
            $class->completion_rate = $class->students_count > 0 ? round(($activeCount / $class->students_count) * 100, 1) : 0;
            return $class;
        });

        // Trends for last 14 days
        $trendData = [];
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('d/m/y');
            $count = Mutabaah::whereIn('student_id', function ($query) use ($teacher) {
                $query->select('id')->from('students')->where('teacher_id', $teacher->id);
            })->whereDate('tanggal', $date)->count();

            $trendData[] = [
                'date' => $date,
                'count' => $count,
                'rate' => $totalStudents > 0 ? round(($count / $totalStudents) * 100) : 0
            ];
        }

        // Recent Activities
        $recentActivities = Mutabaah::whereIn('student_id', function ($query) use ($teacher) {
            $query->select('id')->from('students')->where('teacher_id', $teacher->id);
        })
            ->with(['student.user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Inactive Students (No mutabaah in last 3 days)
        $inactiveStudents = Student::where('teacher_id', $teacher->id)
            ->whereDoesntHave('mutabaah', function ($q) {
                $q->whereDate('tanggal', '>=', now()->subDays(3));
            })
            ->with('user')
            ->limit(5)
            ->get();

        // Submission Rate Today
        $submissionRateToday = $totalStudents > 0 ? round(($todayMutabaah / $totalStudents) * 100) : 0;

        // Total entries current month
        $monthlyTotal = Mutabaah::whereIn('student_id', function ($query) use ($teacher) {
            $query->select('id')->from('students')->where('teacher_id', $teacher->id);
        })
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        // Top Students (by completion in current month)
        $topStudents = Student::where('teacher_id', $teacher->id)
            ->with(['user'])
            ->withCount([
                'mutabaah' => function ($q) {
                    $q->whereMonth('tanggal', now()->month)
                        ->whereYear('tanggal', now()->year);
                }
            ])
            ->orderByDesc('mutabaah_count')
            ->limit(5)
            ->get()
            ->map(function ($student) {
                $student->streak = $this->calculateStreak($student->id);
                return $student;
            });
        return view('guru.dashboard', compact(
            'teacher',
            'classrooms',
            'totalStudents',
            'todayMutabaah',
            'classStats',
            'trendData',
            'recentActivities',
            'topStudents',
            'inactiveStudents',
            'submissionRateToday',
            'monthlyTotal'
        ));
    }

    public function student()
    {
        $user = Auth::user();
        if (!$user instanceof User)
            abort(401);

        $student = $user->student;
        if (!$student)
            abort(403, 'Profil siswa tidak ditemukan.');

        $monthlyCount = Mutabaah::where('student_id', $student->id)->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->count();
        $streak = $this->calculateStreak($student->id);
        $longestStreak = $this->calculateLongestStreak($student->id);
        $daysInMonth = now()->daysInMonth;
        $progressPercentage = ($monthlyCount / $daysInMonth) * 100;

        $calendarData = [];
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
            $mutabaah = Mutabaah::where('student_id', $student->id)->whereDate('tanggal', $date)->first();
            $itemCount = $mutabaah ? count($mutabaah->data) : 0;

            if ($itemCount >= 10)
                $color = 'success';
            elseif ($itemCount >= 5)
                $color = 'warning';
            elseif ($itemCount >= 1)
                $color = 'orange';
            else
                $color = 'secondary';

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

        $recentMutabaah = Mutabaah::where('student_id', $student->id)->orderBy('tanggal', 'desc')->limit(5)->get();

        // Gamification: Total Points (10 pts per item)
        $allMutabaah = Mutabaah::where('student_id', $student->id)->get();
        $totalPoints = 0;
        foreach ($allMutabaah as $m) {
            $totalPoints += count($m->data) * 10;
        }

        // Gamification: Class Rank (based on monthly completion)
        $classRank = Student::where('kelas', $student->kelas)
            ->withCount([
                'mutabaah' => function ($q) {
                    $q->whereMonth('tanggal', now()->month)
                        ->whereYear('tanggal', now()->year);
                }
            ])
            ->get()
            ->sortByDesc('mutabaah_count')
            ->values();

        $myRank = $classRank->search(fn($s) => $s->id === $student->id) + 1;
        $totalInClass = $classRank->count();

        // Take top 5 for leaderboard display
        $leaderboard = $classRank->take(5);

        // Simulated Level (e.g., Level 1 every 500 points)
        $level = floor($totalPoints / 500) + 1;
        $xpProgress = ($totalPoints % 500) / 5; // Percentage to next level

        $badges = $this->calculateBadges($monthlyCount, $streak, $longestStreak);

        return view('siswa.dashboard', compact(
            'student',
            'monthlyCount',
            'streak',
            'longestStreak',
            'progressPercentage',
            'calendarData',
            'recentMutabaah',
            'badges',
            'totalPoints',
            'myRank',
            'totalInClass',
            'leaderboard',
            'level',
            'xpProgress'
        ));
    }

    private function calculateStreak($studentId)
    {
        $streak = 0;
        $date = Carbon::today();
        while (true) {
            $exists = Mutabaah::where('student_id', $studentId)->whereDate('tanggal', $date)->exists();
            if (!$exists)
                break;
            $streak++;
            $date->subDay();
        }
        return $streak;
    }

    private function calculateLongestStreak($studentId)
    {
        $mutabaahs = Mutabaah::where('student_id', $studentId)->orderBy('tanggal', 'asc')->pluck('tanggal')->map(fn($date) => $date->format('Y-m-d'))->toArray();
        if (empty($mutabaahs))
            return 0;
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
        if ($longestStreak >= 100)
            $badges[] = ['icon' => '👑', 'name' => 'Istiqomah Master', 'desc' => '100 hari berturut-turut'];
        elseif ($longestStreak >= 30)
            $badges[] = ['icon' => '⭐', 'name' => 'Konsisten Sebulan', 'desc' => '30 hari berturut-turut'];
        elseif ($longestStreak >= 7)
            $badges[] = ['icon' => '🔥', 'name' => 'Semangat Seminggu', 'desc' => '7 hari berturut-turut'];

        if ($monthlyCount >= now()->daysInMonth)
            $badges[] = ['icon' => '💯', 'name' => 'Perfect Month', 'desc' => 'Lengkap sebulan penuh'];
        elseif ($monthlyCount >= 25)
            $badges[] = ['icon' => '🌟', 'name' => 'Rajin Banget', 'desc' => '25+ hari bulan ini'];
        elseif ($monthlyCount >= 15)
            $badges[] = ['icon' => '✨', 'name' => 'Terus Semangat', 'desc' => '15+ hari bulan ini'];
        return $badges;
    }
}
