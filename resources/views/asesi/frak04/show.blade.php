@extends('layout.asesi')

@section('judul')
    FR.AK.04 - Lihat Keberatan/Klaim | ASESI {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h4>
            <i class="fas fa-exclamation-circle"></i> FR.AK.04 - Keberatan/Klaim
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom" style="background-color: var(--secondary-color);">
                <li style="color: #fff" class="breadcrumb-item"><a style="color: #fff" href="{{ route('dashasesi.index') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item"><a style="color: #fff" href="{{ route('frak04.index') }}">FR.AK.04</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Lihat Form</li>
            </ol>
        </nav>
    </div><br>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-eye"></i> Keberatan/Klaim</h4>
                    <hr>

                    <div class="form-group">
                        <label><strong>Kode Registrasi</strong></label>
                        <input type="text" class="form-control" value="{{ sprintf('%04d', $registration->id) }}" disabled>
                    </div>

                    <div class="form-group">
                        <label><strong>Skema Sertifikasi</strong></label>
                        <input type="text" class="form-control" value="{{ $registration->skema_name }}" disabled>
                    </div>

                    @if ($frAk04)
                    <div class="form-group">
                        <label><strong>Status Keberatan</strong></label>
                        <div>
                            <span class="badge" style="background-color: 
                                @if($frAk04->status == 'diajukan') #ffc107
                                @elseif($frAk04->status == 'ditinjau') #17a2b8
                                @elseif($frAk04->status == 'diterima') #28a745
                                @elseif($frAk04->status == 'ditolak') #dc3545
                                @endif
                                ; color: white; padding: 8px 12px; font-size: 14px;">
                                {{ ucfirst($frAk04->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><strong>Alasan Keberatan/Klaim</strong></label>
                        <div class="alert alert-light border">
                            {!! nl2br($frAk04->alasan) !!}
                        </div>
                    </div>

                    @if ($frAk04->file_path && file_exists(public_path($frAk04->file_path)))
                    <div class="form-group">
                        <label><strong>Dokumen Pendukung</strong></label>
                        <div class="alert alert-light border">
                            <a href="{{ asset($frAk04->file_path) }}" class="btn btn-sm btn-info" target="_blank">
                                <i class="fas fa-download"></i> Download Dokumen
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label><strong>Tanggal Diajukan</strong></label>
                        <div>
                            {{ $frAk04->diajukan_at ? $frAk04->diajukan_at->format('d M Y H:i') : '-' }}
                        </div>
                    </div>

                    @if ($frAk04->ditinjau_at)
                    <div class="form-group">
                        <label><strong>Tanggal Ditinjau</strong></label>
                        <div>
                            {{ $frAk04->ditinjau_at->format('d M Y H:i') }}
                        </div>
                    </div>
                    @endif

                    @if ($frAk04->diputus_at)
                    <div class="form-group">
                        <label><strong>Tanggal Keputusan</strong></label>
                        <div>
                            {{ $frAk04->diputus_at->format('d M Y H:i') }}
                        </div>
                    </div>
                    @endif

                    @if ($frAk04->catatan_admin)
                    <div class="form-group">
                        <label><strong>Catatan Admin</strong></label>
                        <div class="alert" style="background-color: {{ $frAk04->status == 'diterima' ? '#d4edda' : '#f8d7da' }}; border-color: {{ $frAk04->status == 'diterima' ? '#c3e6cb' : '#f5c6cb' }}; color: {{ $frAk04->status == 'diterima' ? '#155724' : '#721c24' }};">
                            {!! nl2br($frAk04->catatan_admin) !!}
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Belum ada data keberatan/klaim.
                    </div>
                    @endif

                    <div class="form-group mt-3">
                        <a href="{{ route('frak04.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        @if ($frAk04 && $frAk04->status == 'diajukan')
                        <a href="{{ route('frak04.create', $registration->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
