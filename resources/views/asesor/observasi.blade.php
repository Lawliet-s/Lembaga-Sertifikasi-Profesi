@extends('layout.asesor')

@section('judul')
Input Observasi | {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    <div class="page-header">
        <h4>
            <i class="fas fa-eye"></i> Input Observasi
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item">
                    <a href="{{ route('dashboard.asesor') }}">Asesor</a>
                </li>
                <li style="color: var(--secondary-color)" class="breadcrumb-item">
                    <a href="{{ route('asesor.observasi') }}">Input Observasi</a>
                </li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">
                    {{ $register->user_name ?? 'Detail' }}
                </li>
            </ol>
        </nav>
    </div>

    @include('layout.verifikasi')

    <form action="{{ route('asesor.observasi.store', $register->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            {{-- INFORMASI ASESI --}}
            <div class="col-lg-5">
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0"><i class="fas fa-user mr-2"></i>Informasi Asesi</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%"><strong>Nama</strong></td>
                                <td>: {{ $register->user_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Skema Sertifikasi</strong></td>
                                <td>: {{ $register->skema_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jadwal Asesmen</strong></td>
                                <td>:
                                    @if ($register->date)
                                        {{ optional($register->date)->format('d/m/Y') }}
                                        @if ($register->time)
                                            {{ $register->time }}
                                        @endif
                                    @else
                                        <span class="text-muted">Belum dijadwalkan</span>
                                    @endif
                                </td>
                            </tr>
                            @if ($register->tuk)
                            <tr>
                                <td><strong>TUK</strong></td>
                                <td>: {{ $register->tuk?->tuk ?? $register->tuk?->alamat ?? '-' }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- RELASI DENGAN MODUL LAIN --}}
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-link mr-2"></i>Hubungan dengan Modul Lain</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small mb-2">
                                <i class="fas fa-arrow-down text-success mr-1"></i>
                                <strong>Mengambil Data dari:</strong>
                            </label>
                            <div class="p-2 bg-light rounded">
                                <a href="{{ route('asesor.penilaian.show', $register->id) }}"
                                    class="btn btn-outline-danger btn-block text-left">
                                    <i class="fas fa-file-alt mr-2"></i>Penilaian Asesi
                                    <span class="badge badge-danger float-right mt-1">
                                        {{ $penilaians->count() }} unit
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div>
                            <label class="text-muted small mb-2">
                                <i class="fas fa-arrow-up text-warning mr-1"></i>
                                <strong>Digunakan oleh:</strong>
                            </label>
                            <div class="p-2 bg-light rounded">
                                <a href="{{ route('asesor.validasi') }}"
                                    class="btn btn-outline-success btn-block text-left">
                                    <i class="fas fa-check-circle mr-2"></i>Validasi Kompetensi
                                    <span class="text-muted float-right mt-1">
                                        <small>karena validasi membutuhkan bukti observasi nyata</small>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- HASIL PENILAIAN --}}
                <div class="card mb-4">
                    <div class="card-header bg-warning text-white">
                        <h6 class="mb-0"><i class="fas fa-clipboard-check mr-2"></i>Hasil Penilaian Asesi</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Unit Kompetensi</th>
                                        <th class="text-center">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penilaians as $p)
                                        <tr>
                                            <td>{{ optional($p->unikom)->unikom ?? optional($p->unikom)->kode_unikom ?? '-' }}</td>
                                            <td class="text-center">
                                                @if ($p->nilai === 'kompeten')
                                                    <span class="badge badge-success">Kompeten</span>
                                                @else
                                                    <span class="badge badge-danger">Belum</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">
                                                Belum ada penilaian
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FORM OBSERVASI --}}
            <div class="col-lg-7">
                {{-- AKTIVITAS OBSERVASI --}}
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0"><i class="fas fa-clipboard-list mr-2"></i>Aktivitas Observasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="aktivitas-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 55%">Aktivitas</th>
                                        <th style="width: 35%">Hasil</th>
                                        <th style="width: 10%">
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahAktivitas()">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="aktivitas-body">
                                    @foreach ($aktivitasList as $idx => $akt)
                                    <tr class="aktivitas-row">
                                        <td>
                                            <input type="text" name="aktivitas[{{ $idx }}][nama]"
                                                class="form-control form-control-sm"
                                                value="{{ old('aktivitas.' . $idx . '.nama', $akt['nama'] ?? '') }}"
                                                placeholder="Nama aktivitas..." required>
                                        </td>
                                        <td>
                                            <select name="aktivitas[{{ $idx }}][hasil]"
                                                class="form-control form-control-sm" required>
                                                <option value="Baik" {{ (old('aktivitas.' . $idx . '.hasil', $akt['hasil'] ?? '') == 'Baik') ? 'selected' : '' }}>Baik</option>
                                                <option value="Cukup" {{ (old('aktivitas.' . $idx . '.hasil', $akt['hasil'] ?? '') == 'Cukup') ? 'selected' : '' }}>Cukup</option>
                                                <option value="Kurang" {{ (old('aktivitas.' . $idx . '.hasil', $akt['hasil'] ?? '') == 'Kurang') ? 'selected' : '' }}>Kurang</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="hapusAktivitas(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @error('aktivitas')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        @error('aktivitas.*.nama')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        @error('aktivitas.*.hasil')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- UPLOAD BUKTI --}}
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0"><i class="fas fa-upload mr-2"></i>Upload Bukti Observasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="file">
                                <strong>File Bukti</strong>
                                <small class="text-muted"> (foto, pdf, dokumen — max 5MB)</small>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file" name="file"
                                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                <label class="custom-file-label" for="file">Pilih file...</label>
                            </div>
                            @error('file')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                            @if ($observasi && $observasi->file)
                                <div class="mt-2 p-2 bg-light rounded">
                                    <small>
                                        <i class="fas fa-paperclip mr-1"></i>
                                        File sebelumnya:
                                        <a href="{{ asset('storage/' . $observasi->file) }}" target="_blank"
                                            class="text-danger">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CATATAN OBSERVASI --}}
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0"><i class="fas fa-sticky-note mr-2"></i>Catatan Observasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <textarea name="catatan" id="catatan" class="form-control" rows="5"
                                placeholder="Catatan hasil observasi...">{{ old('catatan', $observasi->catatan ?? '') }}</textarea>
                            @error('catatan')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-right">
                            <a href="{{ route('asesor.observasi') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-save mr-1"></i>Simpan Observasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('foot')
<script>
    let aktivitasIndex = {{ count($aktivitasList) }};

    function tambahAktivitas() {
        const html = `
            <tr class="aktivitas-row">
                <td>
                    <input type="text" name="aktivitas[${aktivitasIndex}][nama]"
                        class="form-control form-control-sm"
                        placeholder="Nama aktivitas..." required>
                </td>
                <td>
                    <select name="aktivitas[${aktivitasIndex}][hasil]"
                        class="form-control form-control-sm" required>
                        <option value="Baik">Baik</option>
                        <option value="Cukup">Cukup</option>
                        <option value="Kurang">Kurang</option>
                    </select>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="hapusAktivitas(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        document.getElementById('aktivitas-body').insertAdjacentHTML('beforeend', html);
        aktivitasIndex++;
    }

    function hapusAktivitas(btn) {
        const rows = document.querySelectorAll('.aktivitas-row');
        if (rows.length <= 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Minimal 1 aktivitas',
                text: 'Setidaknya harus ada satu aktivitas observasi.',
                confirmButtonColor: '{{ $site_setting->secondary_color ?? '#f84949e2' }}'
            });
            return;
        }
        btn.closest('tr').remove();
    }

    document.querySelector('.custom-file-input')?.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Pilih file...';
        e.target.nextElementSibling.textContent = fileName;
    });
</script>
@endsection
