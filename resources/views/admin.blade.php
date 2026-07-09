@extends('layout.admin')

@section('judul')
Dashboard | Admin LSP {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}   
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    {{-- <---------------------- PAGE HEADER ----------------------> --}}
    <div class="page-header">
        <h4>
            <i class="fas fa-chart-pie"></i> Dashboard
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom  bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('admin') }}">{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div><br>

    {{-- <---------------------- STATISTIK ASESI ----------------------> --}}
    <div class="card card-statistics">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm far fa-address-card mr-2"></i>
                        Registrasi Terbaru
                    </p>
                    <h2 class="text text-center counter-value">{{ $databaru }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-hourglass-half mr-2"></i>
                        Proses Sertifikasi
                    </p>
                    <h2 class="text text-center counter-value">{{ $datavalid }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-times mr-2"></i>
                        Registrasi ditolak
                    </p>
                    <h2 class="text text-center counter-value">{{ $datatolak }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fa fa-id-badge mr-2"></i>
                        Jumlah Asesi
                    </p>
                    <h2 class="text text-center  counter-value">{{ $datareg }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-users mr-2"></i>
                        Jumlah Pengguna
                    </p>
                    <h2 class="text text-center counter-value">{{ $datauser }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-certificate mr-2"></i>
                        Pemegang Sertifikat
                    </p>
                    <h2 class="text text-center  counter-value">{{ $datasertifikat }}</h2>
                </div>
            </div>
        </div>
    </div><br>

    {{-- <---------------------- STATISTIK ADMIN ----------------------> --}}
    <div class="row">
        <div class="counter">
            <div class="counter-icon">
                <i class="fa fa-suitcase"></i>
            </div>
            <div class="counter-content">
                <h3>Skema</h3>
                <span class="counter-value">{{ $dataskema }}</span>
            </div>
        </div>
        <div class="counter blue">
            <div class="counter-icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="counter-content">
                <h3>Asesor</h3>
                <span class="counter-value">{{ $dataasesor }}</span>
            </div>
        </div>
        <div class="counter green">
            <div class="counter-icon">
                <i class="fa fa-building"></i>
            </div>
            <div class="counter-content">
                <h3>TUK</h3>
                <span class="counter-value">{{ $datatuk }}</span>
            </div>
        </div>
    </div><br>



    {{-- <---------------------- PEMEGANG SERTIFIKAT ----------------------> --}}
    <div class="row">
        {{-- PEMEGANG SERTIFIKAT --}}
        <div class="col-md-7 grid-margin grid-margin-md-0 stretch-card">
            <div class="card">
                <div style="background-color: var(--secondary-color) " class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="text text-white"><i class="fas fa-certificate"></i> Pemegang Sertifikat</h5>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($datapemegang as $asu)
                        <div class="list d-flex align-items-center border-bottom py-3">
                            <img class="img-sm rounded-circle" src="{{ $asu->image }}" alt="">
                            <div class="wrapper w-100 ml-3">
                                <p class="mb-0"><b>{{ $asu->user_name }} </b></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-certificate text-muted mr-1"></i>
                                        <p class="mb-0">{{ $asu->skema_name }}</p>
                                    </div>
                                    <small class="text-muted ml-auto">{{ $asu->updated_at->diffforhumans() }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- JADWAL ASESMEN --}}
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="text text-dark">
                            <i class="fas fa-calendar-alt"></i> Jadwal Asesmen
                        </h4>
                    </div>
                    @php
                        $totalJadwal = App\Models\JadwalAsesmen::where('status', 'aktif')->where('tanggal', '>=', now())->count();
                        $bulanIni = App\Models\JadwalAsesmen::where('status', 'aktif')
                            ->whereMonth('tanggal', now()->month)
                            ->whereYear('tanggal', now()->year)
                            ->count();
                    @endphp
                    <div class="row">
                        <div class="col-6 text-center">
                            <h2 class="text-primary font-weight-bold">{{ $totalJadwal }}</h2>
                            <p class="text-muted mb-0">Total Jadwal Aktif</p>
                        </div>
                        <div class="col-6 text-center">
                            <h2 class="text-success font-weight-bold">{{ $bulanIni }}</h2>
                            <p class="text-muted mb-0">Bulan Ini</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('jadwal.index') }}" class="btn btn-danger btn-block">
                            <i class="fas fa-calendar-alt"></i> Kelola Jadwal Asesmen
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div><br><br>


    {{-- <---------------------- FOOTER ----------------------> --}}
    {{-- <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="statistics-item">
                        <div class="card-img">
                            <img src="{{ asset('general/assets/images/bnsp.png') }}" width="150px" alt="">
                        </div>
                    </div>
                    <div class="statistics-item">
                        <div class="card-img">
                            <img src="{{ asset('general/assets/images/kemendikbud_small.png') }}" width="90px" alt="">
                        </div>
                    </div>
                    <div class="statistics-item">
                        <div class="card-img" style="display: flex; justify-content: center; gap: 10px;">
                            @forelse ($logos as $logo)
                                <img src="{{ asset($logo) }}" alt="" style="max-height: 90px; width: auto;">
                            @empty
                                <img src="{{ asset('assets/images/logo/lsp1.png') }}" alt="" style="max-height: 90px; width: auto;">
                            @endforelse
                        </div>
                    </div>
                    <div class="statistics-item">
                        <div class="card-img">
                            <img src="{{ asset('general/assets/images/lsp_small.jpg') }}" width="110px" alt="">
                        </div>
                    </div>
                    <div class="statistics-item">
                        <h5>Kontak Admin</h5>
                        <p>
                        <ul>
                            <li><i class="icon-sm far fa-comment mr-2"></i>08965386474683</li>
                            <li><i class="icon-sm far fa-envelope mr-2"></i>{{ $site_setting->email ?? 'info@lsp.com' }}</li>
                            <li><i class="icon-sm fab fa-instagram mr-2"></i>
                                <a href="{{ $site_setting->instagram ?? '#' }}" target="_blank">{{ $site_setting->instagram ?? 'Instagram' }}
                            </li>
                            </a>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
