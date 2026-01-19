@extends('layouts.app')
@section('title', 'Dashboard Siswa')
@section('content')

    <!-- Hero Profile Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg overflow-hidden" 
                style="background: linear-gradient(135deg, #16595a 0%, #0a2e2f 100%);">
                <div class="card-body p-4 d-flex flex-column flex-md-row align-items-center justify-content-between text-white">
                    <div class="d-flex align-items-center mb-3 mb-md-0 w-100">
                        <div class="position-relative">
                            <div class="avtar avtar-lg bg-white bg-opacity-20 text-dark rounded-circle border border-white border-2">
                                <span class="fs-2">{{ substr($student->nama, 0, 1) }}</span>
                            </div>
                            {{-- <div class="position-absolute bottom-0 end-0 bg-warning text-dark fw-bold rounded-circle d-flex align-items-center justify-content-center" 
                                style="width: 28px; height: 28px; border: 2px solid #0a2e2f; font-size: 0.75rem;">
                                {{ $level }}
                            </div> --}}
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <h4 class="mb-0 text-white fw-bold">{{ $student->nama }}</h4>
                            <p class="mb-2 text-white text-opacity-75 small">Level {{ $level }} Mutabaah • {{ $student->kelas }}</p>
                            <div class="d-flex align-items-center">
                                <div class="progress bg-white bg-opacity-20 flex-grow-1 me-2" style="height: 6px; max-width: 150px;">
                                    <div class="progress-bar bg-warning" style="width: {{ $xpProgress }}%"></div>
                                </div>
                                <span class="small text-white text-opacity-75" style="font-size: 0.7rem;">{{ $totalPoints }} XP</span>
                            </div>
                        </div>
                        <div class="d-none d-md-block ms-auto">
                            <a href="{{ route('siswa.amal.create') }}" class="btn btn-warning fw-bold px-4">
                                <i class="ti ti-plus me-1"></i> Isi Mutabaah
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Action Button -->
        <div class="col-12 d-md-none mb-3">
            <a href="{{ route('siswa.amal.create') }}" class="btn btn-warning w-100 fw-bold py-2 shadow-sm">
                <i class="ti ti-plus me-1"></i> Isi Mutabaah Sekarang
            </a>
        </div>
    </div>

    <!-- Responsive Stats Cards (2x2 on mobile, 4x1 on desktop) -->
    <div class="row mb-2">
        <div class="col-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100 overflow-hidden bg-white">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="avtar avtar-sm bg-light-success text-success rounded-3 me-3">
                        <i class="ti ti-flame fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Streak</h6>
                        <h5 class="mb-0 fw-bold">{{ $streak }} Hari</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100 overflow-hidden bg-white">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="avtar avtar-sm bg-light-warning text-warning rounded-3 me-3">
                        <i class="ti ti-crown fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Terbaik</h6>
                        <h5 class="mb-0 fw-bold">{{ $longestStreak }} Hari</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100 overflow-hidden bg-white">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="avtar avtar-sm bg-light-info text-info rounded-3 me-3">
                        <i class="ti ti-calendar fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Bulan Ini</h6>
                        <h5 class="mb-0 fw-bold">{{ $monthlyCount }} / {{ now()->daysInMonth }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm h-100 overflow-hidden bg-white">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="avtar avtar-sm bg-light-primary text-primary rounded-3 me-3">
                        <i class="ti ti-trophy fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Peringkat</h6>
                        <h5 class="mb-0 fw-bold">#{{ $myRank }} <span class="text-muted small fw-normal">/{{ $totalInClass }}</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content: Calendar -->
        <div class="col-lg-8 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 pb-0 text-center">
                    <h5 class="fw-bold"><i class="ti ti-calendar-event me-1"></i> Kalender Mutabaah</h5>
                    <p class="text-muted small mb-0">{{ now()->format('F Y') }}</p>
                    <div class="mt-3 d-flex flex-wrap justify-content-center gap-2">
                        <span class="badge bg-light-success text-success" style="font-size: 0.65rem;">Lengkap (10+)</span>
                        <span class="badge bg-light-warning text-warning" style="font-size: 0.65rem;">Sering (5-9)</span>
                        <span class="badge bg-light-danger text-danger" style="font-size: 0.65rem;">Jarang (1-4)</span>
                        <span class="badge bg-light-secondary text-secondary" style="font-size: 0.65rem;">Belum isi</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center mb-0" style="table-layout: fixed;">
                            <thead>
                                <tr class="small text-muted border-0">
                                    <th class="border-0">Min</th><th class="border-0">Sen</th><th class="border-0">Sel</th>
                                    <th class="border-0">Rab</th><th class="border-0">Kam</th><th class="border-0">Jum</th>
                                    <th class="border-0">Sab</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $firstDay = \Carbon\Carbon::parse($calendarData[0]['date'])->dayOfWeek;
                                    $offset = $firstDay;
                                @endphp
                                <tr>
                                    @for ($i = 0; $i < $offset; $i++) <td class="bg-light border-0"></td> @endfor
                                    @foreach ($calendarData as $day)
                                        @php
                                            $currDay = \Carbon\Carbon::parse($day['date'])->dayOfWeek;
                                        @endphp
                                        @if (!$loop->first && $currDay == 0) </tr><tr> @endif
                                        <td class="p-1 border-0" style="height: 60px;">
                                            <div class="d-flex flex-column align-items-center justify-content-center h-100 rounded-2 {{ $day['isToday'] ? 'bg-light-primary border border-primary' : ( $day['itemCount'] > 0 ? 'bg-light-' . $day['color'] : 'bg-light' ) }}">
                                                @if (!$day['isFuture'])
                                                    @if ($day['itemCount'] > 0)
                                                        <a href="{{ route('siswa.amal.show', $day['mutabaah']->id) }}" class="text-decoration-none d-flex flex-column align-items-center justify-content-center w-100 h-100">
                                                            <small class="fw-bold text-dark" style="font-size: 0.75rem;">{{ $day['day'] }}</small>
                                                            <span class="text-{{ $day['color'] }} fw-bold" style="font-size: 0.7rem;">{{ $day['itemCount'] }}</span>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('siswa.amal.create', ['date' => $day['date']]) }}" class="text-decoration-none d-flex flex-column align-items-center justify-content-center w-100 h-100">
                                                            <small class="fw-bold text-dark" style="font-size: 0.75rem;">{{ $day['day'] }}</small>
                                                            <span class="text-muted" style="font-size: 0.6rem;"><i class="ti ti-plus"></i></span>
                                                        </a>
                                                    @endif
                                                @else
                                                    <small class="fw-bold text-muted" style="font-size: 0.75rem;">{{ $day['day'] }}</small>
                                                @endif
                                            </div>
                                        </td>
                                    @endforeach
                                    @php
                                        $lastDay = \Carbon\Carbon::parse(end($calendarData)['date'])->dayOfWeek;
                                        $rem = 6 - $lastDay;
                                    @endphp
                                    @for ($i = 0; $i < $rem; $i++) <td class="bg-light border-0"></td> @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Liga Kelas & Achievements -->
        <div class="col-lg-4">
            <!-- Liga Kelas Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                    <h6 class="mb-0 fw-bold text-primary"><i class="ti ti-chart-bar me-1"></i> Liga Kelas {{ $student->kelas }}</h6>
                    <small class="text-muted">Top 5 Berdasarkan pengisian mutabaah bulan Ini</small>
                </div>
                <div class="card-body px-4">
                    <div class="list-group list-group-flush">
                        @foreach($leaderboard as $index => $leader)
                            <div class="list-group-item px-0 py-3 border-0 border-bottom d-flex align-items-center {{ $leader->id == $student->id ? 'bg-light-primary rounded-3 px-2 mx--2' : '' }}">
                                <div class="me-3 fw-bold text-center" style="width: 25px;">
                                    @if($index == 0) <span class="text-warning">🥇</span>
                                    @elseif($index == 1) <span class="text-secondary">🥈</span>
                                    @elseif($index == 2) <span class="text-danger">🥉</span>
                                    @else <span class="text-muted">{{ $index + 1 }}</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold small {{ $leader->id == $student->id ? 'text-primary' : '' }}">
                                        {{ $leader->nama }} {!! $leader->id == $student->id ? '<span class="badge bg-primary ms-1" style="font-size:0.6rem">Kamu</span>' : '' !!}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.65rem;">{{ $leader->mutabaah_count }} hari terisi</div>
                                </div>
                                <div class="text-end">
                                    <div class="badge bg-light text-muted border" style="font-size: 0.65rem;">
                                        {{ round(($leader->mutabaah_count / now()->daysInMonth) * 100) }}%
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Achievement Badges Card -->
            @if (count($badges) > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                        <h6 class="mb-0 fw-bold text-success"><i class="ti ti-award me-1"></i> Lencana Kamu</h6>
                    </div>
                    <div class="card-body px-4">
                        <div class="d-flex flex-column gap-2">
                            @foreach ($badges as $badge)
                                <div class="d-flex align-items-center p-2 bg-light-success rounded-3 border border-success border-opacity-10">
                                    <span class="fs-4 me-3">{{ $badge['icon'] }}</span>
                                    <div>
                                        <div class="fw-bold small text-success">{{ $badge['name'] }}</div>
                                        <div class="text-muted" style="font-size: 0.65rem;">{{ $badge['desc'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Mini History Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="ti ti-history me-1"></i> Mutabaah Terakhir</h6>
                        <a href="{{ route('siswa.amal.index') }}" class="text-muted small text-decoration-none" style="font-size: 0.7rem;">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body px-4">
                    <div class="list-group list-group-flush">
                        @forelse($recentMutabaah->take(3) as $m)
                            <a href="{{ route('siswa.amal.show', $m) }}" class="list-group-item list-group-item-action px-0 py-2 border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-center small">
                                    <span>{{ $m->tanggal->format('d/m/y') }}</span>
                                    <span class="text-primary">{{ count($m->data) }} item</span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-3 text-muted small">Belum ada data</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('streak_milestone'))
                var duration = 3 * 1000;
                var animationEnd = Date.now() + duration;
                var defaults = {
                    startVelocity: 30,
                    spread: 360,
                    ticks: 60,
                    zIndex: 0,
                    particleCount: 50 // Subtle amount
                };

                function randomInRange(min, max) {
                    return Math.random() * (max - min) + min;
                }

                var interval = setInterval(function() {
                    var timeLeft = animationEnd - Date.now();

                    if (timeLeft <= 0) {
                        return clearInterval(interval);
                    }

                    var particleCount = 20 * (timeLeft / duration);
                    // since particles fall down, start a bit higher than random
                    confetti(Object.assign({}, defaults, {
                        particleCount,
                        origin: {
                            x: randomInRange(0.1, 0.3),
                            y: Math.random() - 0.2
                        }
                    }));
                    confetti(Object.assign({}, defaults, {
                        particleCount,
                        origin: {
                            x: randomInRange(0.7, 0.9),
                            y: Math.random() - 0.2
                        }
                    }));
                }, 250);
            @endif
        });
    </script>
@endpush
@endsection
