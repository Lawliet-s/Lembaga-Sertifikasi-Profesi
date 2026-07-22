@extends('layout/admin')

@section('judul')
    Data Ditolak | Admin LSP
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    @include('layout/verifikasi')

    <div class="page-header">
        <h4>
            <i class="fas fa-times-circle"></i> Data Registrasi Ditolak
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom bg-danger">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}" style="color: var(--secondary-color)">Dashboard</a></li>
                <li class="breadcrumb-item active" style="color: #fff" aria-current="page">Data Registrasi Ditolak</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="order-listing" class="table table-striped table-hover">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>#</th>
                            <th>Aksi</th>
                            <th>Kode Registrasi</th>
                            <th>Nama</th>
                            <th>Skema</th>
                            <th>Mendaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($validasi as $asu)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('validasi.show', $asu->id) }}">
                                                <i class="fa fa-eye text-info"></i> Detail Data
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <button class="dropdown-item text-danger" data-toggle="modal" data-target="#hapus-{{ $asu->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </td>
								<td>{{ sprintf('%04d', $asu->id) }}</td>
								<td>{{ $asu->user_name }}</td>
                                <td>{{ $asu->skema_name }}</td>
                                <td>{{ $asu->created_at->format('d-M-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    @foreach ($validasi as $asu)
        <div class="modal fade" id="hapus-{{ $asu->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-trash"></i> {{ $asu->user_name }}</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">Yakin ingin menghapus pendaftaran ini?</div>
                    <div class="modal-footer">
                        <form action="{{ route('validasi.destroy', $asu->id) }}" method="POST">
                            @csrf @method('delete')
                            <button type="submit" class="btn btn-success"><i class="fa fa-trash"></i> Hapus</button>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
