@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Navigation -->
    <nav class="nav-container">
        <div class="logo">
            <a href="/">TUNTAS<span class="logo-in">IN</span></a>
        </div>
        
        <!-- User Menu -->
        <div class="user-profile">
            <div class="user-info">
                <span class="user-name">{{ Auth::user()->full_name }}</span>
                <div class="profile-image">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile">
                    @else
                        <div class="profile-placeholder"></div>
                    @endif
                </div>
            </div>
            <div class="dropdown-menu">
                <a href="{{ route('sales.history') }}" class="menu-item active">
                    <i class="fas fa-history"></i> Riwayat Penjualan
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="dashboard-main">
        <div class="sales-history-container">
            <h2>Riwayat Penjualan Jasa</h2>
            
            <div class="sales-grid">
                @forelse($sales as $sale)
                    <div class="sale-card">
                        <div class="sale-header">
                            <span class="order-id">Order #{{ $sale->id }}</span>
                            <span class="sale-date">{{ $sale->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="sale-details">
                            <img src="{{ asset('storage/' . $sale->service->image) }}" alt="Service" class="service-thumb">
                            <div class="service-info">
                                <h3>{{ $sale->service->title }}</h3>
                                <p class="buyer">Pembeli: {{ $sale->buyer->full_name }}</p>
                                <div class="price-status">
                                    <span class="price">Rp {{ number_format($sale->amount, 0, ',', '.') }}</span>
                                    <span class="status {{ $sale->status }}">{{ $sale->status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-sales">
                        <i class="fas fa-store-slash"></i>
                        <p>Belum ada penjualan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sales-history.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush