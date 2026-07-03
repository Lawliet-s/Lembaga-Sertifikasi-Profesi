@extends('layout/admin')
@section('judul')
    Buat Pengaturan Situs | Admin LSP
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h4>
            <i class="fas fa-cogs"></i> Buat Pengaturan Situs
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom  bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('site_setting.index') }}">Pengaturan Situs</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Buat</li>
            </ol>
        </nav>
    </div><br>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Buat Pengaturan Situs</h4>
            <form action="{{ route('site_setting.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo">Logo 1</label>
                            <input type="file" name="logo" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo2">Logo 2</label>
                            <input type="file" name="logo2" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo3">Logo 3</label>
                            <input type="file" name="logo3" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo4">Logo 4</label>
                            <input type="file" name="logo4" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="favicon">Favicon</label>
                            <input type="file" name="favicon" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="header_image">Header Image</label>
                            <input type="file" name="header_image" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="background_image">Background Image (Layanan)</label>
                            <input type="file" name="background_image" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="footer_text">Footer Text</label>
                            <textarea name="footer_text" class="form-control" rows="4">{{ old('footer_text') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea name="address" class="form-control" rows="4">{{ old('address') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="maps_embed">Link Google Maps</label>
                            <input type="url" name="maps_embed" class="form-control" value="{{ old('maps_embed') }}" placeholder="https://maps.google.com/?q=...">
                            <small class="form-text text-muted">Paste link Google Maps biasa (contoh: <code>https://maps.app.goo.gl/xxx</code>) nanti muncul tombol "Buka Peta". Untuk tampilan peta langsung, gunakan embed link dari Google Maps (Share → Embed a map → ambil URL <code>src="..."</code>-nya).</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="instagram">Instagram</label>
                            <input type="text" name="instagram" class="form-control" value="{{ old('instagram') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="text" name="facebook" class="form-control" value="{{ old('facebook') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="twitter">Twitter</label>
                            <input type="text" name="twitter" class="form-control" value="{{ old('twitter') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="primary_color">Warna Utama (Primary)</label>
                            <input type="color" name="primary_color" class="form-control form-control-color" value="{{ old('primary_color', '#9b0000e2') }}" style="height: 40px; padding: 5px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="secondary_color">Warna Sekunder (Secondary)</label>
                            <input type="color" name="secondary_color" class="form-control form-control-color" value="{{ old('secondary_color', '#f84949e2') }}" style="height: 40px; padding: 5px;">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection
