@extends('layout.admin')

@section('judul')
    Jadwal Asesmen | Admin LSP
@endsection

@section('sidebar')
    sidebar-icon-only
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h3>
            <i class="fas fa-calendar-alt"></i> Jadwal Asesmen
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Jadwal Asesmen</li>
            </ol>
        </nav>
    </div><br>

    <div class="accordion accordion-solid-header" id="accordion-jadwal" role="tablist">
        <div class="card">
            <div class="card-header" role="tab" id="heading-jadwal">
                <h6 class="mb-0">
                    <a class="collapsed" data-toggle="collapse" href="#collapse-jadwal" aria-expanded="true"
                        aria-controls="collapse-jadwal">
                        &plus; Klik disini Untuk Menambahkan Jadwal Asesmen
                    </a>
                </h6>
            </div>
            <div id="collapse-jadwal" class="collapse" role="tabpanel" aria-labelledby="heading-jadwal"
                data-parent="#accordion-jadwal">
                <div class="card-body">
                    <form action="{{ route('jadwal.store') }}" method="POST" class="form-control">
                        @csrf
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-plus"></i> Tambah Jadwal Asesmen</h4>
                            <div class="col-md-12">
                                <label class="font-weight-bold text-primary">Skema Sertifikasi</label>
                                <select name="skema_id" class="form-control" required>
                                    <option value="">Pilih Skema</option>
                                    @foreach ($skema as $item)
                                        <option value="{{ $item->id }}">{{ $item->skema }}</option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="col-md-12">
                                <label class="font-weight-bold text-primary">TUK / Lokasi Uji</label>
                                <select name="tuk_id" class="form-control" required>
                                    <option value="">Pilih TUK</option>
                                    @foreach ($tuk as $item)
                                        <option value="{{ $item->id }}">{{ $item->tuk }}</option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="col-md-12">
                                <label class="font-weight-bold text-primary">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div><br>
                            <div class="col-md-12">
                                <label class="font-weight-bold text-primary">Jam</label>
                                <input type="time" name="jam" class="form-control">
                            </div><br>
                            <div class="col-md-12">
                                <label class="font-weight-bold text-primary">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Keterangan tambahan"></textarea>
                            </div><br>
                            <div class="col-md-12">
                                <label class="font-weight-bold text-primary">Status</label>
                                <select name="status" class="form-control">
                                    <option value="aktif">Aktif</option>
                                    <option value="ditutup">Ditutup</option>
                                </select>
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
            <h4 class="card-title"><i class="fas fa-list"></i> List Jadwal Asesmen</h4>
            <div class="table-responsive">
                <table id="order-listing" class="table dataTable no-footer" role="grid">
                    <thead>
                        <tr class="bg-danger text-white">
                            <th style="width: 10px">#</th>
                            <th style="width: 10px">Aksi</th>
                            <th>Skema</th>
                            <th>TUK</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwal as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                                        <a href="{{ route('jadwal.edit', $item->id) }}">
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
                                <td>{{ $item->skema->skema ?? '-' }}</td>
                                <td>{{ $item->tuk->tuk ?? '-' }}</td>
                                <td>{{ optional($item->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $item->jam ?? '-' }}</td>
                                <td>
                                    @if ($item->status == 'aktif')
                                        <label class="badge badge-success">Aktif</label>
                                    @else
                                        <label class="badge badge-danger">Ditutup</label>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada data jadwal.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($jadwal as $item)
        <div class="modal fade" id="hapus-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"><i class="fas fa-trash"></i>
                            {{ $item->skema->skema ?? 'Jadwal' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda Yakin Untuk Menghapus Data Ini?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('jadwal.destroy', $item->id) }}" method="POST">
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
