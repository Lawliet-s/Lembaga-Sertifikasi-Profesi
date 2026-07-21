@extends('layout.admin')

@section('judul')
    Tambah Prosedur Sertifikasi | Admin LSP
@endsection

@section('sidebar')
    sidebar-icon-only
@endsection

@section('isi')
    @include('layout/verifikasi')
    <style>
        .note-toolbar {
            overflow-x: auto;
            flex-wrap: nowrap !important;
        }
        .note-toolbar-wrapper {
            overflow-x: auto;
        }
        .note-editor {
            max-width: 100%;
        }
        .card-body {
            overflow-x: hidden;
        }
        @media (max-width: 768px) {
            .note-editor .note-toolbar .note-btn-group {
                flex-wrap: nowrap;
            }
        }
    </style>
    <div class="page-header">
        <h3>
            <i class="fas fa-plus-circle"></i> Tambah Prosedur Sertifikasi
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('tutorial.index') }}">Prosedur Sertifikasi</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div><br>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tutorial.store') }}" method="POST">
                @csrf
                @include('partials.honeypot')
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Judul Prosedur</label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Masukkan judul prosedur" required>
                    @error('judul')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Konten</label>
                    <textarea name="konten" class="summernote @error('konten') is-invalid @enderror">{{ old('konten') }}</textarea>
                    @error('konten')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Tautan (Opsional)</label>
                    <input type="url" name="tautan" class="form-control @error('tautan') is-invalid @enderror" value="{{ old('tautan') }}" placeholder="https://example.com">
                    @error('tautan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Urutan</label>
                    <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan') }}" placeholder="Urutan tampilan (1, 2, 3, ...)">
                    @error('urutan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-rounded btn-info btn-icon-text">
                    <i class="fas fa-save btn-icon-prepend"></i> Simpan
                </button>
                <a href="{{ route('tutorial.index') }}" class="btn btn-rounded btn-secondary btn-icon-text">
                    <i class="fas fa-times btn-icon-prepend"></i> Batal
                </a>
            </form>
        </div>
    </div>
@endsection
