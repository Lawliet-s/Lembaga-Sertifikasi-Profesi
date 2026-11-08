@extends('layout.asesor')

@section('judul')
Dashboard | Asesor {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    <div class="page-header">
        <h4>
            <i class="fas fa-th-large"></i> Dashboard Asesor
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item">
                    <a href="{{ route('dashboard.asesor') }}">Asesor</a>
                </li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div><br>

    <div class="card card-statistics">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-users mr-2"></i>
                        Asesi Aktif
                    </p>
                    <h2 class="text text-center counter-value">{{ $totalAsesi }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-calendar-day mr-2"></i>
                        Jadwal Hari Ini
                    </p>
                    <h2 class="text text-center counter-value">{{ $jadwalHariIni }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-clock mr-2"></i>
                        Penilaian Belum Selesai
                    </p>
                    <h2 class="text text-center counter-value">{{ $penilaianBelumSelesai }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-certificate mr-2"></i>
                        Sertifikasi Direkomendasikan
                    </p>
                    <h2 class="text text-center counter-value">{{ $sertifikasiDirekomendasikan }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-building mr-2"></i>
                        TUK
                    </p>
                    <h2 class="text text-center counter-value">{{ $totalTuk }}</h2>
                </div>
            </div>
        </div>
    </div><br>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-list-alt mr-2"></i>Aktivitas Terbaru</h6>
                    <small class="text-white">5 data terakhir</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Asesi</th>
                                    <th>Skema</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($aktivitas as $item)
                                    <tr>
                                        <td>
                                            <small>{{ optional($item->created_at)->format('d/m/Y H:i') ??
                                                optional($item->date)->format('d/m/Y') ?? '-' }}</small>
                                        </td>
                                        <td>{{ $item->user_name ?? '-' }}</td>
                                        <td>{{ $item->skema_name ?? '-' }}</td>
                                        <td>
                                            @php
                                                $status = strip_tags($item->status ?? 'Belum diproses');
                                            @endphp
                                            @if (str_contains($status, 'Kompeten') || str_contains($status, 'Sertifikasi Selesai'))
                                                <span class="badge badge-success"><i class="fas fa-check"></i> Kompeten</span>
                                            @elseif (str_contains($status, 'Belum Kompeten'))
                                                <span class="badge badge-danger"><i class="fas fa-times"></i> Belum Kompeten</span>
                                            @else
                                                <span class="badge badge-warning">{{ $status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('asesor.penilaian.show', $item->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada aktivitas peserta asesmen.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    <div class="page-header">
        <h4>
            <i class="fas fa-th-large"></i> Dashboard Asesor
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item">
                    <a href="{{ route('dashboard.asesor') }}">Asesor</a>
                </li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div><br>

    <div class="card card-statistics">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-users mr-2"></i>
                        Asesi Aktif
                    </p>
                    <h2 class="text text-center counter-value">{{ $totalAsesi }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-calendar-day mr-2"></i>
                        Jadwal Hari Ini
                    </p>
                    <h2 class="text text-center counter-value">{{ $jadwalHariIni }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-clock mr-2"></i>
                        Penilaian Belum Selesai
                    </p>
                    <h2 class="text text-center counter-value">{{ $penilaianBelumSelesai }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-certificate mr-2"></i>
                        Sertifikasi Direkomendasikan
                    </p>
                    <h2 class="text text-center counter-value">{{ $sertifikasiDirekomendasikan }}</h2>
                </div>
                <div class="statistics-item">
                    <p>
                        <i class="icon-sm fas fa-building mr-2"></i>
                        TUK
                    </p>
                    <h2 class="text text-center counter-value">{{ $totalTuk }}</h2>
                </div>
            </div>
        </div>
    </div><br>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-list-alt mr-2"></i>Aktivitas Terbaru</h6>
                    <small class="text-white">5 data terakhir</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Asesi</th>
                                    <th>Skema</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($aktivitas as $item)
                                    <tr>
                                        <td>
                                            <small>{{ optional($item->created_at)->format('d/m/Y H:i') ??
                                                optional($item->date)->format('d/m/Y') ?? '-' }}</small>
                                        </td>
                                        <td>{{ $item->user_name ?? '-' }}</td>
                                        <td>{{ $item->skema_name ?? '-' }}</td>
                                        <td>
                                            @php
                                                $status = strip_tags($item->status ?? 'Belum diproses');
                                            @endphp
                                            @if (str_contains($status, 'Kompeten') || str_contains($status, 'Sertifikasi Selesai'))
                                                <span class="badge badge-success">{{ $status }}</span>
                                            @elseif (str_contains($status, 'Ditolak') || str_contains($status, 'Belum Kompeten') || str_contains($status, 'Mengulang'))
                                                <span class="badge badge-danger">{{ $status }}</span>
                                            @elseif (str_contains($status, 'Validasi'))
                                                <span class="badge badge-info">{{ $status }}</span>
                                            @elseif (str_contains($status, 'Observasi') || $item->koreksi)
                                                <span class="badge badge-warning">Observasi</span>
                                            @elseif (str_contains($status, 'Perbaikan'))
                                                <span class="badge badge-warning">{{ $status }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('asesor.penilaian.show', $item->id) }}"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada aktivitas</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
