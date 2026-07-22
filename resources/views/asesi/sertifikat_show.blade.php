<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sertifikat Kompetensi - {{ $site_setting->title ?? 'LSP' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/font-awesome/css/all.min.css') }}">
    <link rel="shortcut icon" href="{{ asset(optional($site_setting)->favicon ?? 'favicon.ico') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Lato', 'Segoe UI', sans-serif;
            background: #e8e0d0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 30px;
        }
        .certificate {
            background: #fffdf7;
            width: 210mm;
            max-width: 820px;
            min-height: 297mm;
            padding: 45px 50px;
            border: 6px solid #b89a3e;
            position: relative;
            box-shadow: 0 8px 40px rgba(0,0,0,0.12);
            display: flex;
            flex-direction: column;
        }
        .certificate::before {
            content: '';
            position: absolute;
            top: 12px; left: 12px; right: 12px; bottom: 12px;
            border: 1px solid #d4bc6a;
            pointer-events: none;
        }
        .certificate::after {
            content: '';
            position: absolute;
            top: 18px; left: 18px; right: 18px; bottom: 18px;
            border: 1px solid #d4bc6a;
            pointer-events: none;
        }
        .corner {
            position: absolute;
            width: 40px; height: 40px;
            border-color: #b89a3e;
            border-style: solid;
        }
        .corner-tl { top: 8px; left: 8px; border-width: 3px 0 0 3px; }
        .corner-tr { top: 8px; right: 8px; border-width: 3px 3px 0 0; }
        .corner-bl { bottom: 8px; left: 8px; border-width: 0 0 3px 3px; }
        .corner-br { bottom: 8px; right: 8px; border-width: 0 3px 3px 0; }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h1 {
            font-family: 'Cinzel', serif;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: #7a6430;
            margin-bottom: 2px;
        }
        .header p {
            font-family: 'Lato', sans-serif;
            font-size: 12px;
            color: #999;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin: 0;
        }
        .divider {
            width: 50%;
            margin: 0 auto 20px;
            border: none;
            border-top: 2px solid #d4bc6a;
        }
        .logo-wrap {
            text-align: center;
            margin-bottom: 15px;
        }
        .logo-wrap img {
            max-height: 70px;
        }
        .body {
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 25px;
        }
        .body .prelude {
            font-family: 'Lato', sans-serif;
            font-size: 15px;
            color: #666;
            margin-bottom: 5px;
        }
        .body .name {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 8px 0;
            letter-spacing: 1px;
        }
        .body .competent {
            font-size: 15px;
            color: #555;
            margin: 5px 0;
        }
        .body .competent strong {
            color: #7a6430;
            font-weight: 700;
        }
        .body .skema-label {
            font-size: 14px;
            color: #666;
            margin-top: 12px;
        }
        .body .skema {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 600;
            color: #7a6430;
            margin: 5px 0 15px;
        }
        .body .meta {
            font-family: 'Lato', sans-serif;
            font-size: 13px;
            color: #888;
        }
        .footer {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 15px;
        }
        .footer .signature {
            text-align: center;
        }
        .footer .signature .stamp-img {
            max-height: 80px;
            margin-bottom: 5px;
        }
        .footer .signature .line {
            width: 170px;
            border-top: 2px solid #333;
            margin: 35px auto 3px;
        }
        .footer .signature .jabatan {
            font-size: 12px;
            color: #888;
            letter-spacing: 1px;
        }
        .cert-id {
            text-align: center;
            font-size: 10px;
            color: #bbb;
            margin-top: 12px;
            letter-spacing: 2px;
        }
        @media print {
            @page { size: A4; margin: 0; }
            body { background: #fff; padding: 0; }
            .certificate { box-shadow: none; width: 210mm; min-height: 297mm; padding: 45px 50px; }
        }
        @media screen and (max-width: 800px) {
            .certificate { width: 100%; min-height: auto; padding: 25px 20px; }
            .body .name { font-size: 24px; }
            .body .skema { font-size: 18px; }
            .header h1 { font-size: 22px; }
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="corner corner-tl"></div>
        <div class="corner corner-tr"></div>
        <div class="corner corner-bl"></div>
        <div class="corner corner-br"></div>

        <div class="header">
            <h1>Sertifikat Kompetensi</h1>
            <p>{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</p>
        </div>

        <hr class="divider">

        <div class="logo-wrap">
            @forelse ($logos as $logo)
                <img src="{{ asset($logo) }}" alt="Logo">
            @empty
                <img src="{{ asset('assets/images/logo/lsp1.png') }}" alt="Logo">
            @endforelse
        </div>

        <div class="body">
            <p class="prelude">Dengan ini menyatakan bahwa:</p>
            <div class="name">{{ $validasi->user_name }}</div>
            <p class="competent">Telah dinyatakan <strong>Kompeten</strong></p>
            <p class="skema-label">Pada Skema:</p>
            <div class="skema">{{ $validasi->skema_name }}</div>
            <p class="meta">
                Kode Skema: <strong>{{ $validasi->kode_skema }}</strong> &nbsp;|&nbsp;
                Kode Registrasi: <strong>#{{ sprintf('%04d', $validasi->id) }}</strong>
            </p>
        </div>

        <div class="footer">
            <div class="signature">
                @php
                    $site_setting = \App\Models\SiteSetting::first(); // Ensure site_setting is loaded
                    $lspSignature = $site_setting; // Now signature fields are on site_setting
                    $stampPath = public_path('assets/images/logo/stempel.png');
                @endphp
                
                @if ($lspSignature)
                    @if ($lspSignature->foto_signature)
                        <img src="{{ asset($lspSignature->foto_signature) }}" alt="Signature" style="max-height: 80px; margin-bottom: 10px;">
                    @elseif ($lspSignature->ttd_digital)
                        <img src="{{ $lspSignature->ttd_digital }}" alt="Tanda Tangan" style="max-height: 80px; margin-bottom: 10px;">
                    @endif
                    <div class="line"></div>
                    <p style="margin: 5px 0; font-weight: bold;">{{ $lspSignature->kepala_lsp_name }}</p>
                    <div class="jabatan">Kepala {{ $site_setting->title ?? 'LSP' }}</div>
                @else
                    @if (file_exists($stampPath))
                        <img src="{{ asset('assets/images/logo/stempel.png') }}" alt="Stempel" class="stamp-img">
                    @endif
                    <div class="line"></div>
                    <div class="jabatan">Ketua {{ $site_setting->title ?? 'LSP' }}</div>
                @endif
            </div>
        </div>

        <div class="cert-id">
            Nomor Sertifikat: <strong>{{ $validasi->nomor_sertifikat ?? '-' }}</strong><br>
            Diterbitkan secara elektronik
        </div>
    </div>

    <script>
        if (window.location.search.includes('print=1')) {
            window.onload = function() { window.print(); };
        }
    </script>
</body>
</html>