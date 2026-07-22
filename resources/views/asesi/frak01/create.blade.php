@extends('layout.asesi')

@section('judul')
    FR.AK.01 - Isi Pernyataan Kesediaan | ASESI {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
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
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Isi Form</li>
            </ol>
        </nav>
    </div><br>

    <div class="row" style="margin-left: 0; margin-right: 0;">
        <div class="col-12" style="padding-left: 0; padding-right: 0;">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pernyataan Kesediaan</h4>
                    <hr>
                    <form action="{{ route('frak01.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="data_register_id" value="{{ $registration->id }}">

                        <div class="form-group">
                             <label><strong>Kode Registrasi</strong></label>
                             <input type="text" class="form-control" value="{{ sprintf('%04d', $registration->id) }}" readonly>
                         </div>

                         <div class="form-group">
                             <label><strong>Skema Sertifikasi</strong></label>
                             <input type="text" class="form-control" value="{{ $registration->skema_name }}" readonly>
                         </div>

                        <div class="form-group">
                            <label for="statement"><strong>Pernyataan Kesediaan</strong></label>
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

                        <div class="form-group">
                             <label for="signaturePad"><strong>Tanda Tangan (Digital/Canvas) <span class="text-danger">*</span></strong></label>
                             <div style="border: 2px solid #ddd; border-radius: 4px; overflow: hidden; background: #fff;">
                                 <canvas id="signaturePad" style="display: block; cursor: crosshair; width: 100%; height: 250px; touch-action: none;"></canvas>
                             </div>
                             <small class="form-text text-muted d-block mt-2">Klik dan tanda tangan pada area di atas</small>
                             <input type="hidden" id="ttd" name="ttd">
                             @error('ttd')
                                 <span class="text-danger small">{{ $message }}</span>
                             @enderror
                         </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-warning btn-sm" id="clearSignature">
                                Hapus Tanda Tangan
                            </button>
                        </div>

                         <div class="form-group mt-4">
                             <div class="d-flex flex-wrap" style="gap: 8px;">
                                 <a href="{{ route('frak01.index') }}" class="btn btn-secondary">
                                    Kembali
                                 </a>
                                 <button type="submit" class="btn btn-success">
                                    Simpan Pernyataan
                                 </button>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>

     @push('scripts')
      <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.js"></script>
      <script>
          function initSignaturePad() {
              const canvas = document.getElementById('signaturePad');
              const container = canvas.parentElement;
              const dpr = window.devicePixelRatio || 1;
              
              function resizeCanvas() {
                  const rect = container.getBoundingClientRect();
                  canvas.width = rect.width * dpr;
                  canvas.height = 250 * dpr;
                  canvas.style.width = rect.width + 'px';
                  canvas.style.height = '250px';
                  
                  const ctx = canvas.getContext('2d');
                  ctx.scale(dpr, dpr);
              }
              
              resizeCanvas();
              
              const signaturePad = new SignaturePad(canvas, {
                  backgroundColor: 'rgb(255, 255, 255)',
                  penColor: 'rgb(0, 0, 0)',
                  throttle: 16
              });

              document.getElementById('clearSignature').addEventListener('click', function() {
                  signaturePad.clear();
                  document.getElementById('ttd').value = '';
              });

              document.querySelector('form').addEventListener('submit', function(e) {
                  if (signaturePad.isEmpty()) {
                      e.preventDefault();
                      Swal.fire({
                          icon: 'error',
                          title: 'Gagal!',
                          text: 'Silakan tandatangani pernyataan terlebih dahulu.',
                          confirmButtonColor: '{{ $site_setting->secondary_color ?? "#f84949e2" }}'
                      });
                      return false;
                  }
                  const dataUrl = signaturePad.toDataURL('image/png');
                  document.getElementById('ttd').value = dataUrl;
              });

              window.addEventListener('resize', function() {
                  resizeCanvas();
                  signaturePad.clear();
              });
          }

          document.addEventListener('DOMContentLoaded', initSignaturePad);
      </script>
      @endpush
@endsection
