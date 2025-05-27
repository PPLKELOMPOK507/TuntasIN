@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Navigation -->
    <nav class="nav-container">
        <div class="logo">
            <a href="{{ Auth::check() ? route('dashboard') : '/' }}">TUNTAS<span class="logo-in">IN</span></a>
        </div>
        
        <!-- Search Section -->
        <div class="search-section">
            <form action="{{ route('dashboard') }}" method="GET">
                <select name="category" class="category-select" onchange="this.form.submit()">
                    <option value="">-- Semua Kategori --</option>
                    @foreach(['Kebersihan', 'Perbaikan', 'Rumah Tangga', 'Teknologi', 'Transformasi'] as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        @if(Auth::user()->role === 'Pengguna Jasa')
            <div class="tooltip-container" style="margin-right: 12px;">
                <a href="{{ route('forum') }}" class="forum-btn"><i class="fas fa-users"></i></a>
                <span class="tooltip-text">Forum</span>
            </div>
            <div class="tooltip-container">
                <a href="{{ route('wishlist') }}" class="wishlist-btn">❤</a>
                <span class="tooltip-text">Wishlist</span>
            </div>
        @endif
        
        <!-- User Profile -->
        <div class="user-profile">
            <div class="user-info">
                <div class="profile-image">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile">
                    @else
                        <div class="profile-placeholder"></div>
                    @endif
                </div>
                <button class="dropdown-toggle"> ⌵ </button>
            </div>
            <div class="dropdown-menu">
                <a href="{{ route('profile') }}" class="menu-item">
                    <i class="fas fa-user"></i> <span>Profile</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="container py-3">
        <div class="row">
            <!-- Kolom gambar jasa -->
            <div class="col-md-7">
                <h1 class="service-title">{{ $jasa->nama_jasa }}</h1>
                <div class="service-image-container">
                    <!-- <img src="{{ $jasa->gambar ?? asset('images/default-service.jpg') }}" 
                         class="service-image" alt="{{ $jasa->nama_jasa }}"> -->
                </div>

                <!-- Deskripsi layanan -->
                <div class="service-description mb-4">
                    <!-- Provider info with photo -->
                    <div class="provider-info d-flex align-items-center mb-3">
                        <div class="provider-avatar">
                            @if($jasa->penyedia && $jasa->penyedia->photo)
                                <img src="{{ asset('storage/' . $jasa->penyedia->photo) }}" alt="Provider">
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                        </div>
                        <div class="provider-details">
                            <h5 class="mb-0">{{ $jasa->user->full_name ?? 'Nama Penyedia' }}</h5>
                            <p class="text-muted mb-0">Top Rated Seller</p>
                        </div>
                    </div>

                    <h4>Deskripsi Layanan</h4>
                    <p>{{ $jasa->deskripsi }}</p>
                </div>
            </div>

            <!-- Kolom form pemesanan (YANG DISEDERHANAKAN) -->
            <div class="col-md-5">
                <div class="booking-form-container">
                    <form action="{{ route('pesanan.store', $jasa->id) }}" method="POST" class="booking-form">
                        @csrf
                        <input type="hidden" id="hidden_price" name="price" value="{{ $jasa->harga }}">
                        
                        <!-- Package Selection -->
                        <div class="form-group mb-3">
                            <div class="package-option selected">
                                <div class="package-details w-100">
                                    <h5 class="mb-2">Masukan Harga Kesepakatan</h5>
                                    <div class="price-input-group">
                                        <span class="currency">Rp</span>
                                        <input type="number" name="custom_price" id="custom_price" class="form-control" 
                                               value="{{ $jasa->harga }}" min="{{ $jasa->harga }}"
                                               oninput="updatePrice(this.value)">
                                        <small class="text-muted d-block mt-1">Minimal: Rp {{ number_format($jasa->harga, 0, ',', '.') }}</small>
                                    </div>
                                </div>
                                <input type="radio" name="package" value="basic" checked hidden>
                            </div>
                        </div>
                        
                        <!-- Date Selection -->
                        <div class="form-group mb-3">
                            <label for="tanggal_mulai" class="mb-2">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                        </div>
                        
                        <!-- Notes -->
                        <div class="form-group mb-4">
                            <label for="catatan" class="mb-2">Catatan Tambahan</label>
                            <textarea name="catatan" id="catatan" class="form-control" rows="3" 
                                    placeholder="Berikan detail tentang kebutuhan Anda"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="order-total mt-4">
                            <button type="submit" class="continue-btn" id="continue-btn">
                                Continue (Rp {{ number_format($jasa->harga, 0, ',', '.') }})
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('css/services.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    /* Essential styles */
    .service-title {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        color: #333;
        text-decoration: none;
        margin-bottom: 15px;
    }
    .order-options-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    .order-options-container {
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }
    .booking-form-container {
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        padding: 20px;
    }
    .service-image-container {
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .service-image { width: 100%; height: auto; }
    .provider-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f0f0;
    }
    .provider-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .package-option, .extras-option {
        display: flex;
        justify-content: space-between;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        margin-bottom: 15px;
    }
    .package-option.selected {
        border-color: #75C5F0;
        background-color: rgba(29, 191, 115, 0.05);
    }
    .price-input-group {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }
    .price-input-group .currency {
        margin-right: 5px;
        font-weight: bold;
    }
    .price-input-group small {
        width: 100%;
        margin-top: 5px;
    }
    .price-input-group input {
        max-width: 150px;
    }
    .continue-btn {
        width: 100%;
        padding: 12px;
        background: #75C5F0;
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts') 
<script>
    // Update price when custom price changes
    function updatePrice(value) {
        let basePrice = parseInt(value);
        if (isNaN(basePrice)) basePrice = {{ $jasa->harga }};
        
        const minPrice = {{ $jasa->harga }};
        if (basePrice < minPrice) {
            basePrice = minPrice;
            document.getElementById('custom_price').value = minPrice;
        }
        
        document.getElementById('hidden_price').value = basePrice;
        document.getElementById('continue-btn').innerText = `Continue (Rp ${new Intl.NumberFormat('id-ID').format(basePrice)})`;
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const customPriceInput = document.getElementById('custom_price');
        customPriceInput.addEventListener('input', function() {
            updatePrice(this.value);
        });
    });

    // Toggle dropdown menu
    document.querySelector('.dropdown-toggle').addEventListener('click', function() {
        document.querySelector('.dropdown-menu').classList.toggle('show');
    });

    // Close dropdown when clicking outside
    window.addEventListener('click', function(e) {
        if (!e.target.matches('.dropdown-toggle')) {
            const dropdown = document.querySelector('.dropdown-menu');
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        }
    });
</script>
@endpush