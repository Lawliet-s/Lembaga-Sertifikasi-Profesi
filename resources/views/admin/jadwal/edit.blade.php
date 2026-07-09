@extends('layout.admin')

@section('judul')
    Edit Jadwal Asesmen | Admin LSP
@endsection

@section('sidebar')
    sidebar-icon-only
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h3>
            <i class="fas fa-edit"></i> Edit Jadwal Asesmen
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom bg-danger">
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('jadwal.index') }}">Jadwal Asesmen</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div><br>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Skema Sertifikasi</label>
                    <select name="skema_id" class="form-control @error('skema_id') is-invalid @enderror" required>
                        <option value="">Pilih Skema</option>
                        @foreach ($skema as $item)
                            <option value="{{ $item->id }}" {{ old('skema_id', $jadwal->skema_id) == $item->id ? 'selected' : '' }}>{{ $item->skema }}</option>
                        @endforeach
                    </select>
                    @error('skema_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-primary">TUK / Lokasi Uji</label>
                    <select name="tuk_id" class="form-control @error('tuk_id') is-invalid @enderror" required>
                        <option value="">Pilih TUK</option>
                        @foreach ($tuk as $item)
                            <option value="{{ $item->id }}" {{ old('tuk_id', $jadwal->tuk_id) == $item->id ? 'selected' : '' }}>{{ $item->tuk }}</option>
                        @endforeach
                    </select>
                    @error('tuk_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $jadwal->tanggal ? $jadwal->tanggal->format('Y-m-d') : '') }}" required>
                    @error('tanggal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Jam</label>
                    <input type="time" name="jam" class="form-control @error('jam') is-invalid @enderror" value="{{ old('jam', $jadwal->jam) }}">
                    @error('jam')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3" placeholder="Keterangan tambahan">{{ old('deskripsi', $jadwal->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-primary">Status</label>
                    <select name="status" class="form-control">
                        <option value="aktif" {{ old('status', $jadwal->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="ditutup" {{ old('status', $jadwal->status) == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-rounded btn-info btn-icon-text">
                    <i class="fas fa-save btn-icon-prepend"></i> Update
                </button>
                <a href="{{ route('jadwal.index') }}" class="btn btn-rounded btn-secondary btn-icon-text">
                    <i class="fas fa-times btn-icon-prepend"></i> Batal
                </a>
            </form>
        </div>
    </div>
@endsection
