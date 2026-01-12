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
                <div class="card-body d-flex align-items-center">
                    <i class="ti ti-calendar-month" style="font-size: 2.5rem;"></i>
                    <div class="ms-3">
                        <h6 class="mb-0 text-white">Bulan Ini</h6>
                        <h2 class="mb-0 text-white">{{ $monthlyCount }}</h2>
                        <small class="text-white">dari {{ now()->daysInMonth }} hari</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body d-flex align-items-center">
                    <i class="ti ti-flame" style="font-size: 2.5rem;"></i>
                    <div class="ms-3">
                        <h6 class="mb-0 text-white">Streak</h6>
                        <h2 class="mb-0 text-white">{{ $streak }}</h2>
                        <small class="text-white">hari berturut-turut</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body d-flex align-items-center">
                    <i class="ti ti-trophy" style="font-size: 2.5rem;"></i>
                    <div class="ms-3">
                        <h6 class="mb-0 text-white">Rekor Terbaik</h6>
                        <h2 class="mb-0 text-white">{{ $longestStreak }}</h2>
                        <small class="text-white">hari berturut-turut</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body d-flex align-items-center">
                    <i class="ti ti-chart-pie" style="font-size: 2.5rem;"></i>
                    <div class="ms-3">
                        <h6 class="mb-0 text-white">Progress</h6>
                        <h2 class="mb-0 text-white">{{ number_format($progressPercentage, 0) }}%</h2>
                        <small class="text-white">bulan ini</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Calendar Mutabaah - {{ now()->format('F Y') }}</h5>
                    <div class="mt-2">
                        <span class="badge bg-success">Lengkap (10+)</span>
                        <span class="badge bg-warning">Sebagian (5-9)</span>
                        <span class="badge bg-danger">Sedikit (1-4)</span>
                        <span class="badge bg-secondary">Belum isi</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr><th>Sen</th><th>Sel</th><th>Rab</th><th>Kam</th><th>Jum</th><th>Sab</th><th>Min</th></tr>
                            </thead>
                            <tbody>
                                @php
                                    $firstDay = \Carbon\Carbon::parse($calendarData[0]['date'])->dayOfWeek;
                                    $offset = $firstDay == 0 ? 6 : $firstDay - 1;
                                @endphp
                                <tr>
                                    @for ($i = 0; $i < $offset; $i++) <td class="bg-light"></td> @endfor
                                    @foreach ($calendarData as $day)
                                        @php
                                            $currDay = \Carbon\Carbon::parse($day['date'])->dayOfWeek;
                                            $adjDay = $currDay == 0 ? 6 : $currDay - 1;
                                        @endphp
                                        @if (!$loop->first && $adjDay == 0) </tr><tr> @endif
                                        <td class="p-2 {{ $day['isToday'] ? 'border-primary border-3' : '' }}" style="min-width: 60px; height: 80px;">
                                            <div class="d-flex flex-column align-items-center">
                                                <small class="fw-bold">{{ $day['day'] }}</small>
                                                @if (!$day['isFuture'])
                                                    @if ($day['itemCount'] > 0)
                                                        <a href="{{ route('amal.show', $day['mutabaah']->id) }}" class="btn btn-{{ $day['color'] }} btn-sm rounded-circle mt-1" style="width: 30px; height: 30px; padding: 0; line-height: 30px;">
                                                            {{ $day['itemCount'] }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('amal.create', ['date' => $day['date']]) }}" class="btn btn-outline-secondary btn-sm rounded-circle mt-1" style="width: 30px; height: 30px; padding: 0; line-height: 30px;">
                                                            <i class="ti ti-plus"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    @endforeach
                                    @php
                                        $lastDay = \Carbon\Carbon::parse(end($calendarData)['date'])->dayOfWeek;
                                        $rem = $lastDay == 0 ? 0 : 7 - $lastDay;
                                    @endphp
                                    @for ($i = 0; $i < $rem; $i++) <td class="bg-light"></td> @endfor
                                </tr>
                            </tbody>
                        </table>
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
                                <tr><th>Tanggal</th><th>Total Item</th><th>Aksi</th></tr>
                            </thead>
                            <tbody>
                                @forelse($recentMutabaah as $m)
                                    <tr>
                                        <td>{{ $m->tanggal->format('d M Y') }}</td>
                                        <td><span class="badge bg-primary">{{ count($m->data) }} item</span></td>
                                        <td><a href="{{ route('amal.show', $m) }}" class="btn btn-sm btn-info">View</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center">Belum ada data</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
