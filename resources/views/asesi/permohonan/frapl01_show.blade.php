@extends('layout.asesi')

@section('sidebar')
    sidebar-mini
@endsection

@section('judul')
    FR.APL.01 - Detail - {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('isi')
<style>
    .frapl01-table {
        border-collapse: collapse;
        width: 100%;
    }
    .frapl01-table td, .frapl01-table th {
        border: 1px solid #000;
        padding: 6px 10px;
        vertical-align: top;
    }
    .frapl01-table .label-cell {
        font-weight: 600;
        width: 200px;
    }
    @media print {
        .no-print, .page-header, .card-header, .btn { display: none !important; }
        .print-area { box-shadow: none !important; border: none !important; }
        body { background: #fff !important; }
    }
</style>

<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center no-print">
        <h4><i class="fas fa-file-alt"></i> FR.APL.01 — Detail Permohonan</h4>
        <div>
            <a href="{{ route('permohonan.frapl01') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn" style="background-color: var(--primary-color); color: #fff;">
                <i class="fas fa-print"></i> Cetak
            </button>
        </div>
    </div>

    <div class="card shadow-sm rounded mb-4 print-area">
        <div class="card-body p-4">
            {{-- Header --}}
            <div class="text-center mb-4">
                <h4 class="fw-bold">FR.APL.01</h4>
                <h5>PERMOHONAN SERTIFIKASI KOMPETENSI</h5>
                <p class="small text-muted">{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</p>
            </div>

            {{-- Data Pribadi --}}
            <h6 class="fw-bold mb-3" style="color: var(--primary-color);">A. Data Pribadi</h6>
            <table class="frapl01-table mb-4">
                <tr>
                    <td class="label-cell">Nama Lengkap</td>
                    <td><strong>{{ optional($permohonan->dataPribadi)->nama_lengkap ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <td class="label-cell">NIK</td>
                    <td>{{ optional($permohonan->dataPribadi)->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Tempat, Tanggal Lahir</td>
                    <td>{{ optional($permohonan->dataPribadi)->tempat_lahir ?? '-' }}{{ $permohonan->dataPribadi ? ', ' . \Carbon\Carbon::parse($permohonan->dataPribadi->tanggal_lahir)->format('d M Y') : '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Jenis Kelamin</td>
                    <td>{{ optional($permohonan->dataPribadi)->jenis_kelamin === 'L' ? 'Laki-laki' : (optional($permohonan->dataPribadi)->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Kebangsaan</td>
                    <td>{{ optional($permohonan->dataPribadi)->kebangsaan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Alamat</td>
                    <td>{{ optional($permohonan->dataPribadi)->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Kode Pos</td>
                    <td>{{ optional($permohonan->dataPribadi)->kode_pos ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">No. HP</td>
                    <td>{{ optional($permohonan->dataPribadi)->no_hp ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Email</td>
                    <td>{{ optional($permohonan->dataPribadi)->email ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Pendidikan</td>
                    <td>{{ optional($permohonan->dataPribadi)->pendidikan ?? '-' }}</td>
                </tr>
            </table>

            {{-- Data Pekerjaan --}}
            <h6 class="fw-bold mb-3" style="color: var(--primary-color);">B. Data Pekerjaan</h6>
            <table class="frapl01-table mb-4">
                <tr>
                    <td class="label-cell">Nama Perusahaan</td>
                    <td><strong>{{ optional($permohonan->pekerjaan)->nama_perusahaan ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <td class="label-cell">Jabatan</td>
                    <td>{{ optional($permohonan->pekerjaan)->jabatan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Alamat Kantor</td>
                    <td>{{ optional($permohonan->pekerjaan)->alamat_kantor ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Kode Pos</td>
                    <td>{{ optional($permohonan->pekerjaan)->kode_pos_kantor ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Telepon Kantor</td>
                    <td>{{ optional($permohonan->pekerjaan)->telepon_kantor ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Email Kantor</td>
                    <td>{{ optional($permohonan->pekerjaan)->email_kantor ?? '-' }}</td>
                </tr>
            </table>

            {{-- Skema Sertifikasi --}}
            <h6 class="fw-bold mb-3" style="color: var(--primary-color);">C. Skema Sertifikasi</h6>
            <table class="frapl01-table mb-4">
                <tr>
                    <td class="label-cell">Skema</td>
                    <td><strong>{{ $permohonan->skema->skema ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <td class="label-cell">Kode Skema</td>
                    <td>{{ $permohonan->skema->kode_skema ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Tujuan Asesmen</td>
                    <td>{{ strtoupper($permohonan->tujuan_asesmen) }}</td>
                </tr>
            </table>

            {{-- Unit Kompetensi --}}
            @if ($permohonan->skema && $permohonan->skema->unikoms->count() > 0)
                <h6 class="fw-bold mb-3" style="color: var(--primary-color);">D. Unit Kompetensi</h6>
                <table class="frapl01-table mb-4">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th>Kode Unit</th>
                            <th>Judul Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permohonan->skema->unikoms as $i => $unit)
                            <tr>
                                <td style="text-align: center;">{{ $i + 1 }}</td>
                                <td><code>{{ $unit->kode_unikom }}</code></td>
                                <td>{{ $unit->unikom }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            {{-- Tanda Tangan --}}
            @if ($permohonan->ttd)
            <h6 class="fw-bold mb-3" style="color: var(--primary-color);">E. Tanda Tangan</h6>
            <table class="frapl01-table mb-4">
                <tr>
                    <td class="label-cell">Tanda Tangan Pemohon</td>
                    <td>
                        <img src="{{ asset('storage/' . $permohonan->ttd) }}" alt="Tanda Tangan" style="max-height: 80px;">
                    </td>
                </tr>
            </table>
            @endif

            {{-- Status --}}
            <table class="frapl01-table">
                <tr>
                    <td class="label-cell">Status</td>
                    <td>
                        @php
                            $badge = match($permohonan->status) {
                                'diverifikasi' => 'info',
                                'selesai' => 'success',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge badge-{{ $badge }}">{{ ucfirst($permohonan->status) }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Tanggal Pengajuan</td>
                    <td>{{ $permohonan->created_at->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Terakhir diperbarui</td>
                    <td>{{ $permohonan->updated_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection


