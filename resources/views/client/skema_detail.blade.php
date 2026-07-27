@extends('layout.client')
@section('judul')
    {{ $skema->skema }} | {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('layanan')
    active
@endsection

@section('css')
    <style>
        .info-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .info-card .card-body {
            padding: 20px;
        }
        .info-card .icon-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: {{ $site_setting->primary_color ?? '#9b0000' }}1a;
            display: flex;
            align-items: center;
            justify-content: center;
            color: {{ $site_setting->primary_color ?? '#9b0000' }};
            font-size: 18px;
            flex-shrink: 0;
        }
        .info-card .info-label {
            font-size: 12px;
            color: #999;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-card .info-value {
            font-size: 15px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }
        .uk-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        .uk-heading {
            color: {{ $site_setting->primary_color ?? '#9b0000' }};
        }
    </style>
@endsection

@section('isi')
    <!-- Header -->
    <div style="background-image: url('{{ asset($site_setting->header_image ?? 'general/assets/images/head1.jpg') }}')" class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ $skema->skema }}</h1>
                    <span style="font-size:14px; opacity:1; font-weight: 500;">
                        <a href="{{ route('client_skema') }}" style="color:#fff; text-decoration:underline;">Skema Sertifikasi</a> / {{ $skema->skema }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten -->
    <div class="container mt-4 mb-5">
        <div class="row">
            <div class="col-lg-8 col-md-7">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="info-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-circle mr-3">
                                    <i class="fas fa-suitcase"></i>
                                </div>
                                <div>
                                    <div class="info-label">Nama Skema</div>
                                    <p class="info-value">{{ $skema->skema }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-circle mr-3">
                                    <i class="fas fa-code"></i>
                                </div>
                                <div>
                                    <div class="info-label">Kode Skema</div>
                                    <p class="info-value">{{ $skema->kode_skema }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-circle mr-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <div class="info-label">Penanggung Jawab</div>
                                    <p class="info-value">{{ $skema->asesor?->nama ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-circle mr-3">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <div class="info-label">Tempat Uji Kompetensi</div>
                                    <p class="info-value">{{ $skema->tuk?->tuk ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-circle mr-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <div class="info-label">Status Skema</div>
                                    <p class="info-value">{{ $skema->status_id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-circle mr-3">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div>
                                    <div class="info-label">Tanggal Dibuat</div>
                                    <p class="info-value">{{ $skema->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-5">
                <div class="info-card">
                    <div class="card-body">
                        <h5 style="font-weight:600; margin-bottom:15px;">
                            <i class="fas fa-tasks uk-heading"></i> Unit Kompetensi
                        </h5>
                        @if($skema->unikoms && $skema->unikoms->count() > 0)
                            <table class="table uk-table" style="margin-bottom:0;">
                                @foreach ($skema->unikoms as $item)
                                    <tr>
                                        <td style="width:30px; text-align:center;">{{ $loop->iteration }}</td>
                                        <td>{{ $item->unikom }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p class="text-muted" style="font-size:13px;">Belum ada unit kompetensi terdaftar.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
