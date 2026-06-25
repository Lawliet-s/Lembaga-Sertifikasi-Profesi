@extends('layout.asesi')

@section('sidebar')
    sidebar-mini
@endsection

@section('judul')
    FR.APL.01 - Permohonan Sertifikasi Kompetensi
@endsection

@section('isi')
<div class="container-fluid">
    <div class="page-header">
        <h4><i class="fas fa-file-alt"></i> FR.APL.01 — Permohonan Sertifikasi Kompetensi</h4>
        <p class="text-muted">Isi seluruh data dengan benar.</p>
    </div>

    <form action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data" id="formPermohonan">
        @csrf

        <div class="card shadow-sm rounded mb-4">
            <div class="card-body p-4">

                {{-- Data Pribadi --}}
                <h5 class="mb-4" style="color: var(--primary-color);">
                    <i class="fas fa-user"></i> Data Pribadi
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', Auth::user()->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik', Auth::user()->nik) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Kebangsaan <span class="text-danger">*</span></label>
                        <input type="text" name="kebangsaan" class="form-control" value="{{ old('kebangsaan', 'Indonesia') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Kode Pos <span class="text-danger">*</span></label>
                        <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">No. HP <span class="text-danger">*</span></label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', Auth::user()->no_hp) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Pendidikan <span class="text-danger">*</span></label>
                        <input type="text" name="pendidikan" class="form-control" value="{{ old('pendidikan') }}" required>
                    </div>
                </div>

                <hr class="my-5">

                {{-- Data Pekerjaan --}}
                <h5 class="mb-4" style="color: var(--primary-color);">
                    <i class="fas fa-briefcase"></i> Data Pekerjaan
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Nama Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Alamat Kantor <span class="text-danger">*</span></label>
                        <textarea name="alamat_kantor" class="form-control" rows="2" required>{{ old('alamat_kantor') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Kode Pos <span class="text-danger">*</span></label>
                        <input type="text" name="kode_pos_kantor" class="form-control" value="{{ old('kode_pos_kantor') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Telepon Kantor <span class="text-danger">*</span></label>
                        <input type="text" name="telepon_kantor" class="form-control" value="{{ old('telepon_kantor') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Email Kantor <span class="text-danger">*</span></label>
                        <input type="email" name="email_kantor" class="form-control" value="{{ old('email_kantor') }}" required>
                    </div>
                </div>

                <hr class="my-5">

                {{-- Skema Sertifikasi --}}
                <h5 class="mb-4" style="color: var(--primary-color);">
                    <i class="fas fa-tags"></i> Skema Sertifikasi
                </h5>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Pilih Skema Sertifikasi <span class="text-danger">*</span></label>
                        <select name="skema_id" id="skema_id" class="form-control" required onchange="loadUnitKompetensi(this.value)">
                            <option value="">-- Pilih Skema --</option>
                            @foreach ($skemas as $skema)
                                <option value="{{ $skema->id }}" {{ old('skema_id') == $skema->id ? 'selected' : '' }}>
                                    {{ $skema->kode_skema }} - {{ $skema->skema }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Tujuan Asesmen <span class="text-danger">*</span></label>
                        <select name="tujuan_asesmen" class="form-control" required>
                            <option value="">-- Pilih Tujuan Asesmen --</option>
                            <option value="sertifikasi" {{ old('tujuan_asesmen') == 'sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                            <option value="pkt" {{ old('tujuan_asesmen') == 'pkt' ? 'selected' : '' }}>PKT</option>
                            <option value="rpl" {{ old('tujuan_asesmen') == 'rpl' ? 'selected' : '' }}>RPL</option>
                            <option value="lainnya" {{ old('tujuan_asesmen') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>

                <hr class="my-5">

                {{-- Unit Kompetensi --}}
                <h5 class="mb-4" style="color: var(--primary-color);">
                    <i class="fas fa-list-check"></i> Unit Kompetensi
                </h5>
                <div id="unitContainer">
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-hand-pointer fa-2x mb-2"></i>
                        <p>Silakan pilih skema sertifikasi terlebih dahulu.</p>
                    </div>
                </div>

                <hr class="my-5">

                {{-- Upload Dokumen --}}
                <h5 class="mb-4" style="color: var(--primary-color);">
                    <i class="fas fa-upload"></i> Upload Dokumen
                </h5>
                <p class="text-muted small">Format: PDF, JPG, JPEG, PNG. Maksimal 2MB per file.</p>
                <div class="row g-3">
                    @php
                        $docs = [
                            'dokumen_sertifikat_pkl' => 'Sertifikat PKL / Pengalaman Kerja',
                            'dokumen_raport' => 'Raport / Ijazah',
                            'dokumen_kartu_keluarga' => 'Kartu Keluarga',
                            'dokumen_ktp' => 'KTP / Kartu Pelajar',
                            'dokumen_foto' => 'Pas Foto 3x4',
                        ];
                        $optional = ['dokumen_raport', 'dokumen_kartu_keluarga', 'dokumen_ktp'];
                    @endphp
                    @foreach ($docs as $field => $label)
                    <div class="col-md-6">
                        <div class="card border-dashed rounded p-3" style="border: 2px dashed #dee2e6;">
                            <label class="form-label small fw-bold mb-2">{{ $label }} @if (!in_array($field, $optional))<span class="text-danger">*</span>@else<small class="text-muted">(opsional)</small>@endif</label>
                            <div class="custom-file">
                                <input type="file" name="{{ $field }}" class="form-control-file" accept=".pdf,.jpg,.jpeg,.png" onchange="previewName(this, '{{ $field }}_name')">
                            </div>
                            <small class="text-muted file-name" id="{{ $field }}_name"></small>
                        </div>
                    </div>
                    @endforeach
                </div>

                <hr class="my-5">

                {{-- Tanda Tangan --}}
                <h5 class="mb-4" style="color: var(--primary-color);">
                    <i class="fas fa-pen"></i> Tanda Tangan
                </h5>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label small fw-bold">Tanda Tangan Pemohon <span class="text-danger">*</span></label>
                        <div class="border rounded p-2" style="background: #fff;">
                            <canvas id="signatureCanvas" width="600" height="200"
                                style="width: 100%; height: 200px; border: 1px solid #dee2e6; border-radius: 4px; cursor: crosshair; touch-action: none;"></canvas>
                        </div>
                        <input type="hidden" name="ttd" id="ttdInput">
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearSignature()">
                                <i class="fas fa-eraser"></i> Hapus Tanda Tangan
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-footer bg-white text-end px-4 py-3">
                <button type="submit" class="btn" style="background-color: var(--primary-color); color: #fff;" onclick="return saveSignature()">
                    <i class="fas fa-paper-plane"></i> Kirim Permohonan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Signature Pad
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    let drawing = false;
    let lastX = 0;
    let lastY = 0;

    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        return {
            x: (clientX - rect.left) * scaleX,
            y: (clientY - rect.top) * scaleY
        };
    }

    canvas.addEventListener('mousedown', (e) => {
        drawing = true;
        const pos = getPos(e);
        lastX = pos.x;
        lastY = pos.y;
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
    });

    canvas.addEventListener('mousemove', (e) => {
        if (!drawing) return;
        const pos = getPos(e);
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        lastX = pos.x;
        lastY = pos.y;
    });

    canvas.addEventListener('mouseup', () => { drawing = false; });
    canvas.addEventListener('mouseleave', () => { drawing = false; });

    canvas.addEventListener('touchstart', (e) => {
        e.preventDefault();
        drawing = true;
        const pos = getPos(e);
        lastX = pos.x;
        lastY = pos.y;
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
    });

    canvas.addEventListener('touchmove', (e) => {
        e.preventDefault();
        if (!drawing) return;
        const pos = getPos(e);
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        lastX = pos.x;
        lastY = pos.y;
    });

    canvas.addEventListener('touchend', (e) => { e.preventDefault(); drawing = false; });

    function clearSignature() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById('ttdInput').value = '';
    }

    function saveSignature() {
        const canvas = document.getElementById('signatureCanvas');
        const dataUrl = canvas.toDataURL('image/png');
        document.getElementById('ttdInput').value = dataUrl;

        const blank = canvas.toDataURL('image/png');
        const blankCanvas = document.createElement('canvas');
        blankCanvas.width = canvas.width;
        blankCanvas.height = canvas.height;
        const blankCtx = blankCanvas.getContext('2d');
        const blankData = blankCanvas.toDataURL('image/png');

        if (dataUrl === blankData) {
            alert('Silakan isi tanda tangan terlebih dahulu.');
            return false;
        }
        return true;
    }

    function loadUnitKompetensi(skemaId) {
        const container = document.getElementById('unitContainer');
        if (!skemaId) {
            container.innerHTML = `
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-hand-pointer fa-2x mb-2"></i>
                    <p>Silakan pilih skema sertifikasi terlebih dahulu.</p>
                </div>
            `;
            return;
        }

        container.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border" style="color: var(--primary-color);" role="status">
                    <span class="sr-only">Memuat...</span>
                </div>
                <p class="mt-2 text-muted">Memuat unit kompetensi...</p>
            </div>
        `;

        fetch('/get-unit-kompetensi/' + skemaId)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    container.innerHTML = `<div class="text-center py-4 text-muted"><p>Tidak ada unit kompetensi untuk skema ini.</p></div>`;
                    return;
                }
                let html = `<div class="table-responsive"><table class="table table-bordered table-hover mb-0">
                    <thead><tr>
                        <th>No</th>
                        <th>Kode Unit</th>
                        <th>Judul Unit</th>
                    </tr></thead><tbody>`;
                data.forEach((item, i) => {
                    html += `<tr>
                        <td>${i + 1}</td>
                        <td><code>${item.kode_unikom}</code></td>
                        <td>${item.unikom}</td>
                    </tr>`;
                });
                html += `</tbody></table></div>`;
                container.innerHTML = html;
            })
            .catch(() => {
                container.innerHTML = `<div class="text-center py-4 text-danger"><p>Gagal memuat data. Silakan coba lagi.</p></div>`;
            });
    }

    function previewName(input, targetId) {
        const target = document.getElementById(targetId);
        if (input.files && input.files[0]) {
            target.textContent = input.files[0].name;
        } else {
            target.textContent = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const skemaId = document.getElementById('skema_id').value;
        if (skemaId) loadUnitKompetensi(skemaId);
    });


</script>
@endpush
