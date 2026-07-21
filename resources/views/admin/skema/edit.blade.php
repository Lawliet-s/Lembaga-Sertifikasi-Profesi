@extends('layout/admin')

@section('judul')
    {{ $skema->skema }} | Admin LSP
@endsection

@section('sidebar')
    sidebar-mini
@endsection

@section('isi')
@include('layout/verifikasi')
{{-- <---------------------- PAGE HEADER ----------------------> --}}
<div class="page-header">
    <h4>
        <i class="fab fa-pagelines"></i>  Edit Skema
    </h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-custom  bg-danger">
            <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
            <li style="color: var(--secondary-color)" class="breadcrumb-item"><a href="{{ route('skema.index') }}">Skema/Kluster</a></li>
            <li style="color: #eadcdc" class="breadcrumb-item active" aria-current="page">{{ $skema->id }}</li>
        </ol>
    </nav>
</div><br>


{{-- <----------------------EDIT SKEMA ----------------------> --}}
<div class="card">
    <div class="card-body">
        <h4 class="card-title"><i class="fas fa-suitcase"></i> {{ $skema->skema }}</h4>
        <form action="{{ route('skema.update', $skema->id) }}" method="POST" class="form-sample">
        @csrf
        @method('put')
            <div class="card-description text-left">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Skema</label>
                        <div class="col-sm-9">
                        <input type="text" maxlength="100" name="skema" class="form-control" value="{{ $skema->skema }}" />
                            @error('skema')
                                <div class="text-danger mt-2 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kode Skema</label>
                        <div class="col-sm-9">
                            <input type="text" name="kode_skema" class="form-control" maxlength="100" value="{{ $skema->kode_skema }}"/>
                            @error('kode_skema')
                                <div class="text-danger mt-2 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jurusan</label>
                        <div class="col-sm-9">
                            <select class="form-control select2-search" name="jurusan_id" id="jurusan_id">
                                <option value="" holder></option>
                                @foreach ($jurusan as $result)
                                <option value="{{ $result->id }}"
                                    @if ($skema->jurusan_id == $result->id)
                                        selected
                                    @endif>{{ $result->jurusan }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Penanggung Jawab</label>
                        <div class="col-sm-9">
                            <select class="form-control select2-search" name="asesor_id" id="asesor_id">
                                <option value="" holder></option>
                                @foreach ($asesor as $result)
                                    <option value="{{ $result->id }}"
                                    @if ($skema->asesor_id == $result->id)
                                        selected
                                    @endif>{{ $result->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">TUK</label>
                        <div class="col-sm-9">
                            <select class="form-control select2-search" name="tuk_id" id="tuk_id">
                                <option value="" holder></option>
                                @foreach ($tuk as $result)
                                    <option value="{{ $result->id }}"
                                    @if ($skema->tuk_id == $result->id)
                                        selected
                                    @endif>{{ $result->tuk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control select2-search" name="status_id" id="status_id">
                                <option value="" holder>Pilih Status</option>
                                <option value="Aktif" @if ($skema->status_id == 'Aktif') selected @endif>Aktif</option>
                                <option value="Nonaktif" @if ($skema->status_id == 'Nonaktif') selected @endif>Nonaktif</option>
                            </select>
                            @error('status_id')
                                <div class="text-danger mt-2 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-rounded btn-info btn-icon-text btn-block">
                <i class="fa fa-magic btn-icon-prepend"></i>
                Update
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(function() {
    $('.select2-search').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih...',
        allowClear: true,
        width: '100%'
    });
});
</script>
@endpush
@endsection
