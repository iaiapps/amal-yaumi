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
        // 1. Total Stats
        $totalUsers = User::count();
        $totalTeachers = User::role('guru')->count();
        $totalStudents = User::role('siswa')->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // 2. User Growth Trend (Last 6 Months)
        $growthLabels = [];
        $growthValues = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = User::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $growthLabels[] = $month->format('M Y');
            $growthValues[] = $count;
        }

        // 3. Role Distribution
        $roleCounts = [
            User::role('admin')->count(),
            $totalTeachers,
            $totalStudents
        ];

        // 4. Active Teachers (Based on students assigned)
        $activeTeachers = Teacher::has('students')->withCount('students')->orderByDesc('students_count')->limit(5)->get();

        // 5. Recent Users
        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTeachers',
            'totalStudents',
            'newUsersThisMonth',
            'growthLabels',
            'growthValues',
            'roleCounts',
            'activeTeachers',
            'recentUsers'
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
                $student->streak = $student->getCurrentStreak();
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
        $streak = $student->getCurrentStreak();
        $longestStreak = $student->getLongestStreak();
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

        $badges = $student->getBadges();

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
}
