<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Asesmen</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; font-size: 18px; }
        .header p { margin: 2px 0; font-size: 12px; }
        .section { margin-bottom: 15px; }
        .section-title { font-weight: bold; font-size: 14px; margin-bottom: 8px; border-bottom: 1px solid #999; padding-bottom: 3px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table, th, td { border: 1px solid #333; }
        th, td { padding: 6px 8px; text-align: left; font-size: 11px; }
        th { background-color: #f0f0f0; }
        .info-table td:first-child { width: 35%; font-weight: bold; }
        .badge-kompeten { color: #155724; background-color: #d4edda; padding: 2px 8px; border-radius: 3px; font-size: 11px; }
        .badge-belum { color: #721c24; background-color: #f8d7da; padding: 2px 8px; border-radius: 3px; font-size: 11px; }
        .summary { margin: 15px 0; padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 4px; }
        .summary h4 { margin: 0 0 8px 0; }
        .footer { text-align: center; font-size: 10px; color: #666; margin-top: 30px; border-top: 1px solid #ccc; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>HASIL ASESMEN</h2>
        <p>{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</p>
    </div>

    <div class="section">
        <div class="section-title">Data Asesi</div>
        <table class="info-table">
            <tr><td>Nama Asesi</td><td>: {{ $register->user_name ?? '-' }}</td></tr>
            <tr><td>Skema Sertifikasi</td><td>: {{ $register->skema_name ?? '-' }}</td></tr>
            <tr><td>Tanggal Asesmen</td><td>: {{ $register->date ? optional($register->date)->format('d F Y') : '-' }}</td></tr>
            @if ($register->tuk)
            <tr><td>TUK</td><td>: {{ $register->tuk?->tuk ?? $register->tuk?->alamat ?? '-' }}</td></tr>
            @endif
        </table>
    </div>

    <div class="section">
        <div class="section-title">Hasil Penilaian per Unit Kompetensi</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Unit Kompetensi</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penilaians as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ optional($p->unikom)->unikom ?? optional($p->unikom)->kode_unikom ?? '-' }}</td>
                    <td>
                        @if ($p->nilai === 'kompeten')
                            <span class="badge-kompeten">Kompeten</span>
                        @else
                            <span class="badge-belum">Belum Kompeten</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center">Tidak ada data penilaian</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="summary">
        <h4>Ringkasan</h4>
        <table style="border: none; width: auto;">
            <tr style="border: none;">
                <td style="border: none;"><strong>Total Unit Kompeten:</strong></td>
                <td style="border: none;">{{ $totalKompeten }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Total Unit Belum Kompeten:</strong></td>
                <td style="border: none;">{{ $totalBelum }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Keputusan:</strong></td>
                <td style="border: none;">{{ $rekomendasiData['keputusan'] ?? '-' }}</td>
            </tr>
        </table>
    </div>

    @if ($rekomendasiData['catatan'] ?? null)
    <div class="section">
        <div class="section-title">Catatan Asesor</div>
        <p>{{ $rekomendasiData['catatan'] }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Dokumen ini sah dan diproses secara elektronik.</p>
        <p>&copy; {{ date('Y') }} {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</p>
    </div>
</body>
</html>
