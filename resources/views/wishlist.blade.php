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

    <div class="wishlist-container">
        <div class="wishlist-header">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <h1>My Service Wishlist</h1>
        </div>

        <div class="service-grid">
            @forelse($wishlistItems as $item)
                <div class="service-card" data-wishlist-id="{{ $item->id }}">
                    <div class="service-image">
                        <img src="{{ asset('storage/' . $item->service->gambar) }}" alt="{{ $item->service->nama_jasa }}">
                        <form action="{{ route('wishlist.remove', $item->service->id) }}" method="POST" class="wishlist-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="wishlist-btn active">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    </div>
                    <div class="service-info">
                        <h3 class="service-title">{{ $item->service->nama_jasa }}</h3>
                        <div class="service-price">
                            <span>Start From</span>
                            <strong>Rp {{ number_format($item->service->minimal_harga, 0, ',', '.') }}</strong>
                        </div>
                        <a href="{{ route('jasa.detail', $item->service->id) }}" class="view-service-btn">See Details</a>
                    </div>
                </div>
            @empty
                <div class="empty-wishlist">
                    <div class="empty-icon">
                        <i class="fas fa-heart-broken"></i>
                    </div>
                    <p>Wishlist Anda masih kosong</p>
                    <a href="{{ route('dashboard') }}" class="browse-services-btn">Jelajahi Layanan</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/services.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">
@endpush