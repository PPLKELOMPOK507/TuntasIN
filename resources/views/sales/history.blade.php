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
                <a href="{{ route('sales.history') }}" class="menu-item active">
                    <i class="fas fa-history"></i>
                    <span>Riwayat Penjualan</span>
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

    <div class="sales-history-container">
        <div class="history-header">
            <h1>Riwayat Penjualan</h1>
            <div class="filters">
                <select class="filter-select" id="status-filter">
                    <option value="all">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
        </div>

        @if(count($sales) > 0)
            <div class="sales-list">
                @foreach($sales as $sale)
                    <div class="sale-card">
                        <div class="sale-header">
                            <span class="order-id">Order #{{ $sale['id'] }}</span>
                            <span class="sale-date">{{ $sale['date'] }}</span>
                        </div>
                        <div class="sale-details">
                            <h3>{{ $sale['service_name'] }}</h3>
                            <p>Pembeli: {{ $sale['buyer_name'] }}</p>
                            <p>Harga: Rp {{ number_format($sale['amount'], 0, ',', '.') }}</p>
                            <span class="status-badge {{ $sale['status'] }}">
                                {{ ucfirst($sale['status']) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <img src="{{ asset('images/empty-sales.svg') }}" alt="No sales yet" class="empty-icon">
                <h2>Belum ada penjualan</h2>
                <p>Riwayat penjualan Anda akan muncul di sini</p>
            </div>
        @endif
    </div>
</div>

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sales-history.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .sale-card {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .sale-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
        }

        .status-badge.completed {
            background: #e6f4ea;
            color: #137333;
        }

        .status-badge.pending {
            background: #fef7e0;
            color: #b06000;
        }

        .status-badge.cancelled {
            background: #fce8e6;
            color: #c5221f;
        }

        .sales-list {
            margin-top: 1rem;
        }
    </style>
@endpush

@push('scripts')
<script>
document.getElementById('status-filter').addEventListener('change', function() {
    const selectedStatus = this.value;
    const saleCards = document.querySelectorAll('.sale-card');
    
    saleCards.forEach(card => {
        const statusBadge = card.querySelector('.status-badge');
        const status = statusBadge.classList[1]; // Gets the status class (completed/pending/cancelled)
        
        if (selectedStatus === 'all' || status === selectedStatus) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endpush
@endsection