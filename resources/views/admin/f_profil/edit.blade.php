@extends('layout/admin')

@section('judul')
    Edit Profil {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
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
    {{-- <---------------------- PAGE HEADER ----------------------> --}}
    <div class="page-header">
        <h3>
            <i class="fas fa-cogs"></i> Edit Profil 
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom  bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                <li style="color: var(--secondary-color)" class="breadcrumb-item">
                    <a href="{{ route('f_profil.index') }}">LSP </a>
                </li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Edit Profil </li>
            </ol>
        </nav>
    </div><br>


    {{-- <---------------------- EDIT PROFIL ----------------------> --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('f_profil.update', $profil->id) }}" method="POST"
                class="forms-sample">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Isi Tentang</label>
                    <textarea class="summernote" name="profil">{{ $profil->profil }}</textarea>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Visi</label>
                    <textarea class="summernote" name="visi">{{ $profil->visi }}</textarea>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Misi</label>
                    <textarea class="summernote" name="misi">{{ $profil->misi }}</textarea>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Motto</label>
                    <textarea class="summernote" name="motto">{{ $profil->motto }}</textarea>
                </div>
                <button type="submit" class="btn btn-rounded btn-info btn-icon-text">
                    <i class="far fa-check-square btn-icon-prepend"></i>
                    Update
                </button>
                <a href="{{ route('f_profil.edit', $profil->id) }}"><button type="button"
                        class="btn btn-danger btn-rounded btn-icon-text">
                        <i class="fa fa-times btn-icon-prepend"></i>
                        Batal
                    </button></a>
            </form>
        </div>
    </div>
@endsection
