@extends('layout/admin')

@section('judul')
    {{ $berita->title }} | Admin LSP
@endsection

@section('sidebar')
    sidebar-icon-only
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h3 class="page-title">
            <i class="fas fa-bullhorn mr-2"></i> Detail & Edit Berita
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ (Auth::user() && Auth::user()->hasRole('asesor')) ? route('dashboard.asesor') : route('admin') }}">Dashboard</a></li>
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">{{ Str::limit($berita->title, 30) }}</li>
            </ol>
        </nav>
    </div>

    <!-- FORM EDIT BERITA (ATAS) -->
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4"><i class="fas fa-edit mr-2"></i> Ubah Berita</h4>
                    <form action="{{ route('berita.update', $berita->id) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('put')
                        
                        <div class="form-group">
                            <label class="font-weight-bold">Gambar Utama Berita</label>
                            @if($berita->image)
                                <div class="mb-2">
                                    <img src="{{ asset($berita->image) }}" class="img-thumbnail rounded" style="max-height: 150px; object-fit: cover;" alt="Current Image">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control-file" accept=".jpg,.jpeg,.png">
                            <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Status Berita</label>
                            <select class="form-control" name="status">
                                <option value="{{ $berita->status }}" selected>{{ strip_tags($berita->status) }}</option>
                                <option value='<label class="badge badge-info">Posting</label>'>Posting</option>
                                <option value='<label class="badge badge-danger">Tidak di Posting</label>'>Tidak Di Posting</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Judul Berita</label>
                            <input type="text" class="form-control" placeholder="Judul berita" name="title" maxlength="75" value="{{ $berita->title }}" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Excerpt (Ringkasan Singkat)</label>
                            <input type="text" class="form-control" maxlength="100" placeholder="Ringkasan singkat berita" name="excerpt" value="{{ $berita->excerpt }}" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Isi Konten Berita</label>
                            <textarea class="summernote" name="body" required>{{ $berita->body }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-rounded btn-info btn-block py-2 font-weight-bold shadow-sm">
                            <i class="fas fa-save mr-1"></i> Perbarui Berita
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- PREVIEW BERITA (BAWAH) -->
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4"><i class="fas fa-eye mr-2"></i> Preview Tampilan</h4>
                    @if($berita->image)
                        <div class="text-center mb-4 bg-light p-3 rounded">
                            <img class="img-fluid rounded shadow-sm" src="{{ asset($berita->image) }}" alt="Preview Image" style="max-height: 400px; object-fit: cover; width: 100%;">
                        </div>
                    @endif
                    <div class="p-4 border rounded bg-white">
                        <div class="mb-3">{!! $berita->status !!}</div>
                        <h2 class="font-weight-bold text-dark mb-3">{{ $berita->title }}</h2>
                        <p class="text-muted font-italic lead mb-4">{{ $berita->excerpt }}</p>
                        <hr>
                        <div class="news-content mt-4" style="overflow-x: auto;">
                            {!! $berita->body !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
