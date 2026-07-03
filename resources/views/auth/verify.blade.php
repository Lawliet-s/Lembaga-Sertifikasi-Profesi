<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Verifikasi Email | {{ optional($site_setting)->title ?? 'LSP' }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/auth.css') }}">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/shotcut.jpg') }}" />
    <style>
        :root {
            --primary-color: {{ optional($site_setting)->primary_color ?? '#9b0000e2' }};
            --secondary-color: {{ optional($site_setting)->secondary_color ?? '#f84949e2' }};
        }
        .card2 {
            margin: 0px 40px;
        }
        .btn-primary-custom {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 2px;
            cursor: pointer;
        }
        .btn-primary-custom:hover {
            opacity: 0.9;
            color: #fff;
        }
        .alert-success-custom {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 16px;
        }
        .verify-icon {
            font-size: 48px;
            color: var(--primary-color);
            margin-bottom: 16px;
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
                    <div class="card2 card border-0 px-4 py-5">
                        <div class="row px-3 mt-4 mb-2 border-line">
                            <div style="display: flex; justify-content: center; gap: 15px;">
                                @forelse ($logos as $logo)
                                    <img src="{{ asset($logo) }}" class="logo2" style="max-height: 60px; width: auto;">
                                @empty
                                    <img src="{{ asset('assets/images/logo/lsp1.png') }}" class="logo2" style="width: auto;">
                                @endforelse
                            </div>
                            <br><br>
                        </div>
                        <div class="row mb-4 px-3">
                            <h6 class="mb-0 mr-4 mt-2">{{ optional($site_setting)->title ?? 'Lembaga Sertifikasi Profesi' }}</h6>
                        </div>

                        <div class="text-center mb-4">
                            <i class="fa fa-envelope verify-icon"></i>
                            <h5 class="font-weight-bold">Verifikasi Email</h5>
                        </div>

                        @if (session('resent'))
                            <div class="alert alert-success text-center" role="alert">
                                <i class="fa fa-check-circle"></i>
                                Tautan verifikasi baru telah dikirim ke email Anda.
                            </div>
                        @endif

                        <div class="text-muted text-center mb-4" style="line-height: 1.8;">
                            Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi.
                        </div>

                        <div class="text-muted text-center mb-4">
                            Jika Anda tidak menerima email,
                        </div>

                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <div class="row px-3">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fa fa-paper-plane"></i> Kirim Ulang Tautan Verifikasi
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fa fa-info-circle"></i>
                                Pastikan email yang Anda daftarkan benar dan dapat diakses.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div style="background-color: var(--primary-color);" class="bg text-white py-4">
                <div class="row px-3">
                    <small class="ml-4 ml-sm-5 mb-2">{!! optional($site_setting)->footer_text ?? 'Copyright &diamondsuit; All Right Reserved' !!}<br></small>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
