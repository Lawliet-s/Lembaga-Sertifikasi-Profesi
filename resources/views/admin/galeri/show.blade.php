@extends('layout.admin')

@section('judul')
    {{ $galeri->galeri }} | Admin LSP
@endsection

@section('sidebar')
    sidebar-icon-only
@endsection

@section('isi')
    @include('layout/verifikasi')
    <!-- /////////////////////////////////// -->
    {{-- BREADCRUMB --}}
    <!-- /////////////////////////////////// -->
    <div class="page-header">
        <h4>
            <i class="fas fa-eye"></i> Foto
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom  bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ (Auth::user() && Auth::user()->hasRole('asesor')) ? route('dashboard.asesor') : route('admin') }}">Dashboard</a></li>
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Album Foto</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page"> Foto </li>
            </ol>
        </nav>
    </div>
    <!-- /////////////////////////////////// -->
    <!-- UPLOAD DATA -->
    <!-- /////////////////////////////////// -->
    <div class="row">
        <div hidden class="card">
            <div class="card-header">
                <h4>Multiple Upload</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('foto.store') }}" method="POST" enctype="multipart/form-data"
                    class="dropzone" id="mydropzone">
                    @csrf
                    <div class="fallback">
                        <input type="hidden" name="group_galeri_id" value="dfsdf">
                        <input type="file" name="image[]" multiple="true">
                    </div> <button type="submit" class="btn btn-block btn-su"></button>
                </form>
            </div>
        </div>
        <!-- /////////////////////////////////// -->
        {{-- TAMBAH FOTO --}}
        <!-- /////////////////////////////////// -->
        <div class="col-md-6">
            <div class="mt-4">
                <div class="accordion accordion-solid-header" id="accordion-4" role="tablist">
                    <div class="card">
                        <div style="background-color: #563fbb" class="card-header text-white" role="tab" id="heading-10">
                            <h6 class="mb-0">
                                <a data-toggle="    " href="#collapse-10" aria-expanded="true"
                                    aria-controls="collapse-10" class=" ">
                                    Tambah Foto Baru ke Album {{ $galeri->galeri }}
                                </a>
                            </h6>
                        </div>
                        <div id="collapse-10" class="   " role="tabpanel" aria-labelledby="heading-10"
                            data-parent="#accordion-4" style="">
                            <div class="card-body">
                                <form action="{{ route('foto.store') }}" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        @csrf
                                        <div class="form-group">
                                            <input type="hidden" name="group_galeri_id" value="{{ $galeri->id }}">
                                            <label class="text-dark font-weight-bold">Pilih Foto (Bisa Multiple)</label><br>
                                            <input type="file" name="image[]" id="gallery-file-input" class="form-control-file" multiple required accept=".jpg,.jpeg,.png">
                                            <span class="text-dark d-inline-block mt-1" id="gallery-file-chosen">No file chosen</span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-rounded btn-success py-2 font-weight-bold"><i
                                        class="fas fa-upload"> </i> Simpan Gambar</button>
                                </form>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        const galleryInput = document.getElementById('gallery-file-input');
                                        const galleryLabel = document.getElementById('gallery-file-chosen');
                                        if (galleryInput) {
                                            galleryInput.addEventListener('change', function(e) {
                                                let count = e.target.files.length;
                                                if (count > 1) {
                                                    galleryLabel.textContent = count + " files chosen";
                                                } else if (count === 1) {
                                                    galleryLabel.textContent = e.target.files[0].name;
                                                } else {
                                                    galleryLabel.textContent = "No file chosen";
                                                }
                                            });
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /////////////////////////////////// -->
        {{-- EDIT GALERI --}}
        <!-- /////////////////////////////////// -->
        <div class="col-md-6">
            <div class="mt-4">
                <div class="accordion accordion-solid-header" id="accordion-5" role="tablist">
                    <div class="card">
                        <div style="background-color: #563fbb" class="card-header text-white" role="tab" id="heading-11">
                            <h6 class="mb-0">
                                <a data-toggle="" href="#collapse-11" aria-expanded="true"
                                    aria-controls="collapse-11" class="collapsed">
                                    Ubah Nama Folder/Album {{ $galeri->galeri }}
                                </a>
                            </h6>
                        </div>
                        <div id="collapse-11" class="" role="tabpanel" aria-labelledby="heading-11"
                            data-parent="#accordion-5" style="">
                            <div class="card-body">
                                <form action="{{ route('galeri.update', $galeri->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="form-group">
                                        <label for="">Edit Thumbnail</label><br>
                                        <input type="file" name="image" id="">
                                    </div>
                                    <input type="text" name="galeri" class="form-control"
                                        value="{{ $galeri->galeri }}"><br>
                                    <button class="btn btn-rounded btn-success btn-sm btn-block" type="submit"><i
                                            class="fas fa-save"></i> Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /////////////////////////////////// -->
    <!-- TAMPIL DATA -->
    <!-- /////////////////////////////////// -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row portfolio-grid">
                        @foreach ($galeri->galeri_fotos as $foto)
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                                <figure class="effect-text-in">
                                    <img src="{{ asset($foto->image) }}" alt="image">
                                    <figcaption>
                                        <form action="{{ route('delete_galeri_foto.destroy', $foto->id) }}" method="POST"
                                            onsubmit="return confirm('Apa anda yakin akan menghapus Data ini (Yakinkan lah aku)')">
                                            @csrf
                                            @method('delete')
                                            <a href="">
                                                <p><button type="submit" class="btn btn-danger btn-sm btn-block"><i
                                                            class="fa fa-trash "></i> Hapus</button></p>
                                            </a>
                                        </form>
                                    </figcaption>
                                </figure>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
