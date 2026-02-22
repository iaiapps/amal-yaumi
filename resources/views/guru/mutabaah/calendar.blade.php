@extends('layouts.app')
@section('title', 'Kalender Mutabaah')
@section('content')

    @php
        use Carbon\Carbon;

        $monthDate = Carbon::parse($month . '-01');
        $monthStart = $monthDate->copy()->startOfMonth();
        $monthEnd = $monthDate->copy()->endOfMonth();

        $viewMode = $request->query('view', 'week');

        $weeks = [];
        $current = $monthStart->copy()->startOfWeek(Carbon::MONDAY);

        while ($current->lt($monthEnd) || $current->isSameWeek($monthEnd->copy()->endOfWeek(Carbon::SUNDAY))) {
            $weekStart = $current->copy();
            $weekEnd = $current->copy()->endOfWeek(Carbon::SUNDAY);

            if ($weekEnd->gt($monthEnd)) {
                $weekEnd = $monthEnd->copy();
            }

            $weekDays = [];
            for ($i = 0; $i < 7; $i++) {
                $day = $weekStart->copy()->addDays($i);
                if ($day->lte($monthEnd)) {
                    $weekDays[] = $day;
                }
            }

            $weeks[] = [
                'start' => $weekStart,
                'end' => $weekEnd,
                'days' => $weekDays,
            ];

            $current = $current->addWeek();
        }

        $today = Carbon::now();
        $currentWeekNum = null;

        foreach ($weeks as $index => $week) {
            if ($today->gte($week['start']) && $today->lte($week['end'])) {
                $currentWeekNum = $index;
                break;
            }
        }

        $selectedWeek = $request->query('week', $currentWeekNum);

        $daysInMonth = [];
        for ($i = 0; $i <= $monthStart->diffInDays($monthEnd); $i++) {
            $daysInMonth[] = $monthStart->copy()->addDays($i);
        }
    @endphp

    <div class="card">
        <div class="card-header px-3 pb-2">
            <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                @if (count($classes) > 1)
                    <select id="kelasFilter" class="form-select form-select-sm" onchange="applyKelas()" style="width: 140px;">
                        <option value="">Semua Kelas</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class }}" {{ $kelas == $class ? 'selected' : '' }}>{{ $class }}
                            </option>
                        @endforeach
                    </select>
                @endif

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('guru.mutabaah.calendar') }}?month={{ $monthDate->copy()->subMonth()->format('Y-m') }}{{ $kelas ? '&kelas=' . $kelas : '' }}&view={{ $viewMode }}"
                        class="btn btn-sm btn-outline-secondary">
                        <i class="ti ti-chevron-left"></i>
                    </a>
                    <span class="fw-bold">{{ $monthDate->format('F Y') }}</span>
                    <a href="{{ route('guru.mutabaah.calendar') }}?month={{ $monthDate->copy()->addMonth()->format('Y-m') }}{{ $kelas ? '&kelas=' . $kelas : '' }}&view={{ $viewMode }}"
                        class="btn btn-sm btn-outline-secondary">
                        <i class="ti ti-chevron-right"></i>
                    </a>
                </div>

                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn {{ $viewMode === 'week' ? 'btn-primary' : 'btn-outline-secondary' }}"
                        onclick="setView('week')">Mingguan</button>
                    <button type="button"
                        class="btn {{ $viewMode === 'month' ? 'btn-primary' : 'btn-outline-secondary' }}"
                        onclick="setView('month')">Bulanan</button>
                </div>
            </div>

            @if ($viewMode === 'week')
                <div class="mt-3 d-flex flex-wrap gap-1">
                    @foreach ($weeks as $index => $week)
                        <button type="button"
                            class="btn btn-sm {{ $selectedWeek == $index || ($selectedWeek === null && $index === count($weeks) - 1) ? 'btn-primary' : 'btn-outline-secondary' }}"
                            onclick="selectWeek({{ $index }})">
                            W{{ $index + 1 }}
                            <small>({{ $week['start']->format('d') }}-{{ $week['end']->format('d') }})</small>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="card-body p-0">
            @if (session('success'))
                <div class="alert alert-success m-3">{{ session('success') }}</div>
            @endif

            @php
                if ($viewMode === 'week') {
                    $displayWeekIndex = $selectedWeek !== null ? $selectedWeek : count($weeks) - 1;
                    $displayDays = $weeks[$displayWeekIndex]['days'] ?? [];
                } else {
                    $displayDays = $daysInMonth;
                }
            @endphp

            <div class="table-responsive px-3">
                <table class="table table-bordered table-hover table-sm mb-0">
                    <thead class="table-primary position-sticky top-0" style="z-index: 10;">
                        <tr>
                            <th class="py-1 px-2 bg-primary text-white" style="min-width: 100px; width: 100px;">
                                Siswa
                            </th>
                            @foreach ($displayDays as $day)
                                @php
                                    $isWeekend = in_array($day->dayOfWeek, [0, 7]);
                                    $isToday = $day->isToday();
                                @endphp
                                <th class="text-center py-1 px-1 {{ $isWeekend ? 'bg-danger text-white' : '' }} {{ $isToday ? 'bg-warning' : '' }}"
                                    style="min-width: 35px; font-size: 0.7rem; width: 35px;">
                                    <div>{{ $day->format('d') }}</div>
                                    <small class="{{ $isWeekend ? 'text-white' : '' }}">{{ $day->format('D') }}</small>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            @php
                                $mutabaahByDate = $student->mutabaah->keyBy(function ($item) {
                                    return $item->tanggal->format('Y-m-d');
                                });
                            @endphp
                            <tr>
                                <td class="py-1 px-2 table-light" style="min-width: 100px; width: 100px;">
                                    <a href="{{ route('guru.mutabaah.student-calendar', ['student' => $student->id, 'month' => $month]) }}"
                                        class="text-decoration-none fw-bold">
                                        {{ $student->nama }}
                                    </a>
                                </td>
                                @foreach ($displayDays as $day)
                                    @php
                                        $dateStr = $day->format('Y-m-d');
                                        $mutabaah = $mutabaahByDate->get($dateStr);
                                        $itemCount = $mutabaah ? count($mutabaah->data) : 0;

                                        if ($itemCount >= 10) {
                                            $bgClass = 'bg-success';
                                            $icon = '✓';
                                        } elseif ($itemCount >= 5) {
                                            $bgClass = 'bg-warning';
                                            $icon = '○';
                                        } elseif ($itemCount >= 1) {
                                            $bgClass = 'bg-info';
                                            $icon = '·';
                                        } else {
                                            $bgClass = 'bg-light';
                                            $icon = '';
                                        }

                                        $isWeekend = in_array($day->dayOfWeek, [0, 7]);
                                        $isToday = $day->isToday();
                                    @endphp
                                    <td class="text-center p-0 {{ $bgClass }} {{ $isToday ? 'border border-warning border-2' : '' }}"
                                        style="font-size: 0.85rem; width: 35px; min-width: 35px; max-width: 35px;"
                                        title="{{ $mutabaah ? $itemCount . ' item - ' . $day->format('d M Y') : 'Tidak ada data' }}">
                                        {{ $icon }}
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($displayDays) + 1 }}" class="text-center py-3">Belum ada data siswa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3 border-top">
                <div class="d-flex gap-3 flex-wrap small">
                    <span><span class="badge bg-success">✓</span> 10+ item</span>
                    <span><span class="badge bg-warning text-dark">○</span> 5-9 item</span>
                    <span><span class="badge bg-info">·</span> 1-4 item</span>
                    <span><span class="badge bg-light border text-dark">Kosong</span></span>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        function getBaseUrl() {
            return "{{ route('guru.mutabaah.calendar') }}";
        }

        function applyKelas() {
            const month = '{{ $month }}';
            const view = '{{ $viewMode }}';
            const kelas = document.getElementById('kelasFilter').value;
            let url = getBaseUrl() + '?month=' + month + '&view=' + view;
            if (kelas) url += '&kelas=' + kelas;
            window.location.href = url;
        }

        function setView(view) {
            const month = '{{ $month }}';
            const kelas = document.getElementById('kelasFilter')?.value || '';
            let url = getBaseUrl() + '?month=' + month + '&view=' + view;
            if (kelas) url += '&kelas=' + kelas;
            window.location.href = url;
        }

        function selectWeek(weekIndex) {
            const month = '{{ $month }}';
            const kelas = document.getElementById('kelasFilter')?.value || '';
            let url = getBaseUrl() + '?month=' + month + '&view=week&week=' + weekIndex;
            if (kelas) url += '&kelas=' + kelas;
            window.location.href = url;
        }
    </script>
@endpush

@push('css')
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .table-responsive {
            scrollbar-width: thin;
        }

        thead th {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        tbody th,
        tbody td:first-child {
            position: sticky;
            left: 0;
            z-index: 5;
        }

        thead th:first-child {
            z-index: 20;
        }

        @media (max-width: 992px) {
            .card-header {
                padding: 0.75rem 1rem;
            }

            .table {
                font-size: 0.75rem;
            }

            .table th,
            .table td {
                padding: 0.2rem 0.15rem;
            }

            .table th,
            .table td:first-child {
                min-width: 90px;
                width: 90px;
            }
        }

        @media (max-width: 768px) {
            .card-header {
                padding: 0.5rem 0.75rem;
            }

            .btn-group {
                display: flex;
                flex-wrap: wrap;
            }

            .btn-group-sm .btn {
                font-size: 0.7rem;
                padding: 0.25rem 0.4rem;
            }

            .form-select-sm,
            .form-control-sm {
                font-size: 0.75rem;
            }

            .table th,
            .table td {
                min-width: 30px;
                width: 30px;
                padding: 0.15rem 0.1rem;
                font-size: 0.7rem;
            }

            .table th,
            .table td:first-child {
                min-width: 80px;
                width: 80px;
                font-size: 0.75rem;
            }

            .table th div {
                font-size: 0.7rem;
            }

            .table th small {
                font-size: 0.55rem;
            }
        }

        @media (max-width: 576px) {
            .card-header .d-flex {
                gap: 0.5rem !important;
            }

            .btn-sm {
                font-size: 0.65rem;
                padding: 0.2rem 0.35rem;
            }

            .fw-bold {
                font-size: 0.85rem;
            }

            .table th,
            .table td:first-child {
                min-width: 70px;
                width: 70px;
            }
        }
    </style>
@endpush
