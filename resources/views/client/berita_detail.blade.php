@extends('layout/client')
@section('judul')
    {{ $berita->title }}
@endsection

@section('berita')
    active
@endsection

@section('css')
<style>
    .main-article {
        max-width: 800px;
        margin: 0 auto;
        float: none;
    }
    .main-article img {
        width: 100%;
        max-height: 450px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 25px;
    }
    .main-article h4 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .main-article .date {
        font-size: 14px;
        color: #dc3545;
        margin-bottom: 20px;
    }
    .main-article p {
        font-size: 16px;
        line-height: 1.8;
        color: #444;
    }
</style>
@endsection

@section('isi')
    <div class="single-services py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 main-article">
                    <img src="{{ asset($berita->image) }}" alt="{{ $berita->title }}">
                    <h4>{{ $berita->title }}</h4>
                    <div class="date">{{ $berita->created_at->format('d/M/Y') }}</div>
                    <p>{!! $berita->body !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
