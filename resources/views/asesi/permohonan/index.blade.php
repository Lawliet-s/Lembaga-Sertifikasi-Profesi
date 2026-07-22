@extends('layout.asesi')

@section('sidebar')
    sidebar-mini
@endsection

@section('judul')
    Permohonan Sertifikasi - {{ $site_setting->title ?? 'LSP' }}
@endsection

@section('isi')
<div class="container-fluid">
    <div class="page-header">
        <h4><i class="fas fa-file-alt"></i> Permohonan Sertifikasi Kompetensi</h4>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0"><i class="fas fa-table"></i> Daftar Permohonan</h4>
                @if ($permohonans->whereIn('status', ['pending', 'revisi'])->count() < 3)
                    <a href="{{ route('permohonan.create') }}" class="btn btn-sm" style="background-color: var(--primary-color); color: #fff;">
                        <i class="fas fa-plus"></i> Ajukan Baru
                    </a>
                @endif
            </div>
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
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 70px;">Kode Registrasi</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 80px;">Aksi</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 280px;">Skema</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 100px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" style="width: 100px;">Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($permohonans as $item)
                                                <tr role="row" class="odd">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="font-weight-bold">{{ sprintf('%04d', $item->data_register_id) }}</td>
                                                    <td class="text-right">
                                                        <div class="btn-group" role="group">
                                                            @if (in_array($item->status, ['diverifikasi', 'selesai']))
                                                                <a href="{{ route('permohonan.frapl01.show', $item->id) }}" class="btn btn-sm btn-primary" title="Lihat FR.APL.01">
                                                                    <i class="fas fa-file-alt"></i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('permohonan.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            @endif
                                                            @if (in_array($item->status, ['pending', 'revisi']))
                                                                <a href="{{ route('permohonan.edit', $item->id) }}" class="btn btn-sm btn-success" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                            @if ($item->status === 'pending')
                                                                <form method="POST" action="{{ route('permohonan.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan permohonan ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger" title="Batalkan">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="font-weight-bold">{{ $item->skema->skema ?? '-' }}</td>
                                                    <td>
                                                        @php
                                                            $badge = match($item->status) {
                                                                'pending' => 'warning',
                                                                'diverifikasi' => 'info',
                                                                'revisi' => 'danger',
                                                                'ditolak' => 'dark',
                                                                'selesai' => 'success',
                                                                default => 'secondary'
                                                            };
                                                        @endphp
                                                        <span class="badge badge-{{ $badge }}">
                                                            {{ ucfirst($item->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $item->created_at->format('d M Y') }}</td>
                                                </tr>
                                            @empty
                                                <tr role="row">
                                                    <td colspan="6" class="text-center py-4 text-muted">
                                                        <i class="fas fa-file-alt fa-2x mb-2"></i><br>
                                                        Belum ada permohonan sertifikasi.<br>
                                                        <small>Ajukan permohonan baru untuk memulai proses sertifikasi.</small>
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
