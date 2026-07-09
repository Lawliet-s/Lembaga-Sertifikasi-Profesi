@extends('layout.client')
@section('judul')
    Jadwal Asesmen | LSP
@endsection

@section('layanan')
    active
@endsection

@section('isi')
    <div style="background-image: url('{{ asset($site_setting->header_image ?? 'general/assets/images/head1.jpg') }}')" class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-calendar-alt"></i> Jadwal Asesmen</h1>
                    <span>{{ $site_setting->title ?? 'Lembaga Sertifikasi Profesi' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="more-info about-info">
        <div class="container">
            <div class="section-heading">
                <h2>Jadwal Asesmen</h2>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <select id="filter-skema" class="form-control">
                        <option value="">Semua Skema</option>
                        @foreach ($skema as $item)
                            <option value="{{ $item->id }}">{{ $item->skema }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="filter-tuk" class="form-control">
                        <option value="">Semua Lokasi</option>
                        @foreach ($tuk as $item)
                            <option value="{{ $item->id }}">{{ $item->tuk }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button id="filter-btn" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Filter</button>
                </div>
            </div>

            <div id="jadwal-list" class="row">
                @forelse ($jadwal as $item)
                    <div class="col-md-6 mb-3 jadwal-item" data-skema="{{ $item->skema_id }}" data-tuk="{{ $item->tuk_id }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $item->skema->skema ?? '-' }}</h5>
                                <p class="card-text">
                                    <strong><i class="fas fa-map-marker-alt"></i> Lokasi:</strong> {{ $item->tuk->tuk ?? '-' }}<br>
                                    <strong><i class="fas fa-calendar-day"></i> Tanggal:</strong> {{ optional($item->tanggal)->format('d/m/Y') }}<br>
                                    <strong><i class="fas fa-clock"></i> Jam:</strong> {{ $item->jam ?? '-' }}
                                </p>
                                @if ($item->deskripsi)
                                    <p class="card-text"><small class="text-muted">{{ $item->deskripsi }}</small></p>
                                @endif
                                @auth
                                    <a href="{{ Auth::user()->hasRole('asesi') ? route('dashasesi.index') : route('login') }}" class="btn btn-success">
                                        <i class="fas fa-user-plus"></i> Daftar
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-success">
                                        <i class="fas fa-user-plus"></i> Daftar
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">Belum ada jadwal asesmen tersedia.</h4>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <br><br>

    <script>
        document.getElementById('filter-btn').addEventListener('click', function() {
            var skema = document.getElementById('filter-skema').value;
            var tuk = document.getElementById('filter-tuk').value;
            var items = document.querySelectorAll('.jadwal-item');
            items.forEach(function(item) {
                var matchSkema = !skema || item.dataset.skema === skema;
                var matchTuk = !tuk || item.dataset.tuk === tuk;
                item.style.display = (matchSkema && matchTuk) ? '' : 'none';
            });
        });
    </script>
@endsection
