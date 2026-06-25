<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login-Asesi | LSP</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/auth.css') }}">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/shotcut.jpg') }}" />
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/vendor.bundle.addons.js') }}"></script>
    <link rel="shortcut icon" href="{{ asset('general/assets/images/shortcut.jpg') }}" />
    <style>
        :root {
            --primary-color: {{ optional($site_setting)->primary_color ?? '#9b0000e2' }};
            --secondary-color: {{ optional($site_setting)->secondary_color ?? '#f84949e2' }};
        }
    </style>
</head>

<body>
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-6 px-0">
                    <div class="card1" style="background: url('{{ asset('assets/images/auth/login_asesi.png') }}') center center / cover no-repeat;"></div>
                </div>
                <div class="col-lg-6">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input type="hidden" name="role_login" value="asesi">
                        <div class="card2 card border-0 px-4 py-5">
                            <div class="row px-3 mt-4 mb-2 border-line">
                                <img src="{{ asset($site_setting->logo ?? 'assets/images/logo/lsp1.png') }}" class="logo2"><br><br>
                            </div>
                            <div class="row mb-4 px-3">
                                <h6 class="mb-0 mr-4 mt-2">{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</h6>
                            </div>
                            <div class="row px-3 mb-4 w3-panel w3-border-bottom justify-content-center">
                                <label class="text-center">Login Asesi</label>
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm">Email</h6>
                                </label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror form-control-lg border-left-0"
                                    id="email" name="email" value="{{ old('email') }}" required
                                    autocomplete="email" placeholder="">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm">Password</h6>
                                </label>
                                <input type="password" class="@error('password') is-invalid @enderror" name="password"
                                    form-control-lg border-left-0" required autocomplete="current-password"
                                    id="exampleInputPassword" placeholder="">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row px-3 mb-4">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" name="remember" id="remember" class="form-check-input"
                                        {{ old('remember') ? 'checked' : '' }}>
                                </div>
                                <label class="form-check-label  text-muted" for="remember">Ingatkan saya</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="ml-auto mb-0 text-sm">Lupa
                                        Password?</a>
                                @endif


                            </div>
                            @include('partials.honeypot')
                            <div class="row mb-3 px-3">
                                <button type="submit" class="btn text-center" style="background-color: var(--primary-color); color: #fff; border: none;">Login</button>
                            </div>
                            <div class="row mb-4 px-3">
                                <small class="font-weight-bold">Belum punya akun? <a href="{{ route('reg') }}"
                                        style="color: var(--primary-color);">Daftar disini</a></small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div style="background-color: var(--primary-color);" class="bg text-white py-4">
                <div class="row px-3">
                    <small class="ml-4 ml-sm-5 mb-2">{!! $site_setting->footer_text ?? 'Copyright © 2022 &diamondsuit; All Right Reserved' !!}<br></small>
                </div>
            </div>
        </div>
    </div>
</body>


</html>
