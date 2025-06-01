@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Navigation -->
    <nav class="nav-container">
        <div class="logo">
            @auth
                <a href="{{ route('dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
            @else
                <a href="/">TUNTAS<span class="logo-in">IN</span></a>
            @endauth
        </div>
        
        <!-- Search Section -->
        <div class="search-section">
            <form action="{{ route('dashboard') }}" method="GET">
                <select name="category" class="category-select" onchange="this.form.submit()">
                    <option value="">-- Semua Kategori --</option>
                    <option value="Kebersihan" {{ request('dasoard') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                    <option value="Perbaikan" {{ request('category') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                    <option value="Rumah Tangga" {{ request('category') == 'Rumah Tangga' ? 'selected' : '' }}>Rumah Tangga</option>
                    <option value="Teknologi" {{ request('category') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                    <option value="Transformasi" {{ request('category') == 'Transformasi' ? 'selected' : '' }}>Transformasi</option>
                </select>
            </form>
        </div>

        @if(Auth::user()->role === 'Pengguna Jasa')
            <div class="tooltip-container" style="margin-right: 12px;">
                <a href="{{ route('forum') }}" class="nav-icon-btn">
                    <i class="fas fa-users"></i>
                </a>
                <span class="tooltip-text">Forum</span>
            </div>
            <div class="tooltip-container">
                <a href="{{ route('wishlist') }}" class="nav-icon-btn">
                    <i class="fas fa-heart"></i>
                </a>
                <span class="tooltip-text">Wishlist</span>
            </div>
        @endif
        
        <div class="user-profile">
            <div class="user-info">
                <div class="profile-image">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile">
                    @else
                        <div class="profile-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                <button class="dropdown-toggle"> ⌵ </button>
            </div>
            <div class="dropdown-menu">
                <a href="{{ route('profile') }}" class="menu-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>

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

    <div class="container py-4">
        <a href="{{ route('dashboard') }}" class="btn-back">
            <i class="fas fa-chevron-left"></i> Kembali ke Dashboard
        </a>

        <h1 class="service-title">{{ $jasa->nama_jasa }}</h1>

        <div class="detail-container">
            <!-- Gambar Jasa -->
            <div class="image-section">
                <div class="service-category">{{ $jasa->kategori }}</div>
                <img src="{{ asset('storage/' . $jasa->gambar) }}" alt="{{ $jasa->nama_jasa }}" class="service-image">
            </div>

            <!-- Detail Informasi -->
            <div class="info-section">
                @php
                    // Modified photo path handling
                    $fotoPenyedia = optional($jasa->penyedia)->foto;
                    $namaPenyedia = optional($jasa->penyedia)->nama ?? 'Nama Penyedia';
                    
                    // Check if photo exists in storage
                    $photoExists = $fotoPenyedia && Storage::disk('public')->exists($fotoPenyedia);
                @endphp

                <div class="provider-info">
                    @if($photoExists)
                        <img src="{{ asset('storage/' . $fotoPenyedia) }}" alt="Foto Penyedia">
                    @else
                        <div class="provider-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <div class="provider-details">
                        <h3>{{ $namaPenyedia }}</h3>
                        <span class="badge">
                            <i class="fas fa-award"></i> Top Rated Seller
                        </span>
                        <div class="rating-section">
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star"></i></span>
                            <span class="star"><i class="fas fa-star-half-alt"></i></span>
                            <span class="rating-number">4.8</span>
                            <span class="review-count">(124 ulasan)</span>
                        </div>
                    </div>
                </div>

                <div class="description-box">
                    <h3>Deskripsi Layanan</h3>
                    <p class="service-description">{{ $jasa->deskripsi }}</p>
                </div>

                <div class="card-box">
                    <h3 class="package-title">STANNBAAAYY NEEHHHHH.....</h3>
                    <div class="package-price">
                        <span class="price-currency">Rp</span>
                        {{ number_format($jasa->minimal_harga, 0, ',', '.') }}
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('pesanan.create', $jasa->id) }}" class="btn-custom btn-primary-custom">
                            <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                        </a>
                        <a href="{{ route('chat.show', $jasa->id) }}" class="btn-custom btn-secondary-custom">
                            <i class="fas fa-comments"></i> Curhat YUKKSSS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/services.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jasaDetail.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dropdown menu toggle
        const userProfile = document.querySelector('.user-profile');
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        
        if (dropdownToggle) {
            dropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const dropdownMenu = userProfile.querySelector('.dropdown-menu');
                dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                const dropdownMenu = userProfile.querySelector('.dropdown-menu');
                if (dropdownMenu) {
                    dropdownMenu.style.display = 'none';
                }
            });
        }
        
        // Image hover animation effect
        const serviceImage = document.querySelector('.service-image');
        if (serviceImage) {
            serviceImage.addEventListener('mouseover', function() {
                this.style.transform = 'scale(1.02)';
            });
            
            serviceImage.addEventListener('mouseout', function() {
                this.style.transform = 'scale(1)';
            });
        }
    });
</script>
@endpush