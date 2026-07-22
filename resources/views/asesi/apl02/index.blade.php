@extends('layout.asesi')

@section('sidebar')
    sidebar-mini
@endsection

@section('judul')
    FR.APL.02 - Asesmen Mandiri - {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('isi')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4><i class="fas fa-clipboard-check"></i> FR.APL.02 — Asesmen Mandiri</h4>
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
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 300px;">Skema</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 100px;">Kode Registrasi</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 100px;">Tanggal</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 100px;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($registrations as $item)
                                                @php
                                                    $hasXnxx = \App\Models\Xnxx::where('data_register_id', $item->id)
                                                        ->where('user_id', auth()->user()->id)
                                                        ->exists();
                                                @endphp
                                                <tr role="row" class="odd">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-right">
                                                        @if ($hasXnxx)
                                                            <a href="{{ route('apl02.show', $item->id) }}" class="btn btn-sm btn-primary" title="Lihat APL.02">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        @else
                                                            <a href="{{ route('apl02.create', $item->id) }}" class="btn btn-sm btn-success" title="Isi APL.02">
                                                                <i class="fas fa-edit"></i> Isi
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td class="font-weight-bold">{{ $item->skema_name }}</td>
                                                    <td><code>#{{ sprintf('%04d', $item->id) }}</code></td>
                                                    <td>{{ $item->created_at->format('d M Y') }}</td>
                                                    <td>@include('partials.status_badge', ['status' => $item->status])</td>
                                                </tr>
                                            @empty
                                                <tr role="row">
                                                    <td colspan="6" class="text-center py-4 text-muted">
                                                        <i class="fas fa-clipboard-list fa-2x mb-2"></i><br>
                                                        Belum ada sertifikasi yang divalidasi.<br>
                                                        <small>Anda dapat mengisi FR.APL.02 setelah pendaftaran sertifikasi Anda divalidasi.</small>
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
