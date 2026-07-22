@extends('layout.asesi')

@section('judul')
    FR.AK.03 - Isi Evaluasi Kepuasan | ASESI {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
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
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Isi Form</li>
            </ol>
        </nav>
    </div><br>

    <div class="row" style="margin-left: 0; margin-right: 0;">
        <div class="col-12" style="padding-left: 0; padding-right: 0;">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-pen"></i> Evaluasi Kepuasan</h4>
                    <hr>
                    <form action="{{ route('frak03.store') }}" method="POST">
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

                        <div class="form-group">
                            <label for="rating"><strong>Rating Kepuasan (1-5)</strong></label>
                            <div class="rating-stars d-flex flex-wrap gap-2 align-items-center" style="margin-top: 10px;">
                                <input type="hidden" id="rating" name="rating" value="{{ $frAk03->rating ?? 5 }}">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star star-icon" data-rating="{{ $i }}" style="font-size: 28px; cursor: pointer; color: #ffc107; transition: all 0.2s ease;"></i>
                                @endfor
                            </div>
                            <small class="form-text text-muted d-block mt-2">Pilih rating kepuasan Anda terhadap proses assessment</small>
                            @error('rating')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <label for="feedback"><strong>Feedback Umum</strong></label>
                            <textarea name="feedback" id="feedback" class="form-control" rows="4" placeholder="Berikan feedback umum tentang proses sertifikasi">{{ $frAk03->feedback ?? '' }}</textarea>
                            @error('feedback')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="catatan"><strong>Catatan</strong></label>
                            <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Catatan tambahan jika ada">{{ $frAk03->catatan ?? '' }}</textarea>
                            @error('catatan')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="saran"><strong>Saran & Masukan</strong></label>
                            <textarea name="saran" id="saran" class="form-control" rows="3" placeholder="Berikan saran dan masukan untuk perbaikan">{{ $frAk03->saran ?? '' }}</textarea>
                            @error('saran')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('frak03.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan Evaluasi
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
        document.querySelectorAll('.star-icon').forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                document.getElementById('rating').value = rating;
                
                document.querySelectorAll('.star-icon').forEach(s => {
                    if (s.getAttribute('data-rating') <= rating) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#ccc';
                    }
                });
            });

            star.addEventListener('mouseover', function() {
                const rating = this.getAttribute('data-rating');
                document.querySelectorAll('.star-icon').forEach(s => {
                    if (s.getAttribute('data-rating') <= rating) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#ccc';
                    }
                });
            });
        });

        document.querySelector('.rating-stars').addEventListener('mouseout', function() {
            const currentRating = document.getElementById('rating').value;
            document.querySelectorAll('.star-icon').forEach(s => {
                if (s.getAttribute('data-rating') <= currentRating) {
                    s.style.color = '#ffc107';
                } else {
                    s.style.color = '#ccc';
                }
            });
        });

        document.querySelectorAll('.star-icon').forEach(s => {
            const rating = document.getElementById('rating').value;
            if (s.getAttribute('data-rating') <= rating) {
                s.style.color = '#ffc107';
            } else {
                s.style.color = '#ccc';
            }
        });
    </script>
    @endpush
@endsection
