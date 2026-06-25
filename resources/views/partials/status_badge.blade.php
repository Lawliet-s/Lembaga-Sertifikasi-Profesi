@php
    $statusClass = match(true) {
        str_contains($status ?? '', 'Kompeten') || $status === 'kompeten' => 'badge-success',
        str_contains($status ?? '', 'Tidak Kompeten') || $status === 'tidak_kompeten' => 'badge-danger',
        str_contains($status ?? '', 'Menunggu Validasi') => 'badge-warning',
        str_contains($status ?? '', 'Pendaftaran Divalidasi') => 'badge-info',
        str_contains($status ?? '', 'Sertifikasi Selesai') => 'badge-success',
        str_contains($status ?? '', 'Pendaftaran Ditolak') => 'badge-danger',
        str_contains($status ?? '', 'Lengkapi Data Anda') => 'badge-warning',
        str_contains($status ?? '', 'Diblokir') => 'badge-dark',
        str_contains($status ?? '', 'Belum Dikoreksi') => 'badge-warning',
        default => 'badge-secondary'
    };
    
    $cleanStatus = strip_tags($status ?? '');
@endphp
<span class="badge badge-pill {{ $statusClass }}">{{ $cleanStatus }}</span>
