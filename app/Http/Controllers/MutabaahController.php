<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Mutabaah;
use App\Models\MutabaahItem;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MutabaahController extends Controller
{
    private function getTeacherId()
    {
        $user = Auth::user();
        if (! $user instanceof \App\Models\User) {
            return null;
        }
        $role = $user->getRoleNames()->first();
        if ($role !== 'guru') {
            return null;
        }

        return $user->teacher->id;
    }

    /**
     * Get items specifically for the teacher of the student
     */
    private function getItemsForStudent($student)
    {
        // Temukan kelas siswa
        $classroom = Classroom::where('nama', $student->kelas)->first();
        if (! $classroom || ! $classroom->teacher_id) {
            return collect();
        }

        // Temukan item mutabaah milik guru di kelas tersebut
        return MutabaahItem::where('teacher_id', $classroom->teacher_id)
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();
    }

    // Admin/Guru Methods
    public function index()
    {
        $teacherId = $this->getTeacherId();
        $mutabaahs = Mutabaah::with('student')
            ->when($teacherId, function ($q) use ($teacherId) {
                return $q->whereHas('student', function ($sq) use ($teacherId) {
                    $sq->whereIn('kelas', Classroom::where('teacher_id', $teacherId)->pluck('nama'));
                });
            })
            ->latest('tanggal')
            ->get();

        return view('guru.mutabaah.index', compact('mutabaahs'));
    }

    public function create(Request $request)
    {
        $teacherId = $this->getTeacherId();
        $students = Student::when($teacherId, function ($q) use ($teacherId) {
            return $q->whereIn('kelas', Classroom::where('teacher_id', $teacherId)->pluck('nama'));
        })->get();

        $items = MutabaahItem::when($teacherId, function ($q) use ($teacherId) {
            return $q->where('teacher_id', $teacherId);
        }, function ($q) {
            return $q->where('is_active', true);
        })->orderBy('urutan')->get();

        $defaultDate = $request->query('date', date('Y-m-d'));

        return view('guru.mutabaah.create', compact('students', 'items', 'defaultDate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'tanggal' => 'required|date',
            'data' => 'nullable|array',
        ]);

        $student = Student::find($request->student_id);
        $items = $this->getItemsForStudent($student);

        $data = [];
        foreach ($items as $item) {
            if (isset($request->data[$item->id])) {
                $data[$item->id] = $request->data[$item->id];
            } else {
                if ($item->tipe == 'ya_tidak') {
                    $data[$item->id] = 'Tidak';
                }
            }
        }

        $validated['data'] = $data;
        Mutabaah::create($validated);

        return redirect()->route('admin.mutabaah.index')->with('success', 'Berhasil menambah data');
    }

    public function show(Mutabaah $mutabaah)
    {
        $items = $this->getItemsForStudent($mutabaah->student);

        return view('guru.mutabaah.show', compact('mutabaah', 'items'));
    }

    public function edit(Mutabaah $mutabaah)
    {
        $students = Student::all();
        $items = $this->getItemsForStudent($mutabaah->student);

        return view('guru.mutabaah.edit', compact('mutabaah', 'students', 'items'));
    }

    public function update(Request $request, Mutabaah $mutabaah)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'tanggal' => 'required|date',
            'data' => 'required|array',
        ]);

        $mutabaah->update($validated);

        return redirect()->route('admin.mutabaah.index')->with('success', 'Berhasil update data');
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

        return view('siswa.mutabaah.index', compact('mutabaahs'));
    }

    public function amalCreate(Request $request)
    {
        $student = Auth::user()->student;
        $defaultDate = $request->query('date', now()->toDateString());

        $existing = Mutabaah::where('student_id', $student->id)
            ->whereDate('tanggal', $defaultDate)
            ->first();

        if ($existing) {
            return redirect()
                ->route('siswa.amal.edit', $existing)
                ->with('warning', 'Mutabaah tanggal ini sudah ada. Silakan edit data yang sudah dibuat.');
        }

        $items = $this->getItemsForStudent($student);

        return view('siswa.mutabaah.create', compact('items', 'defaultDate'));
    }

    public function amalStore(Request $request)
    {
        $student = Auth::user()->student;

        $validated = $request->validate([
            'tanggal' => [
                'required',
                'date',
                Rule::unique('mutabaahs', 'tanggal')->where(function ($query) use ($student) {
                    return $query->where('student_id', $student->id);
                }),
            ],
            'data' => 'nullable|array',
        ], [
            'tanggal.unique' => 'Mutabaah untuk tanggal ini sudah ada. Silakan edit data yang sudah dibuat.',
        ]);

        $items = $this->getItemsForStudent($student);

        $data = [];
        foreach ($items as $item) {
            if (isset($request->data[$item->id])) {
                $data[$item->id] = $request->data[$item->id];
            } else {
                if ($item->tipe == 'ya_tidak') {
                    $data[$item->id] = 'Tidak';
                }
            }
        }

        $validated['data'] = $data;
        $validated['student_id'] = $student->id;

        Mutabaah::create($validated);

        // Streak check for gamification
        $currentStreak = $student->getCurrentStreak();
        $milestones = [3, 7, 14, 30, 60, 90, 100, 365];

        if (in_array($currentStreak, $milestones)) {
            session()->flash('streak_milestone', $currentStreak);
        }

        return redirect()->route('home')->with('success', 'Berhasil menambah data mutabaah');
    }

    public function amalShow(Mutabaah $mutabaah)
    {
        $items = $this->getItemsForStudent($mutabaah->student);

        return view('siswa.mutabaah.show', compact('mutabaah', 'items'));
    }

    public function amalEdit(Mutabaah $mutabaah)
    {
        $student = Auth::user()->student;
        $items = $this->getItemsForStudent($student);

        return view('siswa.mutabaah.edit', compact('mutabaah', 'items'));
    }

    public function amalUpdate(Request $request, Mutabaah $mutabaah)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'data' => 'required|array',
        ]);

        $mutabaah->update($validated);

        return redirect()->route('siswa.amal.index')->with('success', 'Berhasil update data');
    }

    public function amalDestroy(Mutabaah $mutabaah)
    {
        $mutabaah->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }

    // Calendar Methods
    public function calendar(Request $request)
    {
        $teacherId = $this->getTeacherId();

        $month = $request->query('month', now()->format('Y-m'));
        $kelas = $request->query('kelas');
        $startDateParam = $request->query('start_date');
        $endDateParam = $request->query('end_date');
        $filter = $request->query('filter', 'month');

        $classes = [];
        if ($teacherId) {
            $classNames = Classroom::where('teacher_id', $teacherId)->pluck('nama')->unique()->values();
            $classes = $classNames->toArray();
        }

        $baseDate = \Carbon\Carbon::parse($month.'-01');

        if ($startDateParam && $endDateParam) {
            $startDate = \Carbon\Carbon::parse($startDateParam);
            $endDate = \Carbon\Carbon::parse($endDateParam);
            $month = $startDate->format('Y-m');
        } elseif ($filter === 'week') {
            $startDate = now()->startOfWeek(Carbon::MONDAY);
            $endDate = $startDate->copy()->endOfWeek(Carbon::SUNDAY);
        } elseif ($filter === '7days') {
            $startDate = now()->subDays(6)->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($filter === 'weekdays') {
            $startDate = now()->startOfWeek(Carbon::MONDAY);
            $endDate = now()->startOfWeek(Carbon::FRIDAY);
        } else {
            $startDate = $baseDate->copy()->startOfMonth();
            $endDate = $baseDate->copy()->endOfMonth();
        }

        $daysInRange = $startDate->diffInDays($endDate) + 1;

        $mutabaahQuery = function ($q) use ($month) {
            $q->whereYear('tanggal', date('Y', strtotime($month)))
                ->whereMonth('tanggal', date('m', strtotime($month)));
        };

        $students = Student::when($teacherId, function ($q) use ($teacherId) {
            return $q->whereIn('kelas', Classroom::where('teacher_id', $teacherId)->pluck('nama'));
        })->when($kelas, function ($q) use ($kelas) {
            return $q->where('kelas', $kelas);
        })->with([
            'mutabaah' => $mutabaahQuery,
        ])->orderBy('kelas')->orderBy('nama')->get();

        return view('guru.mutabaah.calendar', compact('students', 'month', 'startDate', 'endDate', 'daysInRange', 'classes', 'kelas', 'request'));
    }

    public function studentCalendar(Student $student, Request $request)
    {
        $teacherId = $this->getTeacherId();
        if ($teacherId) {
            $myClassNames = Classroom::where('teacher_id', $teacherId)->pluck('nama')->toArray();
            if (! in_array($student->kelas, $myClassNames)) {
                abort(403, 'Anda tidak memiliki akses ke data siswa ini.');
            }
        }

        $month = $request->query('month', now()->format('Y-m'));
        $startDate = \Carbon\Carbon::parse($month.'-01');
        $endDate = $startDate->copy()->endOfMonth();

        $mutabaahs = Mutabaah::where('student_id', $student->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get()
            ->keyBy(function ($item) {
                return $item->tanggal->format('Y-m-d');
            });

        $items = $this->getItemsForStudent($student);
        $calendarData = [];

        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $mutabaah = $mutabaahs->get($dateStr);

            $calendarData[] = [
                'date' => $dateStr,
                'day' => $date->format('d'),
                'dayName' => $date->format('D'),
                'mutabaah' => $mutabaah,
                'itemCount' => $mutabaah ? count($mutabaah->data) : 0,
                'isFuture' => $date->isFuture(),
                'isToday' => $date->isToday(),
            ];
        }

        // dd('coba');
        return view('guru.mutabaah.student-calendar', compact('student', 'month', 'calendarData', 'items', 'startDate'));
    }
}
