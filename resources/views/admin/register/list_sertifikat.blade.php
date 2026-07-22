@extends('layout/admin')

@section('judul')
    Data Sertifikat | Admin LSP
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    @include('layout/verifikasi')

    <div class="page-header">
        <h4>
            <i class="fas fa-certificate"></i> Data Pemegang Sertifikat
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom bg-danger">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}" style="color: var(--secondary-color)">Dashboard</a></li>
                <li class="breadcrumb-item active" style="color: #fff" aria-current="page">Data Pemegang Sertifikat</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="fas fa-info-circle mr-2"></i>
                <span>Data pemegang sertifikat yang telah dinyatakan kompeten.</span>
            </div>
            <div class="table-responsive">
                <table id="order-listing" class="table table-striped table-hover">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>#</th>
                            <th>Aksi</th>
                            <th>Kode Registrasi</th>
                            <th>Nama</th>
                            <th>Skema</th>
                            <th>Tanggal</th>
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
                                            <a class="dropdown-item" href="{{ route('sertifikat_show', $asu->id) }}">
                                                <i class="fa fa-eye text-info"></i> Detail Data
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('validasi.destroy', $asu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf @method('delete')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
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
@endsection
