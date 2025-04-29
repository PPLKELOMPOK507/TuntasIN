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
            <div class="search-container">
                <input type="search" class="search-input" placeholder="Cari layanan...">
                <button class="filter-btn">
                    <i class="fas fa-sliders-h"></i>
                </button>
            </div>
        </div>

        <!-- Wishlist Icon -->
        <div class="wishlist-icon">
            <a href="{{ route('wishlist.index') }}" title="Lihat Wishlist">
                <i class="fas fa-heart"></i>
                <span class="wishlist-count">
                    {{ auth()->check() ? auth()->user()->wishlists()->count() : 0 }}
                </span>
            </a>
        </div>

        <!-- User Menu -->
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
                <span class="user-name">{{ Auth::user()->full_name }}</span>
            </div>
            <div class="dropdown-menu">
                <a href="{{ route('profile') }}" class="menu-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                @if(Auth::user()->role === 'Penyedia Jasa')
                    <a href="{{ route('sales.history') }}" class="menu-item">
                        <i class="fas fa-history"></i>
                        <span>Riwayat Penjualan</span>
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

    <!-- Category Navigation -->
    <div class="category-nav">
        <div class="category-scroll">
            <a href="#" class="category-link active">Graphics & Design</a>
            <a href="#" class="category-link">Programming & Tech</a>
            <a href="#" class="category-link">Digital Marketing</a>
            <a href="#" class="category-link">Video & Animation</a>
            <a href="#" class="category-link">Writing & Translation</a>
            <a href="#" class="category-link">Music & Audio</a>
            <a href="#" class="category-link">Business</a>
        </div>
    </div>

    <div class="dashboard-main">
        <!-- Featured Section -->
        <section class="featured-section">
            <h2>Layanan Populer</h2>
            <div class="service-grid">
                @for ($i = 1; $i <= 8; $i++)
                <div class="service-card">
                    <div class="service-image">
                        <img src="{{ asset('images/Dashboard (2).png') }}" alt="Checklist Illustration" class="illustration">
                        <button class="favorite-btn" data-service-id="{{ $i }}">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    <div class="service-info">
                        <div class="service-provider">
                            <img src="https://via.placeholder.com/30x30" alt="Provider" class="provider-image">
                            <span class="provider-name">Service Provider {{$i}}</span>
                            <span class="provider-level">Level 2</span>
                        </div>
                        <h3 class="service-title">Saya akan melakukan sesuatu yang luar biasa untuk bisnis Anda</h3>
                        <div class="service-rating">
                            <span class="stars">⭐ 4.9</span>
                            <span class="rating-count">(153)</span>
                        </div>
                        <div class="service-price">
                            <span>Mulai dari</span>
                            <strong>Rp 250.000</strong>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </section>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Tambahan CSS untuk wishlist */
        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .favorite-btn i {
            color: #aaa;
            font-size: 18px;
            transition: all 0.3s ease;
        }
        
        .favorite-btn.active i {
            color: #ff3e66;
        }
        
        .favorite-btn:hover {
            background-color: #fff;
            transform: scale(1.1);
        }
        
        .favorite-btn:hover i {
            color: #ff3e66;
        }
        
        .favorite-btn.active {
            background-color: #fff;
        }
        
        .wishlist-icon {
            position: relative;
        }
        
        .wishlist-icon a {
            color: #333;
            font-size: 20px;
            position: relative;
            display: block;
            padding: 8px;
        }
        
        .wishlist-icon a:hover {
            color: #ff3e66;
        }
        
        .wishlist-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ff3e66;
            color: white;
            font-size: 12px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handler untuk tombol favorite
        const favoriteButtons = document.querySelectorAll('.favorite-btn');
        
        // Fungsi untuk mengecek status wishlist
        function checkWishlistStatus() {
            @if(Auth::check())
                fetch(`{{ route('wishlist.index') }}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(item => {
                            const button = document.querySelector(`.favorite-btn[data-service-id="${item.service_id}"]`);
                            if (button) {
                                button.classList.add('active');
                                button.innerHTML = '<i class="fas fa-heart"></i>';
                            }
                        });
                    });
            @endif
        }
        
        // Panggil fungsi saat halaman dimuat
        checkWishlistStatus();
        
        favoriteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Pastikan user sudah login
                @if(Auth::check())
                    const serviceId = this.getAttribute('data-service-id');
                    const button = this;
                    
                    // Tambahkan animasi loading
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    
                    fetch(`{{ route('wishlist.toggle') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            service_id: serviceId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update tampilan button dengan animasi
                            if (data.status === 'added') {
                                button.classList.add('active');
                                button.innerHTML = '<i class="fas fa-heart"></i>';
                                // Tambahkan animasi
                                button.style.transform = 'scale(1.2)';
                                setTimeout(() => {
                                    button.style.transform = 'scale(1)';
                                }, 300);
                                
                                // Update wishlist count
                                const wishlistCount = document.querySelector('.wishlist-count');
                                if (wishlistCount) {
                                    wishlistCount.textContent = parseInt(wishlistCount.textContent) + 1;
                                }
                            } else {
                                button.classList.remove('active');
                                button.innerHTML = '<i class="far fa-heart"></i>';
                                // Tambahkan animasi
                                button.style.transform = 'scale(0.8)';
                                setTimeout(() => {
                                    button.style.transform = 'scale(1)';
                                }, 300);
                                
                                // Update wishlist count
                                const wishlistCount = document.querySelector('.wishlist-count');
                                if (wishlistCount) {
                                    wishlistCount.textContent = parseInt(wishlistCount.textContent) - 1;
                                }
                            }
                        } else {
                            alert(data.message);
                            button.innerHTML = '<i class="far fa-heart"></i>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memproses wishlist');
                        button.innerHTML = '<i class="far fa-heart"></i>';
                    });
                @else
                    // Redirect ke halaman login jika belum login
                    window.location.href = "{{ route('login') }}";
                @endif
            });
        });
    });
</script>
@endpush