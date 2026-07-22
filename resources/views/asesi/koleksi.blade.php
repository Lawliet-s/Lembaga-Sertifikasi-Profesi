@extends('layout/asesi')

@section('judul')
    Koleksi Sertifikat {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    <div class="page-header">
        <h4>
            <i class="fas fa-certificate"></i> Koleksi Sertifikat
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom  bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('dashasesi.index') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Koleksi Sertifikat</li>
            </ol>
        </nav>
    </div><br>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><i class="fas fa-table"></i> Daftar Pemegang Sertifikat</h4>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive table-striped">
                        <div id="order-listing_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="order-listing" class="table dataTable no-footer" role="grid"
                                        aria-describedby="order-listing_info">
                                        <thead>
                                             <tr role="row" style="background-color: var(--secondary-color); color: #fff;">
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 10px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 80px;">Aksi</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 150px;">Kode Registrasi</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 400px;">Skema</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 100px;">Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($datareg as $item)
                                                <tr role="row" class="odd">
                                                    <td class="font-weight-bold">{{ $loop->iteration }}</td>
                                                    <td class="text-right">
                                                         <a href="{{ route('asesi.sertifikat_show', Crypt::encryptString($item->id)) }}?print=1" class="btn btn-sm font-weight-bold" style="background-color: var(--secondary-color); color: #fff; border: none;" target="_blank">
                                                             <i class="fa fa-print"></i> Cetak
                                                         </a>
                                                     </td>
                                                     <td class="font-weight-bold">{{ sprintf('%04d', $item->id) }}</td>
                                                    <td class="font-weight-bold">{{ $item->skema_name }}</td>
                                                    <td class="font-weight-bold">{{ $item->updated_at }}</td>
                                                </tr>
                                            @empty
                                                <tr role="row">
                                                    <td colspan="5" class="text-center py-4 text-muted">
                                                        <i class="fas fa-certificate fa-2x mb-2"></i><br>
                                                        Belum ada sertifikat.
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
