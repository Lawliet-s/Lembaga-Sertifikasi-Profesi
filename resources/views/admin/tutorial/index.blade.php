@extends('layout.admin')

@section('judul')
    Prosedur Sertifikasi | Admin LSP
@endsection

@section('sidebar')
    sidebar-icon-only
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h3>
            <i class="fas fa-pencil-square"></i> Prosedur Sertifikasi
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Prosedur Sertifikasi</li>
            </ol>
        </nav>
    </div><br>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="accordion accordion-solid-header" id="accordion-tutorial" role="tablist">
        <div class="card">
            <div class="card-header" role="tab" id="heading-tutorial">
                <h6 class="mb-0">
                    <a class="collapsed" data-toggle="collapse" href="#collapse-tutorial" aria-expanded="true"
                        aria-controls="collapse-tutorial">
                        &plus; Klik disini Untuk Menambahkan Prosedur Sertifikasi
                    </a>
                </h6>
            </div>
            <div id="collapse-tutorial" class="collapse" role="tabpanel" aria-labelledby="heading-tutorial"
                data-parent="#accordion-tutorial">
                <div class="card-body">
                    <form action="{{ route('tutorial.store') }}" method="POST" class="form-control">
                        @csrf
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-plus"></i> Tambah Prosedur Sertifikasi</h4>
                            <div class="col-md-12">
                                <label class="font-weight-bold text-primary">Judul Prosedur</label>
                                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul prosedur" required>
                            </div><br>
                            <div class="col-md-12">
                                <label class="font-weight-bold text-primary">Konten</label>
                                <textarea name="konten" class="summernote"></textarea>
                            </div><br>
                            <div class="col-md-12">
                                <label class="font-weight-bold text-primary">Tautan (Opsional)</label>
                                <input type="url" name="tautan" class="form-control" placeholder="https://example.com">
                            </div><br>
                            <div class="col-md-12">
                                <label class="font-weight-bold text-primary">Urutan</label>
                                <input type="number" name="urutan" class="form-control" placeholder="Urutan tampilan (1, 2, 3, ...)">
                            </div><br>
                            <button type="submit" class="btn btn-rounded btn-success btn-block">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><br>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><i class="fas fa-list"></i> List Prosedur Sertifikasi</h4>
            <div class="table-responsive">
                <table id="order-listing" class="table dataTable no-footer" role="grid">
                    <thead>
                        <tr class="bg-danger text-white">
                            <th style="width: 10px">#</th>
                            <th style="width: 10px">Aksi</th>
                            <th>Judul</th>
                            <th>Urutan</th>
                            <th>Tautan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tutorials as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                                        <a href="{{ route('tutorial.edit', $item->id) }}">
                                            <button type="submit" class="btn btn-warning btn-sm btn-block">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                        </a>
                                        <button data-toggle="modal" data-target="#hapus-{{ $item->id }}"
                                            class="btn btn-danger btn-block">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->urutan ?? '-' }}</td>
                                <td>
                                    @if ($item->tautan)
                                        <a href="{{ $item->tautan }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class="fas fa-external-link-alt"></i> Buka
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada data prosedur.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($tutorials as $item)
        <div class="modal fade" id="hapus-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"><i class="fas fa-trash"></i>
                            {{ $item->judul }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda Yakin Untuk Menghapus Data Ini?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('tutorial.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
