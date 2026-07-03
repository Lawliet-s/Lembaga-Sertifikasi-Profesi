<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth.css')}}">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/shotcut.jpg') }}" />
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/vendor.bundle.addons.js') }}"></script>
    <style>
        :root {
            --primary-color: {{ $site_setting->primary_color ?? '#9b0000e2' }};
            --secondary-color: {{ $site_setting->secondary_color ?? '#f84949e2' }};
        }
        .btn-danger {
            color: #fff;
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        .btn-danger:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
    </style>
</head>

<body>
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-6 px-0">
                    <div class="card1" style="background: url('{{ asset('assets/images/auth/register.jpg') }}') center center / cover no-repeat;"></div>
                </div>
                <div class="col-lg-6">
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        <input type="hidden" name="role" value="User">
                        <div class="card2 card border-0 px-4 py-5">
                            <div class="row px-3 mt-4 mb-2 border-line" style="display: flex; justify-content: center; gap: 15px;">
                                @forelse ($logos as $logo)
                                    <img src="{{ asset($logo) }}" class="logo2" style="max-height: 60px; width: auto;">
                                @empty
                                    <img src="{{ asset('assets/images/logo/lsp1.png') }}" class="logo2" style="width: auto;">
                                @endforelse
                                <br><br>
                            </div>
                            <div class="row mb-4 px-3">
                                <h6 class="mb-0 mr-4 mt-2">{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</h6>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-dismissible fade show" role="alert" style="background-color: var(--secondary-color); color: #fff;">
                                    <strong>Pendaftaran gagal!</strong> Silakan periksa kembali data Anda.
                                    <ul class="mb-0 mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="row px-3">
                                <label class="mb-1"><h6 class="mb-0 text-sm">Email</h6></label>
                                <input type="email" required maxlength="255" name="email" class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row px-3">
                                <label class="mb-1"><h6 class="mb-0 text-sm">Password</h6></label>
                                <input type="password" required autocomplete="new-password" class="form-control @error('password') is-invalid @enderror" name="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row px-3">
                                <label class="mb-1"><h6 class="mb-0 text-sm">Password Konfirmasi</h6></label>
                                <input type="password" name="password_confirmation" required autocomplete="new-password" class="form-control" id="exampleInputPassword">
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @include('partials.honeypot')
                            <div class="row mb-3 px-3">
                                <button type="submit" class="btn btn-block btn-danger text-center">Daftar</button>
                            </div>
                            <div class="row px-3 justify-content-center">
                                <a href="{{ route('/') }}" class="btn btn-sm" style="background: transparent; color: var(--primary-color); border: 1px solid var(--primary-color);"><i class="fa fa-home"></i> Kembali ke Beranda</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div  style="background-color: var(--primary-color);" class="bg text-white py-4">
                <div class="row px-3">
                    <small class="ml-4 ml-sm-5 mb-2">{!! $site_setting->footer_text ?? 'Copyright © 2022 &diamondsuit; All Right Reserved' !!}<br></small>
                </div>
            </div>
        </div>
    </div>

</body>


</html>
