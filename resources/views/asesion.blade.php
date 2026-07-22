@extends('layout.asesi')

@section('judul')
    ASESI {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h4>
            <i class="fas fa-user"></i> Selamat Datang, {{ Auth::user()->name }}
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom" style="background-color: var(--secondary-color);">
                <li style="color: #fff" class="breadcrumb-item"><a style="color: #fff" href="{{ route('admin') }}">LSP {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div><br>

    <div class="row">
        <div class="card col-md-7">
            <div class="card-body">
                <h4 class="card-title"><i class="fas fa-info-circle"></i> Informasi</h4>
                <hr>
                <ol>
                    <li class="font-weight-bold">Sebelum mendaftar sertifikasi skema, harap dilengkapi data "Profil Anda"
                        terlebih dahulu.</li>
                    <li class="font-weight-bold">Sebelum mendaftar harap diperhatikan unit-unit skema yang
                        akan anda dipilih.</li>
                    <li class="font-weight-bold">Setelah itu anda dapat melakukan pendaftaran sertifikasi dengan menekan
                        tombol "Pendaftaran Sertifkasi" yang terletak didalam menu Assesment.</li>
                    <li class="font-weight-bold">Jika masih bingun dalam proses mendaftar di aplikasi maka anda dapat
                        memilih tombol
                        bantuan yang ada dibawah ini.</li>
                </ol>
                @foreach ($info as $asu)
                    <a href="{{ $asu->keterangan }}" target="_blank" rel="noopener noreferrer"><button
                            class="btn btn-sm btn-warning"><i class="fas fa-play-circle"></i> Video Tutorial Penggunaan
                            Aplikasi</button></a>
                @endforeach
                @foreach ($info2 as $asu)
                    <a href="{{ asset($asu->image) }}" target="_blank" rel="noopener noreferrer"><button
                            class="btn btn-sm btn-warning"><i class="fas fa-book-reader"></i> Manual Guide</button></a>
                @endforeach
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-user"></i> Profil Anda</h4>
                    {{-- <-------------------- PROFIL --------------------> --}}
                    <div class="d-flex flex-row">
                        @if (Auth::user()->image)
                            <img src="{{ asset(Auth::user()->image) }}" class="img-lg rounded" alt="image">
                        @else
                            <img src="{{ asset('general/assets/images/photo.jpg') }}" class="img-lg rounded" alt="image">
                        @endif
                        <div class="ml-3">
                            <h6 style="color: var(--primary-color)" class="font-weight-bold">{{ Auth::user()->name }}</h6>
                            <p class="text-black font-weight-bold">NIK :
                                {{ Auth::user()->nik }}</p>
                            <p class="mt-2 text-black font-weight-bold">{{ Auth::user()->jurusan ? Auth::user()->jurusan->jurusan : 'Jurusan tidak ditentukan' }}</p>
                            <p class="text-black font-weight-bold"><i class="fas fa-envelope"></i>
                                {{ Auth::user()->email }}</p>
                            <p class="text text-black font-weight-bold"> <i
                                    class="fas fa-certificate text-black font-weight-bold"></i> Sertifikat Tersedia:
                                {{ $datasertifikat }}
                            </p><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br>

    <div class="row">
        {{-- <-------------------- LENGKAPI DATA PENDAFTARAN --------------------> --}}
        @foreach ($datareg as $asu)
            <div class="card col-md-7">
                <div class="card-body">
                    <div class="row">
                        <a style="padding-left: 0%"
                            href="{{ route('registrasi.show', Crypt::encryptString($asu->id)) }}"><button
                                class="btn btn-success btn-rounded btn-sm">
                                <i class="fas fa-play-circle"></i> Lanjutkan Pengisian Data Pendaftaran Anda </button></a>
                        {{-- <button type="button" class="btn btn-info btn-sm btn-rounded" data-toggle="modal"
                            data-target="#exampleModal-{{ $asu->id }}"><i class="fas fa-flag-checkered"></i> Kirim Data Pendaftaran </button> --}}
                        <div class="btn btn-danger btn-rounded btn-sm" data-toggle="modal"
                            data-target="#datareg-{{ $asu->id }}"><i class="fa fa-trash "></i> Hapus
                        </div>
                    </div><br>
                    <div class="row">
                        <h4 class="card-title mb-0">{{ $asu->skema_name }}</h4>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-inline-block pt-3">
                            <div class="d-md-flex">
                                <h2 class="mb-0">#{{ $asu->id }}</h2>
                                <div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                                    <i class="far fa-calendar text-muted"></i>
                                    <small class=" ml-1 mb-0">{{ $asu->date }}</small>
                                </div>
                                <div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                                    <i class="far fa-clock text-muted"></i>
                                    <small class=" ml-1 mb-0">Waktu {{ $asu->time }}</small>
                                </div>
                            </div><br>
                            <div class="d-md-flex">
                                <div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                                    <i class="far fa-user text-muted"></i>
                                    <small class=" ml-1 mb-0">Asesor: {{ $asu->asesor?->nama ?? '-' }}</small>
                                </div>
                                <div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                                    <i class="far fa-map text-muted"></i>
                                    <small class=" ml-1 mb-0">Lokasi: {{ $asu->tuk?->tuk ?? '-' }}</small>
                                </div>
                            </div><br>
                            <div class="d-md-flex">
                                <div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                                    <i class="fas fa-info-circle text-muted"></i>
                                    <small class=" ml-1 mb-0">Keterangan:</small>
                                </div>
                            </div>
                        </div>
                        <div class="d-inline-block">
                            {{ $asu->status }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- <-------------------- MENUNGGU VALIDASI --------------------> --}}
        @foreach ($datareg1 as $asu)
            <div class="card col-md-7">
                <div class="card-body">
                    <div class="row">
                        {{-- <a href="{{ route('rekap_pendaftaran', $asu->id) }}"><button
                                class="btn btn-info btn-rounded btn-sm"><i class="fa fa-book "></i> Rekap Pendaftaran
                            </button></a> --}}
                        <div class="btn btn-danger btn-rounded btn-sm" data-toggle="modal"
                            data-target="#datareg-{{ $asu->id }}"><i class="fa fa-eraser "></i> Batalkan Pendaftaran
                        </div>
                    </div><br>
                    <div class="row">
                        <h4 class="card-title mb-0">{{ $asu->skema_name }}</h4>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-inline-block pt-3">
                            <div class="d-md-flex">
                                <h2 class="mb-0">#{{ $asu->id }}</h2>
                                <div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                                    <i class="far fa-calendar text-muted"></i>
                                    <small class=" ml-1 mb-0">{{ $asu->date }}</small>
                                </div>
                                <div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                                    <i class="far fa-clock text-muted"></i>
                                    <small class=" ml-1 mb-0">Waktu {{ $asu->time }}</small>
                                </div>
                            </div><br>
                            <div class="d-md-flex">
                                <div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                                    <i class="far fa-user text-muted"></i>
                                    <small class=" ml-1 mb-0">Asesor: {{ $asu->asesor?->nama ?? '-' }}</small>
                                </div>
                                <div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                                    <i class="far fa-map text-muted"></i>
                                    <small class=" ml-1 mb-0">Lokasi: {{ $asu->tuk?->tuk ?? '-' }}</small>
                                </div>
                            </div><br>
                            <div class="d-md-flex">
                                <div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                                    <i class="fas fa-info-circle text-muted"></i>
                                    <small class=" ml-1 mb-0">Keterangan: </small>
                                </div>
                            </div>
                        </div>
                        <div class="d-inline-block">
                            {{ $asu->status }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


        {{-- <-------------------- BLACKLIST --------------------> --}}
        @foreach ($datareg5 as $asu)
            <div class="card col-md-7">
                <div class="card-body">
                    <div class="row">
                        <button class="btn btn-warning btn-rounded btn-sm" data-toggle="modal"
                            data-target="#datareg223-{{ $asu->id }}"><i class="fa fa-info-circle "></i>Informasi
                            Detail
                        </button><br>
                    </div><br>
                    <div class="row">
                        <h4 class="card-title mb-0">{{ $asu->skema_name }}</h4>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-inline-block">{{ $asu->status }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- <--------------- FOOTER ---------------> --}}
        {{-- <div class="card col-md-5">
            <div class="card-body">
                <h4 class="card-title"><i class="fas fa-mobile"></i> Kontak Admin</h4>
                <br><br>
                <p style="font-size: 20px"><i class="fab fa-whatsapp-square"></i> 08965386474683</p>
                <p style="font-size: 20px"><i class="fas fa-envelope-square"></i> {{ $site_setting->email ?? 'info@lsp.com' }}</p>
            </div>
        </div> --}}
    </div>


    {{-- <--------------- MODAL HAPUS LENGKAPI DATA ---------------> --}}
    @foreach ($datareg as $asu)
        <div class="modal fade" id="datareg-{{ $asu->id }}" tabindex="-1" role="dialog"
            aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"><i class="fas fa-trash"></i>
                            {{ $asu->skema_name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda Yakin Untuk Menghapus Pendaftaran Ini?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('registrasi.destroy', $asu->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-trash "></i>
                                Hapus
                                Pendaftaran</button>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- <--------------- MODAL HAPUS Menunggu Validasi... ---------------> --}}
    @foreach ($datareg1 as $asu)
        <div class="modal fade" id="datareg-{{ $asu->id }}" tabindex="-1" role="dialog"
            aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"><i class="fas fa-trash"></i>
                            {{ $asu->skema_name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda Yakin Untuk Menghapus Pendaftaran Ini?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('registrasi.destroy', $asu->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-trash "></i>
                                Hapus
                                Pendaftaran</button>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- <--------------- MODAL SERTIFIKASI ---------------> --}}
    @foreach ($datareg4 as $asu)
        <div class="modal fade" id="exampleModal2z-{{ $asu->id }}" tabindex="-1" role="dialog"
            aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"><i class="fas fa-trash"></i>
                            {{ $asu->skema_name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        OK
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('registrasi.update', $asu->id) }}" method="POST">
                            @csrf
                            @method('put')
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-trash "></i>
                                Hapus
                                Pendaftaran</button>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- <--------------- MODAL BLACKLIST ---------------> --}}
    @foreach ($datareg5 as $asu)
        <div class="modal fade" id="datareg223-{{ $asu->id }}" tabindex="-1" role="dialog"
            aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"><i class="fas fa-trash"></i>
                            {{ $asu->skema_name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ $asu->keterangan }}
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('registrasi.update', $asu->id) }}" method="POST">
                            @csrf
                            @method('put')
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-trash "></i>
                                Hapus
                                Pendaftaran</button>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


@endsection
