<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    {{-- Header --}}
                    <tr>
                        <td style="background-color: #9b0000e2; padding: 30px 40px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 600;">
                                {{ optional($site_setting ?? null)->title ?? config('app.name') }}
                            </h1>
                            <p style="color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 13px;">
                                Lembaga Sertifikasi Profesi
                            </p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 40px;">
                            {{-- Greeting --}}
                            @if (!empty($greeting))
                                <h2 style="color: #333; margin: 0 0 20px 0; font-size: 20px;">{{ $greeting }}</h2>
                            @else
                                <h2 style="color: #333; margin: 0 0 20px 0; font-size: 20px;">
                                    @if ($level === 'error') Ups!
                                    @else Halo!
                                    @endif
                                </h2>
                            @endif

                            {{-- Intro Lines --}}
                            @foreach ($introLines as $line)
                                <p style="color: #555; line-height: 1.7; margin: 0 0 16px 0; font-size: 15px;">{{ $line }}</p>
                            @endforeach

                            {{-- Action Button --}}
                            @isset($actionText)
                                <table width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
                                    <tr>
                                        <td align="center">
                                            <table cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td align="center" style="background-color: #9b0000e2; border-radius: 4px;">
                                                        <a href="{{ $actionUrl }}" target="_blank"
                                                           style="display: inline-block; padding: 14px 36px; color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; letter-spacing: 0.5px;">
                                                            {{ $actionText }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            @endisset

                            {{-- Outro Lines --}}
                            @foreach ($outroLines as $line)
                                <p style="color: #555; line-height: 1.7; margin: 0 0 16px 0; font-size: 15px;">{{ $line }}</p>
                            @endforeach

                            {{-- Divider --}}
                            <hr style="border: none; border-top: 1px solid #eee; margin: 24px 0;">

                            {{-- Salutation --}}
                            @if (!empty($salutation))
                                <p style="color: #555; margin: 0 0 4px 0; font-size: 15px;">{{ $salutation }}</p>
                            @else
                                <p style="color: #555; margin: 0 0 4px 0; font-size: 15px;">Hormat kami,</p>
                                <p style="color: #9b0000e2; margin: 0; font-size: 15px; font-weight: 600;">
                                    {{ optional($site_setting ?? null)->title ?? config('app.name') }}
                                </p>
                            @endif
                        </td>
                    </tr>

                    {{-- Subcopy --}}
                    @isset($actionText)
                    <tr>
                        <td style="padding: 0 40px 24px 40px;">
                            <p style="color: #999; font-size: 12px; line-height: 1.6; margin: 0;">
                                Jika Anda mengalami kesulitan mengklik tombol "{{ $actionText }}", 
                                salin dan tempel URL berikut di browser Anda:
                                <br>
                                <a href="{{ $actionUrl }}" style="color: #9b0000e2; word-break: break-all; font-size: 12px;">{{ $actionUrl }}</a>
                            </p>
                        </td>
                    </tr>
                    @endisset

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #9b0000e2; padding: 20px 40px; text-align: center;">
                            <p style="color: rgba(255,255,255,0.7); margin: 0; font-size: 12px;">
                                &copy; {{ date('Y') }} {{ optional($site_setting ?? null)->title ?? config('app.name') }}. Seluruh hak cipta dilindungi.
                            </p>
                            <p style="color: rgba(255,255,255,0.5); margin: 4px 0 0 0; font-size: 11px;">
                                Email ini dikirim secara otomatis, harap tidak membalas email ini.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
