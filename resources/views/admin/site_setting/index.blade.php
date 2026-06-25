@extends('layout/admin')
@section('judul')
    Pengaturan Situs | Admin LSP
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    @include('layout/verifikasi')
    {{-- <---------------------- PAGE HEADER ----------------------> --}}
    <div class="page-header">
        <h4>
            <i class="fas fa-cogs"></i> Pengaturan Situs
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom  bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Pengaturan Situs</li>
            </ol>
        </nav>
    </div><br>

    {{-- <---------------------- SETTING ----------------------> --}}
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Pengaturan Situs</h4>
            @if($setting)
                <a href="{{ route('site_setting.edit', Crypt::encryptString($setting->id)) }}" class="btn btn-warning btn-icon-text">
                    <i class="far fa-edit btn-icon-prepend"></i> Edit Pengaturan
                </a>
                <br><br>
                <table class="table table-bordered">
                    <tr>
                        <th>Logo</th>
                        <td><img src="{{ asset($setting->logo) }}" width="100" alt="Logo"></td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $setting->title }}</td>
                    </tr>
                    <tr>
                        <th>Favicon</th>
                        <td><img src="{{ asset($setting->favicon) }}" width="50" alt="Favicon"></td>
                    </tr>
                    <tr>
                        <th>Header Image</th>
                        <td><img src="{{ asset($setting->header_image) }}" width="150" alt="Header Image"></td>
                    </tr>
                    <tr>
                        <th>Background Image (Layanan)</th>
                        <td><img src="{{ asset($setting->background_image) }}" width="150" alt="Background Image"></td>
                    </tr>
                    <tr>
                        <th>Footer Text</th>
                        <td>{{ $setting->footer_text }}</td>
                    </tr>
                    <tr>
                        <th>Maps Embed</th>
                        <td><a href="{{ $setting->maps_embed }}" target="_blank" class="text-primary">{{ $setting->maps_embed }}</a></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $setting->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $setting->phone }}</td>
                    </tr>
                    <tr>
                        <th>Instagram</th>
                        <td>{{ $setting->instagram }}</td>
                    </tr>
                    <tr>
                        <th>Facebook</th>
                        <td>{{ $setting->facebook }}</td>
                    </tr>
                    <tr>
                        <th>Twitter</th>
                        <td>{{ $setting->twitter }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $setting->email }}</td>
                    </tr>
                    <tr>
                        <th>Warna Utama (Primary)</th>
                        <td><span style="display:inline-block;width:30px;height:30px;background:{{ $setting->primary_color ?? '#9b0000e2' }};border-radius:4px;vertical-align:middle;margin-right:8px;"></span> {{ $setting->primary_color ?? '#9b0000e2' }}</td>
                    </tr>
                    <tr>
                        <th>Warna Sekunder (Secondary)</th>
                        <td><span style="display:inline-block;width:30px;height:30px;background:{{ $setting->secondary_color ?? '#f84949e2' }};border-radius:4px;vertical-align:middle;margin-right:8px;"></span> {{ $setting->secondary_color ?? '#f84949e2' }}</td>
                    </tr>
                </table>
            @else
                <p>Belum ada pengaturan. <a href="{{ route('site_setting.create') }}">Buat baru</a></p>
            @endif
        </div>
    </div>
@endsection