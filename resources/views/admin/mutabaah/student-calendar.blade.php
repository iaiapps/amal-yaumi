@extends('layouts.app')
@section('title', 'Kalender Mutabaah - ' . $student->nama)
@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Kalender Mutabaah - {{ $student->nama }}</h5>
                <small class="text-muted">Kelas: {{ $student->kelas }}</small>
            </div>
            <div class="d-flex gap-2">
                <input type="month" id="monthPicker" class="form-control" value="{{ $month }}" onchange="changeMonth()">
                <a href="{{ route('mutabaah.calendar', ['month' => $month]) }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-info mb-4">
                <strong>Periode:</strong> {{ $startDate->format('F Y') }}
            </div>

            <div class="row g-3">
                @foreach ($calendarData as $day)
                    @php
                        $mutabaah = $day['mutabaah'];
                        $itemCount = $day['itemCount'];

                        if ($itemCount >= 10) {
                            $cardClass = 'border-success';
                            $badgeClass = 'bg-success';
                        } elseif ($itemCount >= 5) {
                            $cardClass = 'border-warning';
                            $badgeClass = 'bg-warning';
                        } elseif ($itemCount >= 1) {
                            $cardClass = 'border-info';
                            $badgeClass = 'bg-info';
                        } else {
                            $cardClass = 'border-light';
                            $badgeClass = 'bg-light text-dark';
                        }
                    @endphp

                    <div class="col-md-4 col-lg-3">
                        <div class="card shadow h-100 {{ $cardClass }} {{ $day['isToday'] ? 'border-3' : '' }}">
                            <div
                                class="card-header py-3 {{ $badgeClass }} text-light d-flex justify-content-between align-items-center">
                                <strong>{{ $day['day'] }} {{ $startDate->format('M') }}</strong>
                                <small>{{ $day['dayName'] }}</small>
                            </div>
                            <div class="card-body p-3">
                                @if ($mutabaah)
                                    <div class="mb-2">
                                        <span class="badge {{ $badgeClass }}">{{ $itemCount }} item tercatat</span>
                                    </div>

                                    @foreach ($items->groupBy('kategori') as $kategori => $groupItems)
                                        <div class="mb-1">
                                            <small class="fw-bold">
                                                @if ($kategori == 'sholat_wajib')
                                                    Sholat Wajib
                                                @elseif($kategori == 'sholat_sunnah')
                                                    Sholat Sunnah
                                                @else
                                                    Lainnya
                                                @endif
                                            </small>
                                            <ul class="list-unstyled ms-2 small mb-1">
                                                @foreach ($groupItems as $item)
                                                    @php
                                                        $value = $mutabaah->data[$item->id] ?? null;
                                                    @endphp
                                                    @if ($value)
                                                        <li>
                                                            @if ($value == 'Ya')
                                                                <span class="text-success">✓</span>
                                                            @elseif($value == 'Tidak')
                                                                <span class="text-secondary">✗</span>
                                                            @else
                                                                <span class="text-primary">•</span>
                                                            @endif
                                                            {{ $item->nama }}
                                                            @if ($value != 'Ya' && $value != 'Tidak')
                                                                : {{ $value }}
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach

                                    <div class="d-flex gap-1 mt-2">
                                        <a href="{{ route('mutabaah.show', $mutabaah->id) }}" class="btn btn-sm btn-info">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('mutabaah.edit', $mutabaah->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                    </div>
                                @else
                                    <p class="text-muted small mb-2">Belum ada data</p>
                                    @if (!$day['isFuture'])
                                        <a href="{{ route('mutabaah.create', ['date' => $day['date']]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="ti ti-plus"></i> Tambah
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        function changeMonth() {
            const month = document.getElementById('monthPicker').value;
            window.location.href = "{{ route('mutabaah.student-calendar', $student->id) }}?month=" + month;
        }
    </script>
@endpush
