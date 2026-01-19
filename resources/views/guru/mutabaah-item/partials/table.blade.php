<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="80">Urutan</th>
                @if($showGuru)
                <th>Guru Pembimbing</th>
                @endif
                <th>Nama Item</th>
                <th>Kategori</th>
                <th>Tipe Input</th>
                <th>Status</th>
                @if($role == 'guru' && !$showGuru)
                <th width="150" class="text-center">Aksi</th>
                @elseif($role == 'admin' && !$showGuru)
                <th width="150" class="text-center">Aksi Template</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>
                    <span class="badge bg-light-secondary text-secondary w-100">{{ $item->urutan }}</span>
                </td>
                @if($showGuru)
                <td>
                    @if($item->teacher)
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2 bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                {{ substr($item->teacher->nama, 0, 1) }}
                            </div>
                            <span>{{ $item->teacher->nama }}</span>
                        </div>
                    @else
                        <span class="badge bg-light-info text-info">Sistem (Master)</span>
                    @endif
                </td>
                @endif
                <td>
                    <div class="fw-bold">{{ $item->nama }}</div>
                </td>
                <td>
                    @php
                        $displayKategori = ucwords(str_replace(['_', '-'], ' ', $item->kategori));
                        $badgeColor = match($item->kategori) {
                            'sholat_fardhu' => 'primary',
                            'sholat_sunnah' => 'success',
                            'interaksi_al_quran' => 'info',
                            'dzikir_spiritual' => 'warning',
                            'adab_karakter' => 'danger',
                            'kemandirian_sosial' => 'dark',
                            default => 'secondary'
                        };
                    @endphp
                    <span class="badge bg-{{ $badgeColor }}">{{ $displayKategori }}</span>
                </td>
                <td>
                    <span class="text-muted small">
                        <i class="ti ti-{{ $item->tipe == 'ya_tidak' ? 'checkbox' : ($item->tipe == 'angka' ? 'hash' : 'penci') }}"></i>
                        {{ ucfirst(str_replace('_', '/', $item->tipe)) }}
                    </span>
                </td>
                <td>
                    @if($role == 'guru' && $item->teacher_id == Auth::user()->teacher->id)
                    <form action="{{ route('guru.mutabaah-item.toggle', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-{{ $item->is_active ? 'success' : 'outline-secondary' }} w-100" style="min-width: 80px;">
                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </form>
                    @elseif($role == 'admin')
                    <form action="{{ route('admin.mutabaah-item.toggle', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-{{ $item->is_active ? 'success' : 'outline-secondary' }} w-100" style="min-width: 80px;">
                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </form>
                    @else
                    <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    @endif
                </td>
                @if(($role == 'guru' && !$showGuru) || ($role == 'admin' && !$showGuru))
                @php $routePrefix = ($role == 'admin') ? 'admin' : 'guru'; @endphp
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route($routePrefix . '.mutabaah-item.edit', $item) }}" class="btn btn-sm btn-light-warning text-warning" title="Edit">
                            <i class="ti ti-edit"></i>
                        </a>
                        <form action="{{ route($routePrefix . '.mutabaah-item.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus item ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light-danger text-danger" title="Hapus">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center py-4">
                    <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-616.jpg" alt="No data" style="width: 150px; opacity: 0.5;">
                    <p class="text-muted mt-2">Belum ada item mutabaah yang ditemukan.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
