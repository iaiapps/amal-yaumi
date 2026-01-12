@extends('layouts.app')
@section('title', 'Kalender Mutabaah')
@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Kalender Mutabaah Per Siswa</h5>
            <div class="d-flex gap-2">
                <input type="month" id="monthPicker" class="form-control" value="{{ $month }}" onchange="changeMonth()">
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="alert alert-info">
                <strong>Periode:</strong> {{ $startDate->format('F Y') }}
                <span class="ms-3"><strong>Total Hari:</strong> {{ $daysInMonth }}</span>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th style="min-width: 200px;" class="py-1">Nama Siswa</th>
                            <th class="text-center py-1">Kelas</th>
                            @for ($i = 1; $i <= $daysInMonth; $i++)
                                @php
                                    $currentDate = $startDate->copy()->addDays($i - 1);
                                    $isWeekend = in_array($currentDate->dayOfWeek, [0, 7]);
                                    $isToday = $currentDate->isToday();
                                @endphp
                                <th class="text-center py-1 {{ $isWeekend ? 'bg-danger' : '' }} {{ $isToday ? 'bg-warning' : '' }}"
                                    style="min-width: 40px; font-size: 0.85rem;">
                                    {{ $i }}
                                    <small class="text-light">{{ $currentDate->format('D') }}</small>
                                </th>
                            @endfor
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr class="py-1">
                                <td>
                                    <a href="{{ route('mutabaah.student-calendar', ['student' => $student->id, 'month' => $month]) }}"
                                        class="text-decoration-none fw-bold">
                                        {{ $student->nama }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $student->kelas }}</td>
                                @php
                                    $mutabaahByDate = $student->mutabaah->keyBy(function ($item) {
                                        return $item->tanggal->format('Y-m-d');
                                    });
                                    $totalCount = 0;
                                @endphp
                                @for ($i = 1; $i <= $daysInMonth; $i++)
                                    @php
                                        $currentDate = $startDate->copy()->addDays($i - 1);
                                        $dateStr = $currentDate->format('Y-m-d');
                                        $mutabaah = $mutabaahByDate->get($dateStr);
                                        $itemCount = $mutabaah ? count($mutabaah->data) : 0;

                                        if ($itemCount > 0) {
                                            $totalCount++;
                                        }

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

                                        $isWeekend = in_array($currentDate->dayOfWeek, [0, 6]);
                                        $isToday = $currentDate->isToday();
                                        $isFuture = $currentDate->isFuture();
                                    @endphp
                                    <td class="text-center {{ $bgClass }} {{ $isToday ? 'border border-warning border-2' : '' }} mutabaah-cell"
                                        data-url="{{ $mutabaah ? route('mutabaah.show', $mutabaah->id) : '' }}"
                                        style="font-size: 1.2rem;"
                                        title="{{ $mutabaah ? $itemCount . ' item - ' . $currentDate->format('d M Y') : 'Tidak ada data' }}">
                                        {{ $icon }}
                                    </td>
                                @endfor
                                <td class="text-center fw-bold">
                                    <span class="badge bg-primary">{{ $totalCount }}/{{ $daysInMonth }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $daysInMonth + 3 }}" class="text-center">Belum ada data siswa</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <h6>Keterangan:</h6>
                <div class="d-flex gap-3 flex-wrap">
                    <span><span class="badge bg-success">✓</span> 10+ item</span>
                    <span><span class="badge bg-warning">○</span> 5-9 item</span>
                    <span><span class="badge bg-info">·</span> 1-4 item</span>
                    <span><span class="badge bg-light text-dark"></span> Belum ada data</span>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        function changeMonth() {
            const month = document.getElementById('monthPicker').value;
            window.location.href = "{{ route('mutabaah.calendar') }}?month=" + month;
        }

        document.querySelectorAll('.mutabaah-cell').forEach(cell => {
            const url = cell.getAttribute('data-url');
            if (url) {
                cell.style.cursor = 'pointer';
                cell.addEventListener('click', function() {
                    window.location.href = url;
                });
            }
        });
    </script>
@endpush

@push('css')
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .mutabaah-cell[data-url]:hover {
            transform: scale(1.1);
            transition: transform 0.2s;
        }
    </style>
@endpush
