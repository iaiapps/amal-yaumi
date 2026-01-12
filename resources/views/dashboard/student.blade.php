@extends('layouts.app')
@section('title', 'Dashboard Siswa')
@section('content')

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Selamat datang, {{ $student->nama }} - {{ $student->kelas }}
                            </h4>
                        </div>
                        <div>
                            <a href="{{ route('amal.create') }}" class="btn btn-primary btn-sm">
                                <i class="ti ti-plus"></i> Isi Mutabaah
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Achievement Badges --}}
    @if (count($badges) > 0)
        <div class="row mb-3">
            <div class="col-12">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="mb-3">Achievement Badges</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($badges as $badge)
                                <div class="badge bg-primary p-3" style="font-size: 1rem;">
                                    <span style="font-size: 1.5rem;">{{ $badge['icon'] }}</span>
                                    <strong>{{ $badge['name'] }}</strong>
                                    <br>
                                    <small>{{ $badge['desc'] }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-calendar-month" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white">Bulan Ini</h6>
                            <h2 class="mb-0 text-white">{{ $monthlyCount }}</h2>
                            <small class="text-white">dari {{ now()->daysInMonth }} hari</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-flame" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white">Streak Saat Ini</h6>
                            <h2 class="mb-0 text-white">{{ $streak }}</h2>
                            <small class="text-white">hari berturut-turut</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-trophy" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white">Rekor Terbaik</h6>
                            <h2 class="mb-0 text-white">{{ $longestStreak }}</h2>
                            <small class="text-white">hari berturut-turut</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-chart-pie" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white">Progress</h6>
                            <h2 class="mb-0 text-white">{{ number_format($progressPercentage, 0) }}%</h2>
                            <small class="text-white">bulan ini</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Calendar View --}}
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Calendar Mutabaah - {{ now()->format('F Y') }}</h5>
                    <br>
                    <div>
                        <span class="p-2 rounded me-1">Arti warna : </span>
                        <span class="badge bg-success p-2 rounded me-1 mb-1">Lengkap (10+)</span>
                        <span class="badge bg-warning p-2 rounded me-1 mb-1">Sebagian (5-9)</span>
                        <span class="badge bg-orange text-white p-2 rounded me-1 mb-1" style="background-color: #fd7e14;">
                            Sedikit
                            (1-4)</span>
                        <span class="badge bg-secondary p-2 rounded">Belum isi</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Sen</th>
                                    <th>Sel</th>
                                    <th>Rab</th>
                                    <th>Kam</th>
                                    <th>Jum</th>
                                    <th>Sab</th>
                                    <th>Min</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $weeks = collect($calendarData)->chunk(7);
                                    $firstDayOfWeek = \Carbon\Carbon::parse($calendarData[0]['date'])->dayOfWeek;
                                    // Adjust: Carbon's dayOfWeek (0=Sunday, 1=Monday, ..., 6=Saturday)
                                    // We want Monday=0, so adjust
                                    $offset = $firstDayOfWeek == 0 ? 6 : $firstDayOfWeek - 1;
                                @endphp

                                <tr>
                                    @for ($i = 0; $i < $offset; $i++)
                                        <td class="bg-light"></td>
                                    @endfor

                                    @foreach ($calendarData as $day)
                                        @php
                                            $dayOfWeek = \Carbon\Carbon::parse($day['date'])->dayOfWeek;
                                            $adjustedDay = $dayOfWeek == 0 ? 6 : $dayOfWeek - 1;
                                        @endphp

                                        @if ($loop->first == false && $adjustedDay == 0)
                                </tr>
                                <tr>
                                    @endif

                                    <td class="p-2 {{ $day['isToday'] ? 'border-primary border-3' : '' }}"
                                        style="min-width: 80px; height: 80px; {{ $day['isFuture'] ? 'background-color: #f8f9fa;' : '' }}">
                                        <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                            <strong class="mb-1 fs-4">{{ $day['day'] }}</strong>

                                            @if (!$day['isFuture'])
                                                @if ($day['itemCount'] > 0)
                                                    <a href="{{ route('amal.show', $day['mutabaah']->id) }}"
                                                        class="btn btn-{{ $day['color'] }} btn-sm rounded-circle"
                                                        style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;"
                                                        title="{{ $day['itemCount'] }} item">
                                                        <strong>{{ $day['itemCount'] }}</strong>
                                                    </a>
                                                @else
                                                    <a href="{{ route('amal.create') }}?date={{ $day['date'] }}"
                                                        class="btn btn-outline-secondary btn-sm rounded-circle"
                                                        style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;"
                                                        title="Belum isi">
                                                        <i class="ti ti-plus"></i>
                                                    </a>
                                                @endif
                                            @else
                                                <div class="text-muted" style="width: 30px; height: 30px;"></div>
                                            @endif
                                        </div>
                                    </td>
                                    @endforeach

                                    @php
                                        $lastDayOfWeek = \Carbon\Carbon::parse(
                                            $calendarData[count($calendarData) - 1]['date'],
                                        )->dayOfWeek;
                                        $adjustedLastDay = $lastDayOfWeek == 0 ? 6 : $lastDayOfWeek - 1;
                                        $remainingCells = 6 - $adjustedLastDay;
                                    @endphp

                                    @for ($i = 0; $i < $remainingCells; $i++)
                                        <td class="bg-light"></td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="ti ti-info-circle"></i>
                            Klik angka untuk lihat detail, klik <i class="ti ti-plus"></i> untuk isi mutabaah
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Mutabaah Terbaru</h5>
                    <a href="{{ route('amal.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Total Item</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentMutabaah as $m)
                                    <tr>
                                        <td>{{ $m->tanggal->format('d M Y') }}</td>
                                        <td><span class="badge bg-primary">{{ count($m->data) }} item</span></td>
                                        <td>
                                            <a href="{{ route('amal.show', $m) }}" class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada data mutabaah</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
