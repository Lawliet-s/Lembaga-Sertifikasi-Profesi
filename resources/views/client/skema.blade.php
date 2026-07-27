@extends('layout.client')
@section('judul')
    Daftar Skema Sertifikasi | {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('layanan')
    active
@endsection

@section('css')
    <style>
        .skema-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            background: #fff;
        }
        .skema-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .skema-card-img {
            height: 180px;
            object-fit: cover;
            width: 100%;
        }
        .skema-card-placeholder {
            height: 180px;
            background: linear-gradient(135deg, #9b0000, #550000);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .skema-card-body {
            padding: 20px;
        }
        .skema-card-body h5 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        .skema-card-body .badge-kode {
            display: inline-block;
            font-size: 11px;
            background: #f0f0f0;
            color: #666;
            padding: 3px 10px;
            border-radius: 20px;
            margin-bottom: 10px;
        }
        .skema-card-body p {
            font-size: 13px;
            color: #888;
            margin-bottom: 15px;
        }
        .skema-card-body .btn-detail {
            display: inline-block;
            padding: 8px 20px;
            background: var(--primary-color, #9b0000);
            color: #fff;
            border-radius: 20px;
            text-decoration: none;
            font-size: 13px;
            transition: background 0.3s;
        }
        .skema-card-body .btn-detail:hover {
            background: #7a0000;
            color: #fff;
        }
        .search-box {
            max-width: 400px;
            margin: 0 auto 30px;
        }
    </style>
@endsection

@section('isi')
    <!-- Header -->
    <div style="background-image: url('{{ asset($site_setting->header_image ?? 'general/assets/images/head1.jpg') }}')" class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Daftar Skema Sertifikasi</h1>
                    <span>{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</span>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    <!-- Konten -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 text-center mb-4">
                <div class="search-box">
                    <input type="text" id="searchSkema" class="form-control" placeholder="Cari skema sertifikasi..." style="border-radius:20px; padding:10px 20px; border:1px solid #ddd;">
                </div>
            </div>
        </div>

        <div class="row" id="skemaList">
            @forelse ($skema as $item)
                <div class="col-lg-4 col-md-6 mb-4 skema-item">
                    <a href="{{ route('skema_detail', Crypt::encryptString($item->id)) }}" style="text-decoration:none; color:inherit;">
                        <div class="skema-card">
                            @if($item->image)
                                <img src="{{ asset($item->image) }}" alt="{{ $item->skema }}" class="skema-card-img">
                            @elseif($item->jurusan && $item->jurusan->image)
                                <img src="{{ asset($item->jurusan->image) }}" alt="{{ $item->skema }}" class="skema-card-img">
                            @else
                                <div class="skema-card-placeholder">
                                    <i class="fas fa-certificate" style="font-size:60px; color:rgba(255,255,255,0.3);"></i>
                                </div>
                            @endif
                            <div class="skema-card-body">
                                <span class="badge-kode">{{ $item->kode_skema }}</span>
                                <h5>{{ $item->skema }}</h5>
                                <p>Jurusan: {{ $item->jurusan?->jurusan ?? '-' }}</p>
                                <span class="btn-detail"><i class="fa fa-search"></i> Lihat Detail</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-md-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Belum ada skema sertifikasi yang tersedia.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <br><br>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#searchSkema').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#skemaList .skema-item').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
@endsection
