@extends('layout.admin')

@section('sidebar')
    sidebar-mini
@endsection

@section('judul')
    Detail Permohonan - {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('isi')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4><i class="fas fa-file-alt"></i> Detail Permohonan Sertifikasi</h4>
        <a href="{{ route('registrasi.baru') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm rounded mb-4">
                <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
                    <i class="fas fa-user"></i> Data Pribadi
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td style="width: 180px;">Nama Lengkap</td><td><strong>{{ optional($permohonan->dataPribadi)->nama_lengkap ?? '-' }}</strong></td></tr>
                        <tr><td>NIK</td><td>{{ optional($permohonan->dataPribadi)->nik ?? '-' }}</td></tr>
                        <tr><td>Tempat, Tanggal Lahir</td><td>{{ optional($permohonan->dataPribadi)->tempat_lahir ?? '-' }}{{ $permohonan->dataPribadi ? ', ' . \Carbon\Carbon::parse($permohonan->dataPribadi->tanggal_lahir)->format('d M Y') : '' }}</td></tr>
                        <tr><td>Jenis Kelamin</td><td>{{ optional($permohonan->dataPribadi)->jenis_kelamin === 'L' ? 'Laki-laki' : (optional($permohonan->dataPribadi)->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</td></tr>
                        <tr><td>Kebangsaan</td><td>{{ optional($permohonan->dataPribadi)->kebangsaan ?? '-' }}</td></tr>
                        <tr><td>Alamat</td><td>{{ optional($permohonan->dataPribadi)->alamat ?? '-' }}</td></tr>
                        <tr><td>Kode Pos</td><td>{{ optional($permohonan->dataPribadi)->kode_pos ?? '-' }}</td></tr>
                        <tr><td>No. HP</td><td>{{ optional($permohonan->dataPribadi)->no_hp ?? '-' }}</td></tr>
                        <tr><td>Email</td><td>{{ optional($permohonan->dataPribadi)->email ?? '-' }}</td></tr>
                        <tr><td>Pendidikan</td><td>{{ optional($permohonan->dataPribadi)->pendidikan ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm rounded mb-4">
                <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
                    <i class="fas fa-briefcase"></i> Data Pekerjaan
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td style="width: 180px;">Nama Perusahaan</td><td><strong>{{ optional($permohonan->pekerjaan)->nama_perusahaan ?? '-' }}</strong></td></tr>
                        <tr><td>Jabatan</td><td>{{ optional($permohonan->pekerjaan)->jabatan ?? '-' }}</td></tr>
                        <tr><td>Alamat Kantor</td><td>{{ optional($permohonan->pekerjaan)->alamat_kantor ?? '-' }}</td></tr>
                        <tr><td>Kode Pos</td><td>{{ optional($permohonan->pekerjaan)->kode_pos_kantor ?? '-' }}</td></tr>
                        <tr><td>Telepon</td><td>{{ optional($permohonan->pekerjaan)->telepon_kantor ?? '-' }}</td></tr>
                        <tr><td>Email Kantor</td><td>{{ optional($permohonan->pekerjaan)->email_kantor ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm rounded mb-4">
                <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
                    <i class="fas fa-tags"></i> Skema & Unit Kompetensi
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-3">
                        <tr><td style="width: 180px;">Skema</td><td><strong>{{ $permohonan->skema->skema ?? '-' }}</strong></td></tr>
                        <tr><td>Kode Skema</td><td>{{ $permohonan->skema->kode_skema ?? '-' }}</td></tr>
                        <tr><td>Tujuan Asesmen</td><td><span class="badge badge-info">{{ strtoupper($permohonan->tujuan_asesmen) }}</span></td></tr>
                    </table>

                    @if ($permohonan->skema && $permohonan->skema->unikoms->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0">
                                <thead><tr><th>No</th><th>Kode Unit</th><th>Judul Unit</th></tr></thead>
                                <tbody>
                                    @foreach ($permohonan->skema->unikoms as $i => $unit)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td><code>{{ $unit->kode_unikom }}</code></td>
                                            <td>{{ $unit->unikom }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm rounded mb-4">
                <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
                    <i class="fas fa-file"></i> Dokumen Pendukung
                </div>
                <div class="card-body">
                    @if ($permohonan->dokumens->isEmpty())
                        <p class="text-muted mb-0">Tidak ada dokumen.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead><tr><th>Jenis</th><th>Nama File</th><th>Aksi</th></tr></thead>
                                <tbody>
                                    @foreach ($permohonan->dokumens as $dok)
                                        <tr>
                                            <td>{{ str_replace('_', ' ', ucfirst($dok->jenis_dokumen)) }}</td>
                                            <td>{{ $dok->nama_file }}</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $dok->path_file) }}" target="_blank" class="btn btn-sm btn-info">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm rounded mb-4">
                <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
                    <i class="fas fa-info-circle"></i> Status Permohonan
                </div>
                <div class="card-body text-center">
                    @php
                        $badge = match($permohonan->status) {
                            'pending' => 'warning',
                            'diverifikasi' => 'info',
                            'revisi' => 'danger',
                            'ditolak' => 'dark',
                            'selesai' => 'success',
                            default => 'secondary'
                        };
                    @endphp
                    <span class="badge badge-{{ $badge }}" style="font-size: 1rem; padding: 8px 20px;">
                        {{ ucfirst($permohonan->status) }}
                    </span>
                    <hr>
                    <p class="small text-muted mb-1">Nama Pengaju</p>
                    <p class="fw-bold">{{ $permohonan->user->name }}</p>
                    <p class="small text-muted mb-1">Email</p>
                    <p class="fw-bold">{{ $permohonan->user->email }}</p>
                    <p class="small text-muted mb-1">Tanggal Pengajuan</p>
                    <p class="fw-bold">{{ $permohonan->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <div class="card shadow-sm rounded mb-4">
                <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
                    <i class="fas fa-check-circle"></i> Update Status
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.permohonan.status', $permohonan->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="small fw-bold">Status</label>
                            <select name="status" class="form-control">
                                <option value="pending" {{ $permohonan->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="diverifikasi" {{ $permohonan->status === 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                <option value="revisi" {{ $permohonan->status === 'revisi' ? 'selected' : '' }}>Revisi</option>
                                <option value="ditolak" {{ $permohonan->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                <option value="selesai" {{ $permohonan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="small fw-bold">Catatan (opsional)</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan untuk asesi...">{{ $permohonan->catatan }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-block" style="background-color: var(--primary-color); color: #fff;">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
