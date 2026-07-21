@extends('layout.asesi')

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
        <a href="{{ route('permohonan.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            {{-- Data Pribadi --}}
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

            {{-- Data Pekerjaan --}}
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

            {{-- Skema & Unit Kompetensi --}}
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

            {{-- Dokumen --}}
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
                                                    <i class="fas fa-download"></i>
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

        {{-- Sidebar Status --}}
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
                    <p class="small text-muted mb-1">Diajukan pada</p>
                    <p class="fw-bold">{{ $permohonan->created_at->format('d M Y H:i') }}</p>
                    <p class="small text-muted mb-1">Terakhir diperbarui</p>
                    <p class="fw-bold">{{ $permohonan->updated_at->format('d M Y H:i') }}</p>

                    @if ($permohonan->catatan)
                        <hr>
                        <p class="small text-muted mb-1">Catatan:</p>
                        <div class="alert alert-secondary p-2 small text-left">
                            {{ $permohonan->catatan }}
                        </div>
                    @endif
                </div>
            </div>

            @if (in_array($permohonan->status, ['pending', 'revisi']))
                <div class="card shadow-sm rounded">
                    <div class="card-body text-center">
                        <a href="{{ route('permohonan.edit', $permohonan->id) }}" class="btn btn-success btn-block">
                            <i class="fas fa-edit"></i> Edit Permohonan
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
