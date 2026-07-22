@extends('layout.asesi')

@section('judul')
    FR.AK.01 | ASESI {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h4>FR.AK.01 - Pernyataan Kesediaan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom" style="background-color: var(--secondary-color);">
                <li style="color: #fff" class="breadcrumb-item"><a style="color: #fff" href="{{ route('dashasesi.index') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">FR.AK.01</li>
            </ol>
        </nav>
    </div><br>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Daftar Pendaftaran</h4>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive table-striped">
                        <div id="order-listing_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="order-listing" class="table dataTable no-footer" role="grid">
                                         <thead>
                                             <tr role="row" style="background-color: var(--secondary-color); color: #fff;">
                                                 <th class="sorting" style="width: 10px;">#</th>
                                                 <th class="sorting" style="width: 80px;">Aksi</th>
                                                 <th class="sorting" style="width: 150px;">Kode Registrasi</th>
                                                 <th class="sorting" style="width: 300px;">Skema Sertifikasi</th>
                                                 <th class="sorting" style="width: 150px;">Status Pendaftaran</th>
                                                 <th class="sorting" style="width: 150px;">Status FR.AK.01</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @forelse ($registrations as $reg)
                                                 @php
                                                     $frAk01 = \App\Models\FrAk01::where('data_register_id', $reg->id)->first();
                                                 @endphp
                                                 <tr role="row" class="odd">
                                                     <td class="font-weight-bold">{{ $loop->iteration }}</td>
                                                     <td class="text-right">
                                                         <a href="{{ route('frak01.create', $reg->id) }}" class="btn btn-dark btn-sm font-weight-bold">
                                                             Isi
                                                         </a>
                                                     </td>
                                                     <td class="font-weight-bold">{{ sprintf('%04d', $reg->id) }}</td>
                                                     <td class="font-weight-bold">{{ $reg->skema_name ?? '-' }}</td>
                                                     <td class="font-weight-bold"><span class="badge badge-info">{{ $reg->status }}</span></td>
                                                     <td class="font-weight-bold">
                                                         @if ($frAk01)
                                                             <span class="badge badge-success">Ditandatangani</span>
                                                         @else
                                                             <span class="badge badge-warning">Belum</span>
                                                         @endif
                                                     </td>
                                                 </tr>
                                             @empty
                                                 <tr role="row">
                                                     <td colspan="6" class="text-center py-4 text-muted">
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
