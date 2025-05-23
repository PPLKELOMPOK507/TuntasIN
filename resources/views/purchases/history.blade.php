@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <nav class="nav-container">
        <div class="logo">
            @auth
                <a href="{{ route('dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
            @else
                <a href="/">TUNTAS<span class="logo-in">IN</span></a>
            @endauth
        </div>
        
        <div class="user-profile">
            <div class="user-info">
                <div class="profile-image">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile">
                    @else
                        <div class="profile-placeholder"></div>
                    @endif
                </div>
                <span class="user-name">{{ Auth::user()->full_name }}</span>
            </div>
            <div class="dropdown-menu">
                <a href="{{ route('profile') }}" class="menu-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('purchases.history') }}" class="menu-item active">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Riwayat Pembelian</span>
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

    <div class="purchases-history-container">
        <div class="history-header">
            <h1>Riwayat Pembelian</h1>
            <div class="filters">
                <select class="filter-select" id="status-filter">
                    <option value="all">Semua Status</option>
                    <option value="pending">Menunggu Konfirmasi</option>
                    <option value="process">Sedang Diproses</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
        </div>

        <div class="purchases-grid">
            <!-- Sample Purchase Card -->
            <div class="purchase-card">
                <div class="service-image">
                    <img src="{{ asset('images/sample-service.jpg') }}" alt="Service Image">
                </div>
                <div class="purchase-info">
                    <div class="purchase-header">
                        <span class="order-id">#ORD12345</span>
                        <span class="purchase-date">15 Mar 2024</span>
                    </div>
                    <h3 class="service-name">Jasa Design Logo Professional</h3>
                    <div class="provider-info">
                        <i class="fas fa-user-circle"></i>
                        <span>Oleh: John Designer</span>
                    </div>
                    <div class="price-info">
                        <span>Total Pembayaran:</span>
                        <strong>Rp 500.000</strong>
                    </div>
                    <div class="status-badge pending">Menunggu Konfirmasi</div>
                    <div class="action-buttons">
                        <button class="btn-detail">Lihat Detail</button>
                        <button class="btn-chat">Chat Penjual</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('css/purchases-history.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush