@extends('layout.asesi')

@section('sidebar')
    sidebar-mini
@endsection

@section('judul')
    FR.AK.04 - Banding Asesmen - {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('isi')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4><i class="fas fa-gavel"></i> FR.AK.04 — Banding Asesmen</h4>
        <a href="{{ route('frak04.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm rounded mb-4">
        <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
            <i class="fas fa-info-circle"></i> Informasi Sertifikasi
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr><td class="fw-bold" style="width: 140px;">Skema</td><td>: {{ $registration->skema_name }}</td></tr>
                        <tr><td class="fw-bold">Kode Registrasi</td><td>: #{{ $registration->id }}</td></tr>
                        <tr><td class="fw-bold">Nama Asesi</td><td>: {{ Auth::user()->name }}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr><td class="fw-bold" style="width: 140px;">Asesor</td><td>: {{ $registration->asesor?->nama ?? '-' }}</td></tr>
                        <tr><td class="fw-bold">Hasil</td><td>: {{ $registration->status }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if ($frAk04)
        <div class="card shadow-sm rounded mb-4">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background-color:
                    @switch($frAk04->status)
                        @case('diajukan') #17a2b8 @break
                        @case('ditinjau') #ffc107 @break
                        @case('diterima') #28a745 @break
                        @case('ditolak') #dc3545 @break
                        @default #6c757d
                    @endswitch
                ; color: #fff;">
                <span><i class="fas fa-info-circle"></i> Status Banding</span>
                <span class="badge bg-light text-dark">
                    @switch($frAk04->status)
                        @case('diajukan') Diajukan @break
                        @case('ditinjau') Sedang Ditinjau @break
                        @case('diterima') Diterima @break
                        @case('ditolak') Ditolak @break
                    @endswitch
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Tanggal Diajukan:</strong> {{ $frAk04->diajukan_at ? $frAk04->diajukan_at->format('d M Y H:i') : '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        @if ($frAk04->ditinjau_at)
                            <p><strong>Tanggal Ditinjau:</strong> {{ $frAk04->ditinjau_at->format('d M Y H:i') }}</p>
                        @endif
                    </div>
                </div>

                <h5 class="mb-3" style="color: var(--primary-color);">Alasan Banding</h5>
                <div class="border rounded p-3 mb-4" style="background: #f8f9fa;">
                    {{ $frAk04->alasan }}
                </div>

                @if ($frAk04->file_path)
                    <h5 class="mb-3" style="color: var(--primary-color);">Dokumen Pendukung</h5>
                    <p>
                        <a href="{{ asset($frAk04->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                            <i class="fas fa-file"></i> Lihat Dokumen
                        </a>
                    </p>
                @endif

                @if ($frAk04->catatan_admin)
                    <h5 class="mb-3" style="color: var(--primary-color);">Catatan Admin / Asesor</h5>
                    <div class="border rounded p-3 mb-4" style="background: #fff3cd;">
                        {{ $frAk04->catatan_admin }}
                    </div>
                @endif

                @if ($frAk04->diputus_at)
                    <p class="text-muted">
                        <small>Diputuskan pada: {{ $frAk04->diputus_at->format('d M Y H:i') }}</small>
                    </p>
                @endif

                @if ($frAk04->status === 'ditolak')
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Banding Anda ditolak. Jika ada keberatan, silakan hubungi admin LSP.
                    </div>
                @elseif ($frAk04->status === 'diterima')
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Banding Anda diterima. Silakan cek hasil sertifikasi terbaru.
                    </div>
                @endif
            </div>
        </div>
    @else
        <form action="{{ route('frak04.store', $registration->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card shadow-sm rounded mb-4">
                <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
                    <i class="fas fa-gavel"></i> Form Banding
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Banding dapat diajukan jika Anda tidak puas dengan hasil asesmen. Jelaskan alasan banding secara jelas dan lengkap.
                    </div>

                    <div class="mb-4">
                        <label for="alasan" class="form-label fw-bold">Alasan Banding <span class="text-danger">*</span></label>
                        <textarea name="alasan" id="alasan" class="form-control" rows="6" placeholder="Jelaskan alasan Anda mengajukan banding..." required></textarea>
                        <small class="text-muted">Maksimal 5000 karakter.</small>
                    </div>

                    <div class="mb-4">
                        <label for="file" class="form-label fw-bold">Dokumen Pendukung (opsional)</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".pdf,.png,.jpg,.jpeg">
                        <small class="text-muted">Format: PDF, PNG, JPG. Maksimal 2MB.</small>
                    </div>
                </div>
                <div class="card-footer bg-white text-end px-4 py-3">
                    <button type="submit" class="btn" style="background-color: var(--primary-color); color: #fff;">
                        <i class="fas fa-paper-plane"></i> Ajukan Banding
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection
