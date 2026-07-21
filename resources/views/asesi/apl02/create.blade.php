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
        <a href="{{ route('apl02.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm rounded mb-4">
        <div class="card-header" style="background-color: var(--primary-color); color: #fff;">
            <span><i class="fas fa-tag"></i> Skema: {{ $skema->kode_skema }} — {{ $skema->skema }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('apl02.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="data_register_id" value="{{ $registration->id }}">

                @if ($unikoms->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <p>Tidak ada unit kompetensi untuk skema ini.</p>
                    </div>
                @else
                    @foreach ($unikoms as $unit)
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3" style="color: var(--primary-color);">
                                <i class="fas fa-book"></i> {{ $unit->kode_unikom }} — {{ $unit->unikom }}
                            </h5>

                            @if ($unit->asesmens->isEmpty())
                                <p class="text-muted small">Belum ada elemen untuk unit ini.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 40px">#</th>
                                                <th style="width: 250px">Elemen</th>
                                                <th>Kriteria Unjuk Kerja</th>
                                                <th style="width: 160px">Status</th>
                                                <th style="width: 220px">Upload Bukti</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($unit->asesmens as $elemen)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $elemen->asesmen }}</td>
                                                    <td><small>{!! $elemen->kriteria !!}</small></td>
                                                    <td>
                                                        <select name="status[{{ $loop->parent->iteration * 100 + $loop->iteration }}]" class="form-control form-control-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="kompeten">Kompeten</option>
                                                            <option value="tidak_kompeten">Tidak Kompeten</option>
                                                        </select>
                                                        <input type="hidden" name="elemen_id[{{ $loop->parent->iteration * 100 + $loop->iteration }}]" value="{{ $elemen->id }}">
                                                    </td>
                                                    <td>
                                                        <input type="file" name="image[{{ $loop->parent->iteration * 100 + $loop->iteration }}]" class="form-control-file" accept=".pdf,.png,.jpg,.jpeg">
                                                        <small class="text-muted">PDF, PNG, JPG (max 2MB)</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <hr>
                    <div class="text-right">
                        <button type="submit" class="btn" style="background-color: var(--primary-color); color: #fff;">
                            <i class="fas fa-save"></i> Simpan Asesmen Mandiri
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
