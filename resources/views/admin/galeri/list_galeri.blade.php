@extends('layout/admin')

@section('judul')
    Album | Admin LSP
@endsection

@section('sidebar')
    sidebar-icon-only
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h4>
            <i class="fas fa-image"></i> Album Foto
        </h4>
        <!-- /////////////////////////////////// -->
        <!-- BREADCRUMB -->
        <!-- /////////////////////////////////// -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom  bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ (Auth::user() && Auth::user()->hasRole('asesor')) ? route('dashboard.asesor') : route('admin') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Album Foto</li>
            </ol>
        </nav>
    </div><br>
    <!-- /////////////////////////////////// -->
    <!-- TAMBAH DATA -->
    <!-- /////////////////////////////////// -->
    <div class="col-md-12">
        <div class="accordion accordion-solid-header" id="accordion-4" role="tablist">
            <div class="card text-white">
                <div style="background-color: #563fbb" class="card-header" role="tab" id="heading-10">
                    <h6 class="mb-0">
                        <a data-toggle="collapse" href="#collapse-10" aria-expanded="false" aria-controls="collapse-10"
                            class="collapsed">
                            + Tambah Album Baru
                        </a>
                    </h6>
                </div>
                <div id="collapse-10" class="collapse" role="tabpanel" aria-labelledby="heading-10"
                    data-parent="#accordion-4" style="">
                    <div class="card-body">
                        <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="text-dark font-weight-bold">Masukan Thumbnail Album</label><br>
                                <input type="file" name="image" id="album-file-input" class="form-control-file" accept=".jpg,.jpeg,.png">
                                <span class="text-dark d-inline-block mt-1" id="album-file-chosen">No file chosen</span>
                            </div>
                            <input type="text" name="galeri" class="form-control mb-3" placeholder="Nama Album" value="">
                            <button class="btn btn-success btn-rounded btn-sm btn-block py-2 font-weight-bold" type="submit"><i
                                    class="fas fa-save"></i> Simpan</button>
                        </form>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const albumInput = document.getElementById('album-file-input');
                                const albumLabel = document.getElementById('album-file-chosen');
                                if (albumInput) {
                                    albumInput.addEventListener('change', function(e) {
                                        let fileName = e.target.files[0] ? e.target.files[0].name : "No file chosen";
                                        albumLabel.textContent = fileName;
                                    });
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /////////////////////////////////// -->
    <!-- TAMPIL DATA -->
    <!-- /////////////////////////////////// -->
    <div class="col-md-12">
        <div class="row portfolio-grid">
            @foreach ($galeri as $asu)
                <div class="card col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card-body">
                        <figure class="effect-text-in">
                            @if ($asu->image)
                                <img src="{{ asset($asu->image) }}" alt="image">
                            @else
                                <img src="https://picsum.photos/1000/800/?random" alt="image">
                            @endif
                            <figcaption>
                                <h4>{{ $asu->galeri }}</h4>
                                <p>{{ $asu->created_at }}</p>
                            </figcaption>
                        </figure>
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cog"></i> {{ $asu->galeri }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                            <a href="{{ route('galeri.show', Crypt::encryptString($asu->id)) }}"><button
                                    class="btn btn-warning btn-sm btn-block"><i class="fa fa-eye "></i> Lihat &
                                    Edit Galeri {{ $asu->galeri }}</button></a>
                            <button data-toggle="modal" data-target="#datareg-{{ $asu->id }}"
                                class="btn btn-danger btn-block"><i class="fa fa-trash "></i> Hapus</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- <--------------- MODAL HAPUS DATA ---------------> --}}
    @foreach ($galeri as $asu)
        <div class="modal fade" id="datareg-{{ $asu->id }}" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"><i class="fas fa-trash"></i>
                            {{ $asu->galeri }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda Yakin Untuk Menghapus Data Ini?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('galeri.destroy', $asu->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <a href=""><button type="submit" class="btn btn-success btn-block"><i
                                        class="fa fa-trash "></i> Hapus</button></a>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
