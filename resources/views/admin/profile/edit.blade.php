@extends('layout.admin')

@section('judul')
    Profil Saya | {{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}
@endsection

@section('sidebar')
    sidebar-icon-only
@endsection

@section('isi')
    @include('layout/verifikasi')
    <div class="page-header">
        <h4>
            <i class="fas fa-user-circle"></i> Profil Saya
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom" style="background-color: var(--secondary-color);">
                <li style="color: #fff" class="breadcrumb-item"><a style="color: #fff" href="{{ route('admin') }}">Dashboard</a></li>
                <li style="color: #fff" class="breadcrumb-item active" aria-current="page">Profil Saya</li>
            </ol>
        </nav>
    </div><br>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title"><i class="fas fa-camera"></i> Photo Profil</h4>
                    <hr>
                    @if (Auth::user()->image)
                        <img src="{{ asset(Auth::user()->image) }}" class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Photo Profil">
                    @else
                        <img src="{{ asset('general/assets/images/photo.jpg') }}" class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Photo Profil">
                    @endif
                    <p class="text-muted">Foto profil Anda</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-edit"></i> Edit Profil</h4>
                    <hr>
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="form-sample">
                        @csrf
                        @method('put')

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <input type="text" maxlength="100" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" maxlength="255" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password Baru</label>
                            <div class="col-sm-9">
                                <input type="password" maxlength="100" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Konfirmasi Password</label>
                            <div class="col-sm-9">
                                <input type="password" maxlength="100" class="form-control" name="password_confirmation" placeholder="Ketik ulang password baru">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Photo Profil</label>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror" name="image" id="image" accept=".jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="image">Pilih file PNG atau JPG</label>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">Format: PNG/JPG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</small>
                            </div>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-success btn-rounded btn-block">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file PNG atau JPG';
        e.target.nextElementSibling.textContent = fileName;
    });
</script>
@endpush
