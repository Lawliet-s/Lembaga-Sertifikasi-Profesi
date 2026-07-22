@extends('layout.asesi')

@section('judul')
    FR.AK.03 - Lihat Evaluasi Kepuasan | ASESI {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h4>
            <i class="fas fa-star"></i> FR.AK.03 - Evaluasi Kepuasan
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom" style="background-color: var(--secondary-color);">
                <li style="color: #fff" class="breadcrumb-item"><a style="color: #fff" href="{{ route('dashasesi.index') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item"><a style="color: #fff" href="{{ route('frak03.index') }}">FR.AK.03</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Lihat Form</li>
            </ol>
        </nav>
    </div><br>

    <div class="row" style="margin-left: 0; margin-right: 0;">
        <div class="col-12" style="padding-left: 0; padding-right: 0;">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-eye"></i> Evaluasi Kepuasan</h4>
                    <hr>

                    <div class="form-group">
                        <label><strong>Kode Registrasi</strong></label>
                        <input type="text" class="form-control" value="{{ sprintf('%04d', $registration->id) }}" disabled>
                    </div>

                    <div class="form-group">
                        <label><strong>Skema Sertifikasi</strong></label>
                        <input type="text" class="form-control" value="{{ $registration->skema_name }}" disabled>
                    </div>

                    @if ($frAk03)
                    <div class="form-group">
                        <label><strong>Rating Kepuasan</strong></label>
                        <div>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $frAk03->rating)
                                    <i class="fas fa-star" style="color: #ffc107; font-size: 20px;"></i>
                                @else
                                    <i class="fas fa-star" style="color: #ccc; font-size: 20px;"></i>
                                @endif
                            @endfor
                            <span class="ml-2">{{ $frAk03->rating }}/5</span>
                        </div>
                    </div>

                    @if ($frAk03->feedback)
                    <div class="form-group">
                        <label><strong>Feedback Umum</strong></label>
                        <div class="alert alert-light border">
                            {{ $frAk03->feedback }}
                        </div>
                    </div>
                    @endif

                    @if ($frAk03->catatan)
                    <div class="form-group">
                        <label><strong>Catatan</strong></label>
                        <div class="alert alert-light border">
                            {{ $frAk03->catatan }}
                        </div>
                    </div>
                    @endif

                    @if ($frAk03->saran)
                    <div class="form-group">
                        <label><strong>Saran & Masukan</strong></label>
                        <div class="alert alert-light border">
                            {{ $frAk03->saran }}
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label><strong>Tanggal Diisi</strong></label>
                        <div>
                            {{ $frAk03->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Belum ada data evaluasi kepuasan.
                    </div>
                    @endif

                    <div class="form-group mt-4">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('frak03.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('frak03.create', $registration->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
