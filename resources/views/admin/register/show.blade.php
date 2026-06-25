@extends('layout/admin')

@section('judul')
    {{ $validasi->user_name }} | Admin LSP
@endsection

@section('sidebar')
    sidebar-icon-only
@endsection

@section('isi')
    @include('layout/verifikasi')

    <div class="page-header">
        <h4>
            <i class="fas fa-edit"></i> Rincian Data Pemohon Sertifikasi
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom bg-danger">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}" style="color: var(--secondary-color)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('registrasi.baru') }}" style="color: var(--secondary-color)">Data Pendaftaran Terbaru</a></li>
                <li class="breadcrumb-item active" style="color: #fff" aria-current="page">{{ $validasi->id }}</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        {{-- LEFT COLUMN: Tables --}}
                        <div class="col-lg-4">
                            {{-- Data Sertifikasi --}}
                            <h4 class="card-title"><i class="far fa-id-card"></i> Data Sertifikasi</h4>
                            <hr class="my-2">
                            <table class="table table-bordered table-sm">
                                <tr><td class="text-muted" style="width:120px">Kode Registrasi</td><td>{{ $validasi->id }}</td></tr>
                                <tr><td class="text-muted">Skema yang Diambil</td><td>{{ $validasi->skema_name }}</td></tr>
                                <tr><td class="text-muted">Kode Skema</td><td>{{ $validasi->kode_skema }}</td></tr>
                                <tr><td class="text-muted">Tujuan Sertifikasi</td><td>{{ $validasi->jenis }}</td></tr>
                                <tr><td class="text-muted">Tanggal Mendaftar</td><td>{{ $validasi->created_at->format('d-M-Y') }}</td></tr>
                            </table>
                            <div class="mt-4"></div>

                            {{-- Data Pribadi --}}
                            <h4 class="card-title"><i class="far fa-id-card"></i> Data Pribadi</h4>
                            <hr class="my-2">
                            <table class="table table-bordered table-sm">
                                <tr><td class="text-muted" style="width:120px">Nama Asesi</td><td>{{ $validasi->user_name }}</td></tr>
                                <tr><td class="text-muted">NIK</td><td>{{ $validasi->nik }}</td></tr>
                                <tr><td class="text-muted">Tempat Lahir</td><td>{{ $validasi->tmpt_lahir }}</td></tr>
                                <tr><td class="text-muted">Tanggal Lahir</td><td>{{ $validasi->tgl_lahir }}</td></tr>
                                <tr><td class="text-muted">Jenis Kelamin</td><td>{{ $validasi->sex->sex ?? '-' }}</td></tr>
                                <tr><td class="text-muted">Kewarganegaraan</td><td>{{ $validasi->negara }}</td></tr>
                                <tr><td class="text-muted">Alamat</td><td>{{ $validasi->alamat }}</td></tr>
                                <tr><td class="text-muted">Kode Pos</td><td>{{ $validasi->kode_post }}</td></tr>
                                <tr><td class="text-muted">Email</td><td>{{ $validasi->surel }}</td></tr>
                                <tr><td class="text-muted">No. Handphone</td><td>{{ $validasi->no_hp }}</td></tr>
                                <tr><td class="text-muted">No. Telp Rumah</td><td>{{ $validasi->rmh ?? '-' }}</td></tr>
                                <tr><td class="text-muted">No. Telp Kantor</td><td>{{ $validasi->ktr ?? '-' }}</td></tr>
                                <tr><td class="text-muted">Pendidikan Terakhir</td><td>{{ $validasi->tmt }}</td></tr>
                                <tr><td class="text-muted">Jurusan</td><td>{{ $validasi->jurusan->jurusan ?? '-' }}</td></tr>
                                <tr><td class="text-muted">Semester Kuliah</td><td>{{ $validasi->semester->semester ?? '-' }}</td></tr>
                            </table>
                            <div class="mt-4"></div>

                            {{-- Data Pekerjaan --}}
                            <h4 class="card-title"><i class="far fa-id-card"></i> Data Pekerjaan Sekarang</h4>
                            <hr class="my-2">
                            <table class="table table-bordered table-sm">
                                <tr><td class="text-muted" style="width:120px">Institusi/Perusahaan</td><td>{{ $validasi->institusi }}</td></tr>
                                <tr><td class="text-muted">Jabatan</td><td>{{ $validasi->jabatan }}</td></tr>
                                <tr><td class="text-muted">Alamat Kantor</td><td>{{ $validasi->alamat_kantor }}</td></tr>
                                <tr><td class="text-muted">Kode Pos Kantor</td><td>{{ $validasi->postal }}</td></tr>
                                <tr><td class="text-muted">No. Telp Kantor</td><td>{{ $validasi->telp }}</td></tr>
                                <tr><td class="text-muted">Email Kantor</td><td>{{ $validasi->email3 }}</td></tr>
                                <tr><td class="text-muted">No. Fax Kantor</td><td>{{ $validasi->fax ?? '-' }}</td></tr>
                            </table>
                        </div>

                        {{-- RIGHT COLUMN: Status & Documents --}}
                        <div class="col-lg-8 pl-lg-5">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1 text-dark">{{ $validasi->user_name }}</h5>
                                    <h5 class="mb-0 text-dark">{{ $validasi->skema_name }}</h5>
                                </div>
                                @include('partials.status_badge', ['status' => $validasi->status])
                            </div>
                            <hr>

                            {{-- Ubah Status --}}
                            <div class="card bg-light p-3 mb-4">
                                <h6 class="card-title mb-2"><i class="fas fa-flag"></i> Ubah Status Pendaftaran</h6>
                                <form action="{{ route('validasi.status', $validasi->id) }}" method="POST" class="form-inline">
                                    @csrf @method('put')
                                    <select name="status" class="form-control form-control-sm mr-2 mb-2">
                                        <option value="pending" {{ Str::contains($validasi->status, 'Menunggu Validasi') ? 'selected' : '' }}>Menunggu Validasi</option>
                                        <option value="diverifikasi" {{ Str::contains($validasi->status, 'Divalidasi') ? 'selected' : '' }}>Diverifikasi</option>
                                        <option value="ditolak" {{ Str::contains($validasi->status, 'Ditolak') ? 'selected' : '' }}>Ditolak</option>
                                        <option value="revisi" {{ Str::contains($validasi->status, 'Revisi') ? 'selected' : '' }}>Revisi</option>
                                    </select>
                                    <input type="text" name="keterangan" class="form-control form-control-sm mr-2 mb-2" placeholder="Keterangan (opsional)" value="{{ $validasi->keterangan }}" style="min-width:200px">
                                    <button type="submit" class="btn btn-sm btn-primary mb-2"><i class="fas fa-save"></i> Simpan</button>
                                </form>
                            </div>

                            {{-- Uploaded Documents --}}
                            <h4 class="card-title"><i class="far fa-id-card"></i> Bukti Persyaratan Dasar Pemohon</h4>
                            <hr class="my-2">
                            @if ($validasi->upload_files->count())
                                <div class="row">
                                    @foreach ($validasi->upload_files as $file)
                                        <div class="col-md-6 mb-3">
                                            <div class="border rounded p-2 d-flex align-items-center">
                                                @if ($file->image)
                                                    <a href="{{ asset('storage/' . $file->image) }}" target="_blank" class="mr-2 text-success">
                                                        <i class="fas fa-check-circle fa-lg"></i>
                                                    </a>
                                                    <a href="{{ asset('storage/' . $file->image) }}" target="_blank" class="text-truncate d-inline-block" style="max-width:180px">
                                                        {{ $file->name }}
                                                    </a>
                                                    <a href="{{ asset('storage/' . $file->image) }}" target="_blank" class="ml-auto">
                                                        <img src="{{ asset('storage/' . $file->image) }}" width="50" height="50" class="rounded" style="object-fit:cover">
                                                    </a>
                                                @else
                                                    <span class="mr-2 text-muted"><i class="fas fa-times-circle fa-lg"></i></span>
                                                    <span class="text-muted">{{ $file->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">Belum ada file yang diunggah.</p>
                            @endif

                            <div class="mt-4"></div>

                            {{-- FR.APL.01 --}}
                            <h4 class="card-title"><i class="fas fa-file-alt"></i> Data FR.APL.01 — Unit Kompetensi</h4>
                            <hr class="my-2">
                            @if ($skema && $skema->unikoms->count())
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width:40px">#</th>
                                                <th>Kode Unit</th>
                                                <th>Judul Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($skema->unikoms as $uk)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $uk->kode_unikom ?? '-' }}</td>
                                                    <td>{{ $uk->unikom ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Tidak ada data unit kompetensi untuk skema ini.</p>
                            @endif
                            <div class="mt-4"></div>

                            {{-- Self Assessment --}}
                            <h4 class="card-title"><i class="far fa-id-card"></i> Bukti Asesmen Mandiri</h4>
                            <hr class="my-2">
                            @if ($validasi->xnxxes->count())
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width:40px">#</th>
                                                <th style="width:80px">Status</th>
                                                <th>Elemen</th>
                                                <th style="width:100px">Bukti</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($validasi->xnxxes as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>@include('partials.status_badge', ['status' => $data->status])</td>
                                                    <td>{{ $data->asesmen_name }}</td>
                                                    <td>
                                                        @if ($data->image)
                                                            <a href="{{ asset('storage/' . $data->image) }}" target="_blank" class="text-primary">
                                                                <i class="fas fa-check-circle"></i> ADA
                                                            </a>
                                                        @else
                                                            <span class="text-muted"><i class="fas fa-times-circle"></i> KOSONG</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Belum ada data asesmen mandiri.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
