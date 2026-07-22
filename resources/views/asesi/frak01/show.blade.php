@extends('layout.asesi')

@section('judul')
    FR.AK.01 - Lihat Pernyataan Kesediaan | ASESI {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h4>
            FR.AK.01 - Pernyataan Kesediaan
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom" style="background-color: var(--secondary-color);">
                <li style="color: #fff" class="breadcrumb-item"><a style="color: #fff" href="{{ route('dashasesi.index') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item"><a style="color: #fff" href="{{ route('frak01.index') }}">FR.AK.01</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Lihat Form</li>
            </ol>
        </nav>
    </div><br>

    <div class="row" style="margin-left: 0; margin-right: 0;">
        <div class="col-12" style="padding-left: 0; padding-right: 0;">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pernyataan Kesediaan</h4>
                    <hr>

                    <div class="form-group">
                        <label><strong>Kode Registrasi</strong></label>
                        <input type="text" class="form-control" value="{{ sprintf('%04d', $registration->id) }}" disabled>
                    </div>

                    <div class="form-group">
                        <label><strong>Skema Sertifikasi</strong></label>
                        <input type="text" class="form-control" value="{{ $registration->skema_name }}" disabled>
                    </div>

                    <div class="form-group">
                        <label><strong>Pernyataan Kesediaan</strong></label>
                        <div class="alert alert-light border">
                            <p>
                                Saya dengan ini menyatakan kesediaan untuk mengikuti proses sertifikasi kompetensi sesuai dengan skema 
                                yang telah dipilih. Saya memahami bahwa proses ini melibatkan assessmen mendalam terhadap kompetensi dan 
                                pengalaman kerja saya, dan saya siap untuk memberikan data dan informasi yang dibutuhkan secara akurat dan lengkap.
                            </p>
                            <p class="mt-3">
                                Saya juga memahami dan menerima hasil keputusan dari proses sertifikasi ini, serta siap untuk melaksanakan 
                                rekomendasi yang diberikan untuk meningkatkan kompetensi saya.
                            </p>
                        </div>
                    </div>

                    @if ($frAk01)
                    <div class="form-group">
                         <label><strong>Tanda Tangan</strong></label>
                         <div class="border p-3" style="border-radius: 4px; overflow: auto;">
                             <img src="{{ $frAk01->ttd }}" alt="Tanda Tangan" style="max-width: 100%; height: auto; display: block;">
                         </div>
                     </div>

                     <div class="form-group">
                         <label><strong>Status</strong></label>
                         <div>
                             <span class="badge badge-success">{{ ucfirst($frAk01->status) }}</span>
                         </div>
                     </div>

                     <div class="form-group">
                         <label><strong>Tanggal Ditandatangani</strong></label>
                         <div>
                             {{ $frAk01->agreed_at ? $frAk01->agreed_at->format('d M Y H:i') : '-' }}
                         </div>
                     </div>
                     @else
                     <div class="alert alert-info">
                         Pernyataan kesediaan belum diisi. Silakan isi form terlebih dahulu.
                     </div>
                     @endif

                     <div class="form-group mt-4">
                         <div class="d-flex flex-wrap" style="gap: 8px;">
                             <a href="{{ route('frak01.index') }}" class="btn btn-secondary">
                                Kembali
                             </a>
                             <a href="{{ route('frak01.create', $registration->id) }}" class="btn btn-primary">
                                {{ $frAk01 ? 'Edit' : 'Isi Form' }}
                             </a>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
@endsection
