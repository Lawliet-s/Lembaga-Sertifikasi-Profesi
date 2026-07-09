@extends('layout.client')
@section('judul')
    Prosedur Sertifikasi | LSP
@endsection

@section('layanan')
    active
@endsection

@section('isi')
    <div style="background-image: url('{{ asset($site_setting->header_image ?? 'general/assets/images/head1.jpg') }}')" class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-pencil-square"></i> Prosedur Sertifikasi</h1>
                    <span>{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</span>
                </div>
            </div>
        </div>
    </div>

    @forelse ($prosedur as $item)
        <div class="more-info about-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="more-info-content">
                            <div class="section-heading">
                                <h2>{{ $item->judul }}</h2>
                            </div>
                            <div class="col-md-12">
                                {!! $item->konten !!}
                            </div>
                            @if ($item->tautan)
                                <div class="col-md-12 mt-3">
                                    <a href="{{ $item->tautan }}" target="_blank" class="btn btn-primary">
                                        <i class="fas fa-external-link-alt"></i> Selengkapnya
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    @empty
        <div class="more-info about-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="more-info-content">
                            <div class="col-md-12 text-center py-5">
                                <h4 class="text-muted">Belum ada prosedur sertifikasi.</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforelse
    <br><br>
@endsection
