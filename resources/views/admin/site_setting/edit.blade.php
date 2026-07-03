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
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection