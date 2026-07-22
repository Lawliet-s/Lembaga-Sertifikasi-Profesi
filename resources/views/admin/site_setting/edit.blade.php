@extends('layout/admin')
@section('judul')
    Edit Pengaturan Situs | Admin LSP
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    @include('layout/verifikasi')
    {{-- <---------------------- PAGE HEADER ----------------------> --}}
    <div class="page-header">
        <h4>
            <i class="fas fa-cogs"></i> Edit Pengaturan Situs
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom  bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('site_setting.index') }}">Pengaturan Situs</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div><br>

    {{-- <---------------------- EDIT FORM ----------------------> --}}
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Pengaturan Situs</h4>
            <form action="{{ route('site_setting.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $setting->title }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo">Logo 1</label>
                            <input type="file" name="logo" class="form-control">
                            @if($setting->logo)
                                <img src="{{ asset($setting->logo) }}" width="100" alt="Current Logo">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo2">Logo 2</label>
                            <input type="file" name="logo2" class="form-control">
                            @if($setting->logo2)
                                <img src="{{ asset($setting->logo2) }}" width="100" alt="Current Logo 2">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo3">Logo 3</label>
                            <input type="file" name="logo3" class="form-control">
                            @if($setting->logo3)
                                <img src="{{ asset($setting->logo3) }}" width="100" alt="Current Logo 3">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo4">Logo 4</label>
                            <input type="file" name="logo4" class="form-control">
                            @if($setting->logo4)
                                <img src="{{ asset($setting->logo4) }}" width="100" alt="Current Logo 4">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="favicon">Favicon</label>
                            <input type="file" name="favicon" class="form-control">
                            @if($setting->favicon)
                                <img src="{{ asset($setting->favicon) }}" width="50" alt="Current Favicon">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="header_image">Header Image</label>
                            <input type="file" name="header_image" class="form-control">
                            @if($setting->header_image)
                                <img src="{{ asset($setting->header_image) }}" width="100" alt="Current Header Image">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="background_image">Background Image (Layanan)</label>
                            <input type="file" name="background_image" class="form-control">
                            @if($setting->background_image)
                                <img src="{{ asset($setting->background_image) }}" width="100" alt="Current Background Image">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="about_image">Gambar Tentang Kami (Beranda)</label>
                            <input type="file" name="about_image" class="form-control">
                            <small class="form-text text-muted">Gambar besar di bagian kiri section "Tentang Kami" pada halaman beranda.</small>
                            @if($setting->about_image)
                                <img src="{{ asset($setting->about_image) }}" width="100" alt="Current About Image">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="footer_text">Footer Text</label>
                            <textarea name="footer_text" class="form-control" rows="4">{{ $setting->footer_text }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea name="address" class="form-control" rows="4">{{ $setting->address }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="maps_embed">Link Google Maps</label>
                            <input type="url" name="maps_embed" class="form-control" value="{{ $setting->maps_embed }}" placeholder="https://maps.google.com/?q=...">
                            <small class="form-text text-muted">Paste link Google Maps biasa (contoh: <code>https://maps.app.goo.gl/xxx</code>) nanti muncul tombol "Buka Peta". Untuk tampilan peta langsung, gunakan embed link dari Google Maps (Share → Embed a map → ambil URL <code>src="..."</code>-nya).</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $setting->phone }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $setting->email }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="instagram">Instagram</label>
                            <input type="text" name="instagram" class="form-control" value="{{ $setting->instagram }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="text" name="facebook" class="form-control" value="{{ $setting->facebook }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="twitter">Twitter</label>
                            <input type="text" name="twitter" class="form-control" value="{{ $setting->twitter }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="primary_color">Warna Utama (Primary)</label>
                            <input type="color" name="primary_color" class="form-control form-control-color" value="{{ $setting->primary_color ?? '#9b0000e2' }}" style="height: 40px; padding: 5px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="secondary_color">Warna Sekunder (Secondary)</label>
                            <input type="color" name="secondary_color" class="form-control form-control-color" value="{{ $setting->secondary_color ?? '#f84949e2' }}" style="height: 40px; padding: 5px;">
                        </div>
                    </div>
                </div>

                {{-- Tanda Tangan Kepala LSP --}}
                <h5 class="card-title mt-4">Tanda Tangan Kepala LSP</h5>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="kepala_lsp_name">Nama Kepala LSP</label>
                            <input type="text" name="kepala_lsp_name" class="form-control" value="{{ old('kepala_lsp_name', $setting->kepala_lsp_name) }}">
                            @error('kepala_lsp_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="foto_signature">Upload Foto Tanda Tangan</label>
                            <input type="file" name="foto_signature" class="form-control" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                            @error('foto_signature')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @if($setting->foto_signature)
                                <div class="mt-2">
                                    <img src="{{ asset($setting->foto_signature) }}" width="100" alt="Current Foto Tanda Tangan">
                                    <div class="form-check mt-1">
                                        <input type="checkbox" class="form-check-input" name="clear_foto_signature" value="1" id="clear_foto_signature">
                                        <label class="form-check-label" for="clear_foto_signature">Hapus Foto Tanda Tangan</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection