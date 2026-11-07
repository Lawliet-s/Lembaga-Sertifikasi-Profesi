@extends('layout/client')
@section('judul')
    {{ $berita->title }}
@endsection

@section('berita')
    active
@endsection

@section('css')
<style>
    .article-container {
        max-width: 850px;
        margin: 0 auto;
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .article-featured-img {
        width: 100%;
        max-height: 480px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 25px;
    }
    .article-title {
        font-size: 32px;
        font-weight: 800;
        color: #1a1a1a;
        line-height: 1.3;
        margin-bottom: 15px;
    }
    .article-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eaeaea;
    }
    .article-meta .date {
        color: #dc3545;
        font-weight: 600;
    }
    .article-body {
        font-size: 17px;
        line-height: 1.8;
        color: #333;
    }
    .article-body img {
        max-width: 100% !important;
        height: auto !important;
        border-radius: 6px;
        margin: 20px 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .article-body p {
        margin-bottom: 20px;
    }
    .article-body h1, .article-body h2, .article-body h3, .article-body h4 {
        margin-top: 30px;
        margin-bottom: 15px;
        font-weight: 700;
        color: #222;
    }
    @media (max-width: 768px) {
        .article-container {
            padding: 20px;
        }
        .article-title {
            font-size: 24px;
        }
    }
</style>
@endsection

@section('isi')
    <div class="single-services py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="article-container">
                        @if($berita->image)
                            <img src="{{ asset($berita->image) }}" class="article-featured-img" alt="{{ $berita->title }}">
                        @endif
                        <h1 class="article-title">{{ $berita->title }}</h1>
                        <div class="article-meta">
                            <span><i class="far fa-calendar-alt mr-1"></i> <span class="date">{{ $berita->created_at->format('d M Y') }}</span></span>
                            <span>•</span>
                            <span>{!! $berita->status !!}</span>
                        </div>
                        <div class="article-body">
                            <p class="font-italic text-muted lead mb-4">{{ $berita->excerpt }}</p>
                            <hr class="mb-4">
                            {!! $berita->body !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
