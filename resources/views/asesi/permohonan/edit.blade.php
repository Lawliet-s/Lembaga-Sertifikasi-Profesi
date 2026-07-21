@extends('layout.asesi')

@section('sidebar')
    sidebar-mini
@endsection

@section('judul')
    Edit Permohonan - {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('isi')
<div class="container-fluid">
    <div class="page-header">
        <h4><i class="fas fa-edit"></i> Edit Permohonan Sertifikasi</h4>
    </div>

    <form action="{{ route('permohonan.update', $permohonan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm rounded mb-4">
                    <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
                        <i class="fas fa-user"></i> Data Pribadi
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', optional($permohonan->dataPribadi)->nama_lengkap) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control" value="{{ old('nik', optional($permohonan->dataPribadi)->nik) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', optional($permohonan->dataPribadi)->tempat_lahir) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', optional($permohonan->dataPribadi)->tanggal_lahir) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ (optional($permohonan->dataPribadi)->jenis_kelamin ?? old('jenis_kelamin')) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ (optional($permohonan->dataPribadi)->jenis_kelamin ?? old('jenis_kelamin')) === 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Kebangsaan <span class="text-danger">*</span></label>
                                <input type="text" name="kebangsaan" class="form-control" value="{{ old('kebangsaan', optional($permohonan->dataPribadi)->kebangsaan) }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', optional($permohonan->dataPribadi)->alamat) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Kode Pos <span class="text-danger">*</span></label>
                                <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos', optional($permohonan->dataPribadi)->kode_pos) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">No. HP <span class="text-danger">*</span></label>
                                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', optional($permohonan->dataPribadi)->no_hp) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', optional($permohonan->dataPribadi)->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Pendidikan <span class="text-danger">*</span></label>
                                <select name="pendidikan" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach (['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3'] as $pend)
                                        <option value="{{ $pend }}" {{ old('pendidikan', optional($permohonan->dataPribadi)->pendidikan) === $pend ? 'selected' : '' }}>{{ $pend }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm rounded mb-4">
                    <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
                        <i class="fas fa-briefcase"></i> Data Pekerjaan
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Perusahaan <span class="text-danger">*</span></label>
                                <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan', optional($permohonan->pekerjaan)->nama_perusahaan) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Jabatan <span class="text-danger">*</span></label>
                                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', optional($permohonan->pekerjaan)->jabatan) }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Alamat Kantor <span class="text-danger">*</span></label>
                                <textarea name="alamat_kantor" class="form-control" rows="2" required>{{ old('alamat_kantor', optional($permohonan->pekerjaan)->alamat_kantor) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Kode Pos <span class="text-danger">*</span></label>
                                <input type="text" name="kode_pos_kantor" class="form-control" value="{{ old('kode_pos_kantor', optional($permohonan->pekerjaan)->kode_pos_kantor) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Telepon Kantor <span class="text-danger">*</span></label>
                                <input type="text" name="telepon_kantor" class="form-control" value="{{ old('telepon_kantor', optional($permohonan->pekerjaan)->telepon_kantor) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Email Kantor <span class="text-danger">*</span></label>
                                <input type="email" name="email_kantor" class="form-control" value="{{ old('email_kantor', optional($permohonan->pekerjaan)->email_kantor) }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm rounded mb-4">
                    <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
                        <i class="fas fa-tags"></i> Skema Sertifikasi
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Skema <span class="text-danger">*</span></label>
                                <select name="skema_id" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($skemas as $skema)
                                        <option value="{{ $skema->id }}" {{ old('skema_id', $permohonan->skema_id) == $skema->id ? 'selected' : '' }}>
                                            {{ $skema->kode_skema }} - {{ $skema->skema }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Tujuan Asesmen <span class="text-danger">*</span></label>
                                <select name="tujuan_asesmen" class="form-control" required>
                                    <option value="">-- Pilih Tujuan Asesmen --</option>
                                    <option value="sertifikasi" {{ old('tujuan_asesmen', $permohonan->tujuan_asesmen) == 'sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                                    <option value="pkt" {{ old('tujuan_asesmen', $permohonan->tujuan_asesmen) == 'pkt' ? 'selected' : '' }}>PKT</option>
                                    <option value="rpl" {{ old('tujuan_asesmen', $permohonan->tujuan_asesmen) == 'rpl' ? 'selected' : '' }}>RPL</option>
                                    <option value="lainnya" {{ old('tujuan_asesmen', $permohonan->tujuan_asesmen) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm rounded mb-4">
                    <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
                        <i class="fas fa-upload"></i> Upload Dokumen
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Kosongkan jika tidak ingin mengganti file yang sudah ada.</p>
                        <div class="row g-3">
                            @php
                                $docs = [
                                    'dokumen_sertifikat_pkl' => 'Sertifikat PKL / Pengalaman Kerja',
                                    'dokumen_raport' => 'Raport / Ijazah',
                                    'dokumen_kartu_keluarga' => 'Kartu Keluarga',
                                    'dokumen_ktp' => 'KTP / Kartu Pelajar',
                                    'dokumen_foto' => 'Pas Foto 3x4',
                                ];
                            @endphp
                            @foreach ($docs as $field => $label)
                            <div class="col-md-6">
                                <div class="card border-dashed rounded p-3" style="border: 2px dashed #dee2e6;">
                                    <label class="form-label small fw-bold mb-2">{{ $label }}</label>
                                    <input type="file" name="{{ $field }}" class="form-control-file" accept=".pdf,.jpg,.jpeg,.png">
                                    @php
                                        $existing = $permohonan->dokumens->where('jenis_dokumen', str_replace('dokumen_', '', $field))->first();
                                    @endphp
                                    @if ($existing)
                                        <small class="text-success">
                                            <i class="fas fa-check-circle"></i> {{ $existing->nama_file }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('permohonan.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn" style="background-color: var(--primary-color); color: #fff;">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
