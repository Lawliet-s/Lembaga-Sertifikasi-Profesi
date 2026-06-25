@extends('layout.asesi')

@section('sidebar')
    sidebar-mini
@endsection

@section('judul')
    FR.AK.04 - Banding Asesmen - {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('isi')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4><i class="fas fa-gavel"></i> FR.AK.04 — Banding Asesmen</h4>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><i class="fas fa-table"></i> Daftar Sertifikasi</h4>
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
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 10px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 80px;">Aksi</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 200px;">Skema</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 100px;">Kode Reg</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 100px;">Hasil</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 100px;">Status Banding</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($registrations as $item)
                                                @php $frAk04 = $item->frAk04; @endphp
                                                <tr role="row" class="odd">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-right">
                                                        @if ($frAk04)
                                                            <a href="{{ route('frak04.show', $item->id) }}" class="btn btn-primary btn-sm" title="Detail Banding">
                                                                <i class="fas fa-eye"></i> Detail
                                                            </a>
                                                        @else
                                                            <a href="{{ route('frak04.show', $item->id) }}" class="btn btn-warning btn-sm" title="Ajukan Banding">
                                                                <i class="fas fa-gavel"></i> Ajukan
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td class="font-weight-bold">{{ $item->skema_name }}</td>
                                                    <td><code>#{{ $item->id }}</code></td>
                                                    <td>{{ $item->status }}</td>
                                                    <td>
                                                        @if ($frAk04)
                                                            @switch($frAk04->status)
                                                                @case('diajukan')
                                                                    <span class="badge" style="background-color: #17a2b8; color: #fff;">
                                                                        <i class="fas fa-clock"></i> Diajukan
                                                                    </span>
                                                                    @break
                                                                @case('ditinjau')
                                                                    <span class="badge" style="background-color: #ffc107; color: #000;">
                                                                        <i class="fas fa-search"></i> Ditinjau
                                                                    </span>
                                                                    @break
                                                                @case('diterima')
                                                                    <span class="badge" style="background-color: #28a745; color: #fff;">
                                                                        <i class="fas fa-check"></i> Diterima
                                                                    </span>
                                                                    @break
                                                                @case('ditolak')
                                                                    <span class="badge" style="background-color: #dc3545; color: #fff;">
                                                                        <i class="fas fa-times"></i> Ditolak
                                                                    </span>
                                                                    @break
                                                            @endswitch
                                                        @else
                                                            <span class="badge" style="background-color: #6c757d; color: #fff;">
                                                                Belum ada banding
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr role="row">
                                                    <td colspan="6" class="text-center py-4 text-muted">
                                                        <i class="fas fa-balance-scale fa-2x mb-2"></i><br>
                                                        Belum ada sertifikasi yang dapat dibanding.<br>
                                                        <small>FR.AK.04 tersedia setelah sertifikasi selesai atau jika hasilnya Belum Kompeten.</small>
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
</div>
@endsection
