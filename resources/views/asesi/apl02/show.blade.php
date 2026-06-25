@extends('layout.asesi')

@section('sidebar')
    sidebar-mini
@endsection

@section('judul')
    FR.APL.02 - Detail - {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('isi')
<style>
    .apl02-table {
        border-collapse: collapse;
        width: 100%;
    }
    .apl02-table td, .apl02-table th {
        border: 1px solid #000;
        padding: 6px 10px;
        vertical-align: top;
    }
    .apl02-table .label-cell {
        font-weight: 600;
        width: 200px;
    }
    @media print {
        .no-print, .page-header, .card-header, .btn { display: none !important; }
        .print-area { box-shadow: none !important; border: none !important; }
        body { background: #fff !important; }
    }
</style>

<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center no-print">
        <h4><i class="fas fa-clipboard-check"></i> FR.APL.02 — Detail Asesmen Mandiri</h4>
        <div>
            <a href="{{ route('apl02.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn" style="background-color: var(--primary-color); color: #fff;">
                <i class="fas fa-print"></i> Cetak
            </button>
        </div>
    </div>

    <div class="card shadow-sm rounded mb-4 print-area">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h4 class="fw-bold">FR.APL.02</h4>
                <h5>ASESMEN MANDIRI</h5>
                <p class="small text-muted">{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</p>
            </div>

            <table class="apl02-table mb-4">
                <tr>
                    <td class="label-cell">Skema</td>
                    <td><strong>{{ $registration->skema_name }}</strong></td>
                </tr>
                <tr>
                    <td class="label-cell">Nama Asesi</td>
                    <td>{{ $registration->user_name }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Tanggal Pengisian</td>
                    <td>{{ now()->format('d M Y') }}</td>
                </tr>
            </table>

            @forelse ($xnxxes as $unitName => $items)
                <h6 class="fw-bold mb-3" style="color: var(--primary-color);">
                    <i class="fas fa-book"></i> {{ $items->first()->unikom_kode }} — {{ $unitName }}
                </h6>
                <table class="apl02-table mb-4">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">No</th>
                            <th style="width: 250px;">Elemen</th>
                            <th>Kriteria Unjuk Kerja</th>
                            <th style="width: 140px; text-align: center;">Status</th>
                            <th style="width: 160px; text-align: center;">Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                <td>{{ $item->asesmen_name }}</td>
                                <td><small>{{ $item->kriteria }}</small></td>
                                <td style="text-align: center;">@include('partials.status_badge', ['status' => $item->status])</td>
                                <td style="text-align: center;">
                                    @if ($item->image)
                                        <a href="{{ asset($item->image) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Lihat Bukti">
                                            <i class="fas fa-file"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @empty
                <div class="text-center py-4 text-muted">
                    <p>Belum ada data asesmen mandiri.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
