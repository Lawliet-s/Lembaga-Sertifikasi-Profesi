@extends('layout/asesi')

@section('judul')
    Informasi Skema {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')

<div class="page-header">
    <h4>
        <i class="fas fa-list"></i>  Informasi Skema
    </h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-custom  bg-danger">
            <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('dashasesi.index') }}">Dashboard</a></li>
            <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Informasi Skema</li>
        </ol>
    </nav>
</div><br>

<div class="card">
    <div class="card-body">
        <h4 class="card-title"><i class="fas fa-table"></i> Daftar Skema</h4>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive table-striped">
                    <div id="order-listing_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="order-listing" class="table dataTable no-footer" role="grid"
                                    aria-describedby="order-listing_info">
                                    <thead>
                                        <tr role="row" style="background-color: var(--primary-color); color: #fff;">
                                            <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 10px;">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 80px;">Aksi</th>
                                            <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 200px;">Kode Skema</th>
                                            <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 500px;">Skema</th>
                                            <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 100px;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($skema as $item)
                                            <tr role="row" class="odd">
                                                <td class="font-weight-bold">{{ $loop->iteration }}</td>
                                                <td class="text-right">
                                                    <a href="{{ route('info_skema.show', Crypt::encryptString($item->id)) }}" class="btn btn-dark btn-sm font-weight-bold">
                                                        <i class="fa fa-search"></i> Lihat
                                                    </a>
                                                </td>
                                                <td class="font-weight-bold">{{ $item->kode_skema }}</td>
                                                <td class="font-weight-bold">{{ $item->skema }}</td>
                                                <td class="font-weight-bold">{{ $item->status_id }}</td>
                                            </tr>
                                        @empty
                                            <tr role="row">
                                                <td colspan="5" class="text-center py-4 text-muted">
                                                    <i class="fas fa-list fa-2x mb-2"></i><br>
                                                    Belum ada skema tersedia.
                                                </td>
                                            </tr>
                                        @endforelse
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

@endsection
