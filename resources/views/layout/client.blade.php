<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">

    <title>@yield('judul')</title>
    <link rel="shortcut icon" href="{{ asset(optional($site_setting)->favicon ?? 'general/assets/images/shortcut.jpg') }}" />

    <!-- Bootstrap & CSS Utama -->
    <link href="{{ asset('general/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- Tambahan CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('general/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('general/assets/css/lsp.css') }}">
    <link rel="stylesheet" href="{{ asset('general/assets/css/owl.css') }}">

    <!-- CSS Spesial -->
    @yield('css')

    <!-- Warna Dinamis dari Pengaturan Situs -->
    <style>
        :root {
            --primary-color: {{ $site_setting->primary_color ?? '#9b0000e2' }};
            --secondary-color: {{ $site_setting->secondary_color ?? '#f84949e2' }};
        }
    </style>

    <!-- Flip Card -->
    <style>
        .flip-card {
            background-color: transparent;
            width: 100%;
            max-width: 260px;
            height: 330px;
            perspective: 1000px;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .flip-card:hover .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .flip-card-front {
            background-color: rgba(75, 69, 69, 0.463);
            color: rgb(255, 255, 255);
        }

        .flip-card-back {
            background-color: var(--primary-color);
            color: white;
            transform: rotateY(180deg);
        }
    </style>

    <!-- Dropdown menu -->
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--primary-color);
            min-width: 200px;
            white-space: nowrap;
            box-shadow: 0px 8px 16px 0px rgba(41, 32, 32, 0.46);
            z-index: 99999;
        }

        .dropdown-content a {
            color: rgb(255, 255, 255);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .dropdown-content a:hover {
            background-color: rgb(0, 0, 0);
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #05040400;
        }

        @media (max-width: 991px) {
            .dropdown-content {
                position: static;
                min-width: 100%;
                transform: none;
                box-shadow: none;
                background-color: var(--secondary-color);
            }
        }
    </style>
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <ul class="left-info">
                        <li><a href="#"><i class="fa fa-university"></i>{{ optional($site_setting)->title ?? 'Lembaga Sertifikasi Profesi' }}</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="right-icons">
                        @if(optional($site_setting)->instagram)
                        <li><a rel="nofollow" href="{{ optional($site_setting)->instagram }}" target="_blank"><i
                                    class="fa fa-instagram"></i></a></li>
                        @endif
                        @if(optional($site_setting)->twitter)
                        <li><a href="{{ optional($site_setting)->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        @endif
                        @if(optional($site_setting)->facebook)
                        <li><a href="{{ optional($site_setting)->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <header class="">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <ul style="display: flex; flex-wrap: wrap; align-items: center; justify-content: center; list-style: none; margin: 0; padding: 0;">
                    @forelse ($logos as $logo)
                        <li class="nav-item" style="margin: 3px;">
                            <img src="{{ asset($logo) }}" alt="logo" style="max-height: 45px; width: auto;">
                        </li>
                    @empty
                        <li class="nav-item" style="margin: 3px;">
                            <img src="{{ asset('assets/images/logo/lsp1.png') }}" alt="logo" style="max-height: 45px; width: auto;">
                        </li>
                    @endforelse
                </ul>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="dropdown @yield('home') nav-item">
                            <a class="nav-link dropbtn" href="{{ route('/') }}">HOME</a>
                        </li>
                        <li class="nav-item @yield('profil') dropdown">
                            <a class="nav-link dropbtn">PROFIL <i class="fa  fa-chevron-down"></i></a>
                            <div class="dropdown-content">
                                <a href="{{ route('tentang') }}">Tentang LSP</a>
                                <a href="{{ route('struktur') }}">Struktur Organisasi</a>
                                <a href="{{ route('pengelola') }}">Pengelola LSP</a>
                            </div>
                        </li>
                        <li class="nav-item @yield('layanan') dropdown">
                            <a class="nav-link dropbtn">LAYANAN <i class="fa  fa-chevron-down"></i></a>
                            <div class="dropdown-content">
                                <a href="{{ route('client_skema') }}">Skema</a>
                                <a href="{{ route('client_tuk') }}">Tempat
                                    Uji Kompetensi</a>
                                <a href="{{ route('client_asesor') }}">Asesor</a>
                                <a href="{{ route('tutorial') }}">Prosedur Pendaftaran
                                    Sertifikasi</a>
                            </div>
                        </li>
                        <li class="nav-item @yield('berita')">
                            <a class="nav-link" href="{{ route('client_berita') }}">BERITA</a>
                        </li>
                        <li class="nav-item @yield('galeri')">
                            <a class="nav-link" href="{{ route('client_galeri') }}">GALERI</a>
                        </li>
                        <li class="nav-item @yield('download')">
                            <a class="nav-link" href="{{ route('download') }}">DOKUMEN</a>
                        </li>
                        @if (Auth::user())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropbtn" style="color: var(--primary-color)"><i class="fa fa-user"></i>
                                {{ Auth::user()->role }}
                                </a>
                                <div class="dropdown-content">
                                    @if(Auth::user()->hasRole('admin'))
                                        <a href="{{ route('admin') }}">Dashboard Admin</a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">Logout</a>
                                    @elseif(Auth::user()->role === 'asesor')
                                        <a href="{{ route('dashboard.asesor') }}">Dashboard Asesor</a>
                                        <a href="{{ route('asesor.logout') }}"
                                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">Logout</a>
                                    @else
                                        <a href="{{ route('dashasesi.index') }}">Dashboard Asesi</a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">Logout</a>
                                    @endif
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" style="color: var(--primary-color)" href="{{ route('login') }}"><i class="fa fa-user"></i> LOGIN</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- ***** Bagian Konten Dimulai ***** -->
    @yield('isi')
    <!-- ***** Bagian Akhir Konten Dimulai ***** -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3 footer-item">
                    <h4><i class="fa fa-mobile-phone"></i> Kontak Admin</h4>
                    <ul class="menu-list">
                        @if(optional($site_setting)->phone)
                        <li><i class="fa fa-whatsapp"></i> Whatsapp : {{ optional($site_setting)->phone }}</li>
                        @endif
                        @if(optional($site_setting)->email)
                        <li><i class="fa fa-envelope"></i> Email : {{ optional($site_setting)->email }}</li>
                        @endif
                    </ul>
                    <ul class="social-icons">
                        @if(optional($site_setting)->instagram)
                        <li><a rel="nofollow" href="{{ optional($site_setting)->instagram }}" target="_blank"><i
                                    class="fa fa-instagram"></i></a></li>
                        @endif
                        @if(optional($site_setting)->twitter)
                        <li><a href="{{ optional($site_setting)->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        @endif
                        @if(optional($site_setting)->facebook)
                        <li><a href="{{ optional($site_setting)->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        @endif
                    </ul>
                </div>
                <div class="col-md-3 footer-item">
                    <h4><i class="fa fa-map-marker"></i> Alamat</h4>
                    <p>{!! nl2br(e(optional($site_setting)->address ?? 'Alamat LSP')) !!}</p>
                </div>
                <div class="col-md-3 footer-item last-item">
                    <div class="contact-form">
                        <form id="contact footer-contact" action="" method="post">
                            @php
                                $mapsUrl = optional($site_setting)->maps_embed;
                            @endphp
                            @if ($mapsUrl)
                                <iframe src="{{ $mapsUrl }}" width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            @else
                                <iframe src="https://www.google.com/maps?q=Indonesia&output=embed" width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>{!! optional($site_setting)->footer_text ?? 'Copyright © 2022 &diamondsuit; All Right Reserved' !!}<br>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap & Jquery Script -->
    <script src="{{ asset('general/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('general/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scrip tambahan -->
    <script src="{{ asset('general/assets/js/custom.js') }}"></script>
    <script src="{{ asset('general/assets/js/owl.js') }}"></script>
    <script src="{{ asset('general/assets/js/slick.js') }}"></script>
    <script src="{{ asset('general/assets/js/accordions.js') }}"></script>

    <!-- Scrip tambahan -->
    @yield('javascript')


    <script language="text/Javascript">
        cleared[0] = cleared[1] = cleared[2] = 0;

        function clearField(t) {
            if (!cleared[t.id]) {
                cleared[t.id] = 1;
                t.value = ''; // with more chance of typos
                t.style.color = '#fff';
            }
        }
    </script>
</body>

</html>
