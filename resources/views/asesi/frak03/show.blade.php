@extends('layout.asesi')

@section('sidebar')
    sidebar-mini
@endsection

@section('judul')
    FR.AK.03 - Umpan Balik dan Catatan Asesmen - {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('isi')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4><i class="fas fa-comment-dots"></i> FR.AK.03 — Umpan Balik dan Catatan Asesmen</h4>
        <a href="{{ route('frak03.index') }}" class="btn btn-outline-secondary btn-sm">
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
                        <tr><td class="fw-bold">TUK</td><td>: {{ $registration->tuk?->tuk ?? '-' }}</td></tr>
                        <tr><td class="fw-bold">Status</td><td>: {{ $registration->status }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if ($frAk03)
        <div class="card shadow-sm rounded mb-4">
            <div class="card-header" style="background-color: #28a745; color: #fff;">
                <i class="fas fa-check-circle"></i> Umpan Balik Telah Disimpan
            </div>
            <div class="card-body">
                <h5 class="mb-3" style="color: var(--primary-color);">Rating</h5>
                <div class="mb-4">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $frAk03->rating)
                            <i class="fas fa-star" style="color: #ffc107; font-size: 24px;"></i>
                        @else
                            <i class="far fa-star" style="color: #ccc; font-size: 24px;"></i>
                        @endif
                    @endfor
                    <span class="ms-2 align-middle">
                        @switch($frAk03->rating)
                            @case(1) Sangat Kurang @break
                            @case(2) Kurang @break
                            @case(3) Cukup @break
                            @case(4) Baik @break
                            @case(5) Sangat Baik @break
                        @endswitch
                    </span>
                </div>

                @if ($frAk03->feedback)
                    <h5 class="mb-3" style="color: var(--primary-color);">Umpan Balik</h5>
                    <div class="border rounded p-3 mb-4" style="background: #f8f9fa;">
                        {{ $frAk03->feedback }}
                    </div>
                @endif

                @if ($frAk03->catatan)
                    <h5 class="mb-3" style="color: var(--primary-color);">Catatan</h5>
                    <div class="border rounded p-3 mb-4" style="background: #f8f9fa;">
                        {{ $frAk03->catatan }}
                    </div>
                @endif

                @if ($frAk03->saran)
                    <h5 class="mb-3" style="color: var(--primary-color);">Saran</h5>
                    <div class="border rounded p-3 mb-4" style="background: #f8f9fa;">
                        {{ $frAk03->saran }}
                    </div>
                @endif

                <p class="text-muted"><small>Disimpan pada: {{ $frAk03->created_at->format('d M Y H:i') }}</small></p>

                <a href="{{ route('frak03.show', $registration->id) }}?edit=1" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit Umpan Balik
                </a>
            </div>
        </div>
    @else
        <form action="{{ route('frak03.store', $registration->id) }}" method="POST">
            @csrf

            <div class="card shadow-sm rounded mb-4">
                <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
                    <i class="fas fa-star"></i> Form Umpan Balik
                </div>
                <div class="card-body">

                    <div class="mb-4">
                        <label class="form-label fw-bold">Rating / Tingkat Kepuasan <span class="text-danger">*</span></label>
                        <div class="rating-container">
                            <div class="star-rating d-flex gap-2" style="font-size: 30px; cursor: pointer;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="far fa-star star-btn" data-value="{{ $i }}" style="color: #ccc; transition: color 0.2s;"></i>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="5">
                            <div id="ratingLabel" class="mt-1 text-muted">Sangat Baik</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="feedback" class="form-label fw-bold">Umpan Balik</label>
                        <textarea name="feedback" id="feedback" class="form-control" rows="4" placeholder="Tuliskan umpan balik Anda tentang proses asesmen..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="catatan" class="form-label fw-bold">Catatan</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="saran" class="form-label fw-bold">Saran</label>
                        <textarea name="saran" id="saran" class="form-control" rows="3" placeholder="Saran untuk perbaikan ke depan (opsional)..."></textarea>
                    </div>
                </div>
                <div class="card-footer bg-white text-end px-4 py-3">
                    <button type="submit" class="btn" style="background-color: var(--primary-color); color: #fff;">
                        <i class="fas fa-paper-plane"></i> Kirim Umpan Balik
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('ratingInput');
        const ratingLabel = document.getElementById('ratingLabel');
        const labels = ['', 'Sangat Kurang', 'Kurang', 'Cukup', 'Baik', 'Sangat Baik'];

        function setRating(val) {
            ratingInput.value = val;
            ratingLabel.textContent = labels[val];
            stars.forEach((star, i) => {
                if (i < val) {
                    star.className = 'fas fa-star star-btn';
                    star.style.color = '#ffc107';
                } else {
                    star.className = 'far fa-star star-btn';
                    star.style.color = '#ccc';
                }
            });
        }

        stars.forEach(star => {
            star.addEventListener('click', function() {
                setRating(parseInt(this.dataset.value));
            });
            star.addEventListener('mouseenter', function() {
                const val = parseInt(this.dataset.value);
                stars.forEach((s, i) => {
                    if (i < val) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#e0e0e0';
                    }
                });
            });
            star.addEventListener('mouseleave', function() {
                const val = parseInt(ratingInput.value);
                stars.forEach((s, i) => {
                    if (i < val) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#ccc';
                    }
                });
            });
        });

        setRating(5);
    });
</script>
@endpush
