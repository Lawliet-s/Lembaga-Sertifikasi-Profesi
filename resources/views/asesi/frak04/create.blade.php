@extends('layout.asesi')

@section('judul')
    FR.AK.04 - Isi Keberatan/Klaim | ASESI {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
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
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Isi Form</li>
            </ol>
        </nav>
    </div><br>

    <div class="row" style="margin-left: 0; margin-right: 0;">
        <div class="col-12" style="padding-left: 0; padding-right: 0;">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-pen"></i> Keberatan/Klaim</h4>
                    <hr>
                    <form action="{{ route('frak04.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="data_register_id" value="{{ $registration->id }}">

                        <div class="form-group">
                            <label><strong>Kode Registrasi</strong></label>
                            <input type="text" class="form-control" value="{{ sprintf('%04d', $registration->id) }}" disabled>
                        </div>

                        <div class="form-group">
                            <label><strong>Skema Sertifikasi</strong></label>
                            <input type="text" class="form-control" value="{{ $registration->skema_name }}" disabled>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> <strong>Informasi:</strong> 
                            Form ini digunakan untuk mengajukan keberatan atau klaim terhadap hasil penilaian. 
                            Silakan jelaskan alasan keberatan Anda dengan detail dan sertakan dokumen pendukung jika ada.
                        </div>

                        <div class="form-group">
                            <label for="alasan"><strong>Alasan Keberatan/Klaim <span class="text-danger">*</span></strong></label>
                            <textarea name="alasan" id="alasan" class="form-control" rows="5" placeholder="Jelaskan secara detail alasan keberatan atau klaim Anda" required>{{ $frAk04->alasan ?? '' }}</textarea>
                            @error('alasan')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="file_path"><strong>Dokumen Pendukung</strong></label>
                            <input type="file" class="form-control" id="file_path" name="file_path" accept=".pdf,.doc,.docx" onchange="updateFileName(this)">
                            <small class="form-text text-muted d-block mt-2">Opsional: Unggah dokumen pendukung untuk mendukung keberatan Anda (PDF, DOC, DOCX - Max 5MB)</small>
                            @error('file_path')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        @if ($frAk04 && $frAk04->file_path && file_exists(public_path($frAk04->file_path)))
                        <div class="form-group">
                            <label><strong>File Terpilih Sebelumnya</strong></label>
                            <div class="alert alert-light border">
                                <a href="{{ asset($frAk04->file_path) }}" target="_blank" class="btn btn-sm btn-link">
                                    <i class="fas fa-download"></i> Download File
                                </a>
                            </div>
                        </div>
                        @endif

                        <div class="form-group mt-4">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('frak04.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane"></i> Ajukan Keberatan/Klaim
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateFileName(input) {
            const label = input.nextElementSibling;
            if (input.files && input.files[0]) {
                label.textContent = input.files[0].name;
            }
        }
    </script>
    @endpush
@endsection
