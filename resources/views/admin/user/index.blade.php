@extends('layout/admin')

@section('judul')
    User | Admin LSP
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h4>
            <i class="fas fa-user"></i> User
        </h4>
        <!-- /////////////////////////////////// -->
        <!-- BREADCRUMB -->
        <!-- /////////////////////////////////// -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom  bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
        </nav>
    </div><br>

    <div class="accordion accordion-solid-header" id="accordion-4" role="tablist">
        <div class="card">
            <div class="card-header" role="tab" id="heading-user-create">
                <h6 class="mb-0">
                    <a class="collapsed" data-toggle="collapse" href="#collapse-user-create" aria-expanded="true"
                        aria-controls="collapse-user-create">
                        &plus; Klik disini Untuk Menambahkan Pengguna
                    </a>
                </h6>
            </div>
            <div id="collapse-user-create" class="collapse" role="tabpanel" aria-labelledby="heading-user-create" data-parent="#accordion-4">
                <div class="card-body">
                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="form-sample">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Role</label>
                                    <div class="col-md-12">
                                        <select name="role" class="form-control" required>
                                            @php $roles = ['admin', 'asesi', 'asesor']; @endphp
                                            @foreach ($roles as $r)
                                                <option value="{{ $r }}" {{ old('role') === $r ? 'selected' : '' }}>{{ $r }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama</label>
                                    <div class="col-md-12">
                                        <input type="text" maxlength="100" name="name" class="form-control" placeholder="Nama Lengkap" required value="{{ old('name') }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" maxlength="255" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-md-12">
                                        <input type="password" maxlength="100" name="password" class="form-control" placeholder="Password" required />
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-rounded btn-success btn-icon-text btn-block">
                                    <i class="fa fa-save btn-icon-prepend"></i>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- /////////////////////////////////// -->
    <!-- TAMPIL DATA -->
    <!-- /////////////////////////////////// -->
    <div class="card">
        <div class="card-body">
            <div class="card-description">
                <p><i class="fas fa-info-circle"></i> Informasi :
                    <ul>
                        <li>Pada tabel menampilkan seluruh akun milik asesi yang terdaftar pada sistem informasi.</li>
                        <li>Untuk keperluan mendesak, Anda dapat mengubah nama, NIK, dan kata sandi pada akun asesi.</li>
                    </ul>
                </p>
            </div>
            <h4 class="card-title"><i class="fas fa-table"></i> Table User</h4>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive table-striped">
                        <div id="order-listing_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="order-listing" class="table dataTable no-footer" role="grid"
                                        aria-describedby="order-listing_info">
                                        <thead>
                                            <tr class="bg-danger text-white" role="row">
                                                <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Order #: activate to sort column ascending"
                                                    style="width: 5.4219px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Actions: activate to sort column ascending"
                                                    style="width: 5.141px;">Actions</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Customer: activate to sort column ascending"
                                                    style="width: 5.75px;">Photo</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Ship to: activate to sort column ascending"
                                                    style="width: 607.5469px;">Nama</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Ship to: activate to sort column ascending"
                                                    style="width: 307.5469px;">Role</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Ship to: activate to sort column ascending"
                                                    style="width: 107.5469px;">Bergabung</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user as $hasil => $asu)
                                                <tr role="row" class="odd">
                                                    <td class="">{{ $loop->iteration }}</td>
                                                    <td class="text-right">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle"
                                                            type="button" id="dropdownMenuSizeButton3"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fa fa-cog"></i>
                                                        </button>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuSizeButton3">
                                                            <a href="{{ route('user.show', $asu->id) }}"><button
                                                                    type="submit"
                                                                    class="btn btn-warning btn-sm btn-block"><i
                                                                        class="fa fa-edit "></i> Lihat & Edit
                                                                    Pengguna</button></a>
                                                            <button data-toggle="modal"
                                                                data-target="#datareg-{{ $asu->id }}"
                                                                class="btn btn-danger btn-block"><i
                                                                    class="fa fa-trash "></i> Hapus</button>
                                                        </div>
                                                    </td>
                                                    <td class="py-1" style="align-content: right">
                                                        @if ($asu->image)
                                                            <img src="{{ asset($asu->image) }}" alt="image">
                                                        @else
                                                            <img src="{{ asset('general/assets/images/photo.jpg') }}"
                                                                alt="image">
                                                        @endif
                                                    </td>
                                                    <td>{{ $asu->name }}</td>
                                                    <td>{{ $asu->roles->isNotEmpty() ? $asu->roles->pluck('name')->join(', ') : '-' }}</td>
                                                    <td>{{ $asu->created_at->format('d-M-Y') }}
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <--------------- MODAL HAPUS DATA ---------------> --}}
    @foreach ($user as $asu)
        <div class="modal fade" id="datareg-{{ $asu->id }}" tabindex="-1" role="dialog"
            aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"><i class="fas fa-trash"></i>
                            {{ $asu->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda Yakin Untuk Menghapus Data Ini?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('user.destroy', $asu->id) }}" method="POST">
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
