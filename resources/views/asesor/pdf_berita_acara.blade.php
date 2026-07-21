<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Berita Acara Asesmen</title>
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
        .signature { margin-top: 40px; }
        .signature table td { border: none; text-align: center; width: 50%; }
        .footer { text-align: center; font-size: 10px; color: #666; margin-top: 30px; border-top: 1px solid #ccc; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>BERITA ACARA ASESMEN</h2>
        <p>{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</p>
        <p>Nomor: BA/{{ $register->id }}/{{ date('Y') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Data Asesi</div>
        <table class="info-table">
            <tr><td>Nama Asesi</td><td>: {{ $register->user_name ?? '-' }}</td></tr>
            <tr><td>Skema Sertifikasi</td><td>: {{ $register->skema_name ?? '-' }}</td></tr>
            <tr><td>Tanggal Asesmen</td><td>: {{ $register->date ? optional($register->date)->format('d F Y') : '-' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Hasil Penilaian</div>
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
                    <td>{{ ucfirst($p->nilai ?? '-') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center">Tidak ada data penilaian</td></tr>
                @endforelse
            </tbody>
        </table>
        <p><strong>Total Kompeten:</strong> {{ $totalKompeten }} dari {{ $totalKompeten + $totalBelum }}</p>
    </div>

    <div class="section">
        <div class="section-title">Keputusan Asesor</div>
        <p><strong>Rekomendasi:</strong> {{ $rekomendasiData['keputusan'] ?? '-' }}</p>
        <p><strong>Catatan:</strong> {{ $rekomendasiData['catatan'] ?? '-' }}</p>
    </div>

    <div class="signature">
        <table>
            <tr>
                <td>
                    <p>{{ $site_setting->address ?? 'Lokasi' }}, {{ date('d F Y') }}</p>
                    <br><br>
                    <p><u>{{ Auth::user()->name ?? 'Asesor' }}</u></p>
                    <p>Asesor</p>
                </td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat secara elektronik dan sah tanpa tanda tangan basah.</p>
        <p>&copy; {{ date('Y') }} {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</p>
    </div>
</body>
</html>
