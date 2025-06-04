@extends('layouts.app')

@section('content')
<!-- Navbar -->
<nav class="nav-container">
    <div class="logo">
        @auth
            <a href="{{ route('dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
        @else
            <a href="/">TUNTAS<span class="logo-in">IN</span></a>
        @endauth
    </div>
    
    <!-- User Menu -->
    <div class="user-profile">
        <div class="user-info">
            <div class="profile-image">
                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile">
                @else
                    <div class="profile-placeholder"></div>
                @endif
            </div>
            <button class="dropdown-toggle"></button>
        </div>
        <div class="dropdown-menu">
            <a href="{{ route('profile') }}" class="menu-item">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
            
            @if(Auth::user()->role === 'Penyedia Jasa')
                <a href="{{ route('account.balance') }}" class="menu-item">
                    <i class="fas fa-wallet"></i>
                    <span>My Balance</span>
                </a>
                <a href="{{ route('sales.history') }}" class="menu-item">
                    <i class="fas fa-history"></i>
                    <span>Riwayat Penjualan</span>
                </a>
            @else
                <a href="{{ route('purchases.history') }}" class="menu-item">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Riwayat Pembelian</span>
                </a>
            @endif
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container py-5">
    <!-- Tombol Kembali yang Baru -->
    <div class="mb-5">
        <a href="{{ route('dashboard') }}" class="back-button">
            <span class="back-button-circle">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="back-button-text">Kembali ke Dashboard</span>
        </a>
    </div>

    <div class="row gx-5">
        <!-- Bagian Kiri - Gambar dan Deskripsi -->
        <div class="col-lg-7 mb-4">
            <h1 class="service-title mb-4">{{ $jasa->nama_jasa }}</h1>
            
            <!-- Gambar Jasa -->
            <div class="image-section mb-4">
                <img src="{{ asset('storage/' . $jasa->gambar) }}" 
                     alt="{{ $jasa->nama_jasa }}" 
                     class="service-image">
            </div>
            
            <!-- Deskripsi Jasa -->
            <div class="description-box bg-white p-4 rounded-lg shadow-sm">
                <h4 class="mb-3 fw-bold">Deskripsi Layanan</h4>
                <p class="text-muted lh-lg">{{ $jasa->deskripsi }}</p>
                <div class="mt-4 pt-3 border-top">
                    <p class="mb-2"><strong>Harga Mulai Dari:</strong></p>
                    <h5 class="text-primary">Rp {{ number_format($jasa->minimal_harga, 0, ',', '.') }}</h5>
                </div>
            </div>

            <!-- Ulasan Pengguna -->
            <div class="reviews-section mt-4">
                <h4 class="fw-bold mb-4">Ulasan Pengguna</h4>
                
                @if($jasa->reviewratings->count() > 0)
                    <!-- Rating Summary -->
                    <div class="rating-summary p-4 bg-light rounded-lg mb-4">
                        <div class="d-flex align-items-center">
                            <div class="rating-average text-center">
                                <span class="display-4 fw-bold text-primary">
                                    {{ number_format($jasa->averageRating, 1) }}
                                </span>
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $jasa->averageRating)
                                            <i class="fas fa-star text-warning"></i>
                                        @elseif($i - 0.5 <= $jasa->averageRating)
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-muted mb-0">{{ $jasa->reviewratings->count() }} ulasan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Review Cards -->
                    <div class="reviews-list">
                        @foreach($jasa->reviewratings as $review)
                            <div class="review-card bg-white p-4 rounded-lg shadow-sm mb-4">
                                <div class="review-header d-flex align-items-center mb-3">
                                    <div class="reviewer-info d-flex align-items-center">
                                        <!-- User Avatar -->
                                        <div class="reviewer-avatar me-3">
                                            @if($review->user->photo)
                                                <img src="{{ asset('storage/' . $review->user->photo) }}" 
                                                     alt="User Avatar"
                                                     class="rounded-circle"
                                                     width="48"
                                                     height="48">
                                            @else
                                                <div class="avatar-placeholder">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- User Info & Rating -->
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $review->user->first_name }} {{ $review->user->last_name }}</h6>
                                            <div class="review-rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Review Date -->
                                    <small class="text-muted ms-auto">
                                        {{ $review->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                
                                <!-- Review Content -->
                                <div class="review-content">
                                    <p class="mb-0 text-dark">{{ $review->review }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 bg-light rounded">
                        <i class="fas fa-comment-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Belum ada ulasan untuk jasa ini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bagian Kanan - Form Pemesanan -->
        <div class="col-lg-5">
            <div class="card-box bg-white rounded-lg shadow p-4 sticky-top">
                <!-- Info Penyedia Jasa -->
                <div class="provider-info p-3 mb-4 bg-light rounded-lg">
                    <div class="d-flex align-items-center">
                        <div class="provider-avatar me-3">
                            @if($jasa->user->photo)
                                <img src="{{ asset('storage/' . $jasa->user->photo) }}" 
                                     alt="Foto Penyedia" 
                                     class="rounded-circle shadow-sm" 
                                     width="60">
                            @else
                                <i class="fas fa-user-circle fa-3x text-secondary"></i>
                            @endif
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">{{ $jasa->user->full_name }}</h5>
                            <span class="badge bg-success">Penyedia Jasa Terpercaya</span>
                        </div>
                    </div>
                </div>

                <!-- Form Pemesanan -->
                <form action="{{ route('pesanan.store', $jasa->id) }}" method="POST">
                    @csrf
                    
                    <!-- Input Harga -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Masukkan Penawaran Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" 
                                   name="custom_price" 
                                   class="form-control @error('custom_price') is-invalid @enderror" 
                                   value="{{ old('custom_price') }}"
                                   placeholder="Masukkan harga penawaran Anda"
                                   required>
                        </div>
                        @error('custom_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Berikan harga terbaik Anda!</small>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tanggal Mulai Pengerjaan</label>
                        <input type="date" 
                               name="tanggal_mulai" 
                               class="form-control @error('tanggal_mulai') is-invalid @enderror"
                               min="{{ date('Y-m-d') }}" 
                               value="{{ old('tanggal_mulai') }}"
                               required>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Catatan Tambahan</label>
                        <textarea name="catatan" 
                                 class="form-control @error('catatan') is-invalid @enderror" 
                                 rows="4" 
                                 placeholder="Deskripsikan kebutuhan Anda secara detail...">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Button Group -->
                    <div class="button-group mt-4">
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 py-3 mb-2">
                            <i class="fas fa-arrow-right me-2"></i>
                            Lanjutkan
                        </button>

                        <!-- Chat Button -->
                        <a href="{{ route('chat.show', $jasa->id) }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-comments me-2"></i>
                            Chat dengan Penyedia Jasa
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('css/services.css') }}" rel="stylesheet">
<link href="{{ asset('css/pesanan.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script>
    function updatePriceQty(qty) {
        let quantity = parseInt(qty);
        if (isNaN(quantity) || quantity < 1) quantity = 1;
        const pricePerItem = {{ $jasa->harga }};
        const total = pricePerItem * quantity;
        document.getElementById('hidden_price').value = total;
        document.getElementById('quantity').value = quantity;
        document.getElementById('continue-btn').innerText = `Pembayaran (Rp ${new Intl.NumberFormat('id-ID').format(total)})`;
    }
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInput = document.getElementById('quantity');
        qtyInput.addEventListener('input', function() {
            updatePriceQty(this.value);
        });
    });
</script>
@endpush
@endsection