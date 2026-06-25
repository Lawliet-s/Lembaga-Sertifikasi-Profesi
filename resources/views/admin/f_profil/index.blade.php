@extends('layout.admin')

@section('judul')
    Profil {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
@endsection

@section('sidebar')
    sidebar-icon-only
@endsection

@section('isi')
    @include('layout/verifikasi')
    <style>
        .card-body img {
            max-width: 100%;
            height: auto;
        }
        .card-body {
            overflow-x: hidden;
        }
        @media (max-width: 768px) {
            .card-body {
                padding: 15px !important;
            }
        }
    </style>
    {{-- <---------------------- PAGE HEADER ----------------------> --}}
    <div class="page-header">
        <h3>
            <i class="fas fa-cogs"></i> Settingan Profil
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom  bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Settingan Profil</li>
            </ol>
        </nav>
    </div><br>


    {{-- <---------------------- SETTING PROFIL ----------------------> --}}
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">SETTING PROFIL</h4>
            @forelse ($profil as $asu)
                <div class="faq-section">
                    <div class="container-fluid py-2">
                        <a href="{{ route('f_profil.edit', Crypt::encryptString($asu->id)) }}">
                            <button type="button" class="btn btn-warning btn-icon-text">
                                <i class="far fa-edit btn-icon-prepend"></i>
                                Setting Halaman Profil
                            </button>
                        </a>
                    </div>
                    <div id="accordion-1" class="accordion accordion-solid-header">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h4 class="mb-0">
                                    <a data-toggle="collapse" data-target="#collapseOne2" aria-expanded="true"
                                        aria-controls="collapseOne2">
                                        Profil {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne2" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordion-1">
                                <div class="card-body">
                                    {!! $asu->profil !!}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="true"
                                        aria-controls="collapseTwo3">
                                        Visi {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion-1">
                                <div class="card-body">
                                    {!! $asu->visi !!}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-target="#collapseThree4" aria-expanded="true"
                                        aria-controls="collapseThree4">
                                        Misi {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseThree4" class="collapse" aria-labelledby="headingThree"
                                data-parent="#accordion-1">
                                <div class="card-body">
                                    {!! $asu->misi !!}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree5">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-target="#collapse45" aria-expanded="true"
                                        aria-controls="collapseThree">
                                        Motto {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse45" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-1">
                                <div class="card-body">
                                    {!! $asu->motto !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-4">
                    <p class="text-muted">Belum ada data profil.</p>
                    <a href="{{ route('f_profil.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Profil
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
