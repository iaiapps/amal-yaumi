@extends('layouts.app')
@section('title', 'Tambah Mutabaah')
@section('content')

    @php
        $user = Auth::user();
        $role = $user->getRoleNames()->first();
        $url = $role == 'siswa' ? route('siswa.amal.store') : route('mutabaah.store');
    @endphp

    <div class="card">
        <div class="card-body">
            <form action="{{ $url }}" method="POST" id="mutabaahForm">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ old('tanggal', $defaultDate ?? date('Y-m-d')) }}" required>
                </div>

                @if ($role == 'admin')
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                        <select name="student_id" class="form-select" required>
                            <option value="">Pilih Siswa</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->nama }} - {{ $student->kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- Progress Bar --}}
                <div class="card mb-3 bg-light border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-chart-line me-1"></i> Progress Pengisian</h6>
                            <span class="badge bg-primary" id="progressBadge">0/{{ $items->count() }}</span>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated shadow-sm" id="progressBar"
                                role="progressbar" style="width: 0%">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Entry Buttons --}}
                <div class="d-flex justify-content-end mb-3">
                    <div class="btn-group btn-group-sm shadow-sm">
                        <button type="button" class="btn btn-outline-primary" onclick="checkAllYa()">
                            <i class="ti ti-check me-1"></i> Centang Semua
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="resetForm()">
                            <i class="ti ti-refresh me-1"></i> Reset
                        </button>
                    </div>
                </div>

                @php
                    $colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
                    $colorIndex = 0;
                @endphp

                @foreach ($items->groupBy('kategori') as $kategori => $groupItems)
                    @php
                        $currentColor = $colors[$colorIndex % count($colors)];
                        $colorIndex++;
                        // Convert slug to Title Case
                        $displayKategori = ucwords(str_replace(['_', '-'], ' ', $kategori));
                    @endphp
                    <div class="card mb-4 shadow-sm border-0 border-top border-4 border-{{ $currentColor }}">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-{{ $currentColor }}">
                                    <i class="ti ti-bookmark me-1"></i> {{ $displayKategori }}
                                </h6>
                                <span class="badge bg-light-{{ $currentColor }} text-{{ $currentColor }} category-counter px-3" data-category="{{ $kategori }}">
                                    0/{{ $groupItems->count() }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @foreach ($groupItems as $item)
                                    @if ($item->tipe == 'ya_tidak')
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-check form-check-lg habit-check">
                                                <input type="checkbox" class="form-check-input habit-checkbox"
                                                    id="item_{{ $item->id }}" name="data[{{ $item->id }}]"
                                                    value="Ya" data-category="{{ $kategori }}"
                                                    onchange="updateProgress()">
                                                <label class="form-check-label" for="item_{{ $item->id }}">
                                                    {{ $item->nama }}
                                                </label>
                                            </div>
                                        </div>
                                    @elseif($item->tipe == 'angka')
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small">
                                                {{ $item->nama }}
                                            </label>
                                            <input type="number" name="data[{{ $item->id }}]"
                                                class="form-control habit-input"
                                                placeholder="Masukkan angka" data-category="{{ $kategori }}"
                                                onchange="updateProgress()">
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small">
                                                {{ $item->nama }}
                                            </label>
                                            <input type="text" name="data[{{ $item->id }}]"
                                                class="form-control habit-input" placeholder="Masukkan text"
                                                data-category="{{ $kategori }}" onchange="updateProgress()">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach


                <div class="card mt-4 border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Mutabaah
                            </button>
                            <a href="{{ $role == 'siswa' ? route('siswa.amal.index') : route('mutabaah.index') }}"
                                class="btn btn-light px-4 py-2">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        const totalItems = {{ $items->count() }};
        let celebrationTriggered = false;

        function updateProgress() {
            // Count checked checkboxes
            const checkedBoxes = document.querySelectorAll('.habit-checkbox:checked').length;

            // Count filled inputs
            const filledInputs = Array.from(document.querySelectorAll('.habit-input')).filter(input => input.value
                .trim() !== '').length;

            const completed = checkedBoxes + filledInputs;
            const percentage = Math.round((completed / totalItems) * 100);

            // Update progress bar
            const progressBar = document.getElementById('progressBar');
            progressBar.style.width = percentage + '%';
            document.getElementById('progressBadge').textContent = completed + '/' + totalItems;

            // Update category counters
            updateCategoryCounters();

            // Celebration if all complete (only trigger once)
            if (completed === totalItems && !celebrationTriggered) {
                celebrateCompletion();
                celebrationTriggered = true;
            } else if (completed < totalItems) {
                celebrationTriggered = false;
                resetCelebrationStyle();
            }
        }

        function updateCategoryCounters() {
            const categories = {!! json_encode($items->pluck('kategori')->unique()->values()) !!};

            categories.forEach(category => {
                const checkboxes = document.querySelectorAll(`.habit-checkbox[data-category="${category}"]`);
                const inputs = document.querySelectorAll(`.habit-input[data-category="${category}"]`);

                const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
                const filledCount = Array.from(inputs).filter(input => input.value.trim() !== '').length;

                const total = checkboxes.length + inputs.length;
                const completed = checkedCount + filledCount;

                const counter = document.querySelector(`.category-counter[data-category="${category}"]`);
                if (counter) {
                    counter.textContent = completed + '/' + total;
                    if (completed === total) {
                        counter.classList.remove('bg-light-primary', 'bg-light-success', 'bg-light-info', 'bg-light-warning', 'bg-light-danger', 'bg-light-secondary');
                        counter.classList.add('bg-success', 'text-white');
                    } else {
                        // Restore dynamic color if no longer complete
                        // (CSS will handle the text color via the specific category class if we don't force bg-success)
                    }
                }
            });
        }

        function checkAllYa() {
            document.querySelectorAll('.habit-checkbox').forEach(checkbox => {
                checkbox.checked = true;
            });
            updateProgress();
        }

        function resetForm() {
            document.getElementById('mutabaahForm').reset();
            document.querySelector('input[name="tanggal"]').value = '{{ $defaultDate ?? date('Y-m-d') }}';
            updateProgress();
        }

        function celebrateCompletion() {
            // Subtle side bursts confetti
            var count = 200;
            var defaults = {
                origin: { y: 0.7 }
            };

            function fire(particleRatio, opts) {
                confetti(Object.assign({}, defaults, opts, {
                    particleCount: Math.floor(count * particleRatio)
                }));
            }

            fire(0.25, {
                spread: 26,
                startVelocity: 55,
            });
            fire(0.2, {
                spread: 60,
            });
            fire(0.35, {
                spread: 100,
                decay: 0.91,
                scalar: 0.8
            });
            fire(0.1, {
                spread: 120,
                startVelocity: 25,
                decay: 0.92,
                scalar: 1.2
            });
            fire(0.1, {
                spread: 120,
                startVelocity: 45,
            });

            // Change progress bar color
            const progressBar = document.getElementById('progressBar');
            progressBar.classList.remove('progress-bar-striped', 'progress-bar-animated');
            progressBar.classList.add('bg-success');

            // Show celebration message
            const badge = document.getElementById('progressBadge');
            badge.classList.remove('bg-primary');
            badge.classList.add('bg-success');
            badge.innerHTML = '<i class="ti ti-check"></i> Sempurna!';
        }

        function resetCelebrationStyle() {
            const progressBar = document.getElementById('progressBar');
            progressBar.classList.add('progress-bar-striped', 'progress-bar-animated');
            progressBar.classList.remove('bg-success');

            const badge = document.getElementById('progressBadge');
            badge.classList.remove('bg-success');
            badge.classList.add('bg-primary');
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateProgress();
        });
    </script>
@endpush

@push('css')
    <style>
        .habit-check {
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: #fff;
        }

        .habit-check:hover {
            border-color: #4680FF;
            background: #f8f9fa;
        }

        .habit-check .form-check-input {
            width: 24px;
            height: 24px;
            margin-top: 0;
            cursor: pointer;
        }

        .habit-check .form-check-input:checked {
            background-color: #2CA87F;
            border-color: #2CA87F;
        }

        .habit-check .form-check-input:checked~.form-check-label {
            color: #2CA87F;
            font-weight: 600;
        }

        .habit-check .form-check-label {
            cursor: pointer;
            margin-left: 8px;
            font-size: 1rem;
        }

        .habit-input {
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .habit-input:focus {
            border-color: #4680FF;
            box-shadow: 0 0 0 0.2rem rgba(70, 128, 255, 0.25);
        }

        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            border: none;
            padding: 16px 20px;
        }

        .category-counter {
            font-size: 0.875rem;
            padding: 4px 12px;
        }

        .progress {
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            transition: width 0.5s ease;
        }

        /* Animation for checkbox */
        @keyframes checkmark {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .habit-check .form-check-input:checked {
            animation: checkmark 0.3s ease-in-out;
        }
    </style>
@endpush
