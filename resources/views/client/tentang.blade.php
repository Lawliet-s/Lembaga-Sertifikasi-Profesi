@extends('layout.client')
@section('judul')
    Tentang | LSP
@endsection
@section('profil')
    active
@endsection
@section('isi')
    <!-- ***** Header ***** -->
    <div style="background-image: url('{{ asset($site_setting->header_image ?? 'general/assets/images/head1.jpg') }}')" class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</h1>
                    <span>
                        <a href="#profil">Profil singkat</a> /
                        <a href="#visi">Visi</a> /
                        <a href="#visi">Misi</a> /
                        <a href="#visi">Motto</a> /
                        <a href="#logo">Logo</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Akhir Header ***** -->

    <!-- ***** Koten ***** -->
    <!-- Profil singkat -->
    <div  class="more-info">
        <div class="container">
            <div id="profil" class="section-heading">
                <h2>Tentang {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}<em></em></h2>
                <span>▬▬▬▬▬<em>▬▬▬▬▬</em></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="more-info-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="left-content">
                                    <span>{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</span>
                                    <div class="u-custom-font u-font-arial u-text u-text-2"
                                        data-animation-name="customAnimationIn" data-animation-duration="1000">
                                        {!! $profil->profil ?? '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visi misi motto -->
    <div id="visi" class="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Visi, Misi & Motto<em></em></h2>
                        <span>▬▬▬▬▬<em>▬▬▬▬▬</em></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="testimonial-item">
                        <div class="inner-content">
                            <h4>Visi</h4>
                            {!! $profil->visi ?? '' !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-item">
                        <div class="inner-content">
                            <h4>Misi</h4>
                            {!! $profil->misi ?? '' !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-item">
                        <div class="inner-content">
                            <h4>Motto</h4>
                            {!! $profil->motto ?? '' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br><br><br><br>
    <!-- ***** Akhir Konten ***** -->
@endsection

@section('css')
<style>
    .more-info .left-content .u-custom-font {
        text-align: left;
    }
    .more-info .left-content ul,
    .more-info .left-content ol {
        list-style: revert;
        padding-left: 40px;
    }
    @media (max-width: 992px) {
        .more-info .left-content {
            text-align: left;
        }
    }
</style>
@endsection
