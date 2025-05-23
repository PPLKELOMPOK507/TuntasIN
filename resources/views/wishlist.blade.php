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
    </nav>

    <div class="wishlist-container">
        <div class="wishlist-header">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h1>Wishlist Layanan Saya</h1>
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
                            <span>Mulai dari</span>
                            <strong>Rp {{ number_format($item->service->minimal_harga, 0, ',', '.') }}</strong>
                        </div>
                        <a href="{{ route('jasa.detail', $item->service->id) }}" class="view-service-btn">Lihat Detail</a>
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