@extends('layout.asesi')

@section('judul')
    FR.AK.03 | ASESI {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h4>FR.AK.03 - Evaluasi Kepuasan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('dashasesi.index') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">FR.AK.03</li>
            </ol>
        </nav>
    </div><br>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><i class="fas fa-table"></i> Daftar Pendaftaran</h4>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive table-striped">
                        <div id="order-listing_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="order-listing" class="table dataTable no-footer" role="grid">
                                         <thead>
                                             <tr class="bg-danger text-white" role="row">
                                                 <th class="sorting" style="width: 10px;">#</th>
                                                 <th class="sorting" style="width: 80px;">Aksi</th>
                                                 <th class="sorting" style="width: 150px;">Kode Registrasi</th>
                                                 <th class="sorting" style="width: 300px;">Skema Sertifikasi</th>
                                                 <th class="sorting" style="width: 150px;">Status Pendaftaran</th>
                                                 <th class="sorting" style="width: 150px;">Status FR.AK.03</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @forelse ($registrations as $reg)
                                                 @php
                                                     $frAk03 = \App\Models\FrAk03::where('data_register_id', $reg->id)->first();
                                                 @endphp
                                                 <tr role="row" class="odd">
                                                     <td class="font-weight-bold">{{ $loop->iteration }}</td>
                                                     <td class="text-right">
                                                         <a href="{{ route('frak03.create', $reg->id) }}" class="btn btn-dark btn-sm font-weight-bold">
                                                             <i class="fa fa-edit"></i> Isi
                                                         </a>
                                                     </td>
                                                     <td class="font-weight-bold">{{ sprintf('%04d', $reg->id) }}</td>
                                                     <td class="font-weight-bold">{{ $reg->skema_name ?? '-' }}</td>
                                                     <td class="font-weight-bold"><span class="badge badge-info">{{ $reg->status }}</span></td>
                                                     <td class="font-weight-bold">
                                                         @if ($frAk03)
                                                             <span class="badge badge-success">Sudah Diisi</span>
                                                         @else
                                                             <span class="badge badge-warning">Belum</span>
                                                         @endif
                                                     </td>
                                                 </tr>
                                             @empty
                                                 <tr role="row">
                                                     <td colspan="6" class="text-center py-4 text-muted">
                                                         <i class="fas fa-list fa-2x mb-2"></i><br>
                                                         Tidak ada pendaftaran yang tersedia.
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
