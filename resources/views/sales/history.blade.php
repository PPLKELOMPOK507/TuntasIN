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

        <!-- User Profile Dropdown -->
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
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('account.balance') }}" class="menu-item">
                    <i class="fas fa-wallet"></i>
                    <span>My Balance</span>
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
                    <option value="awaiting_verification">Sedang Diverifikasi</option>
                    <option value="paid">Terbayar</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
        </div>

        <div class="sales-grid">
            @forelse($sales as $sale)
                <div class="sale-card" data-status="{{ $sale->status }}">
                    <div class="service-image">
                        <img src="{{ asset('storage/' . $sale->jasa->gambar) }}" alt="{{ $sale->jasa->nama_jasa }}">
                    </div>
                    <div class="sale-info">
                        <div class="sale-header">
                            <div class="sale-id-date">
                                <span class="order-id">#{{ $sale->id }}</span>
                                <span class="sale-date">{{ $sale->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="status-badge {{ $sale->status }}">
                                @switch($sale->status)
                                    @case('awaiting_verification')
                                        Sedang Diverifikasi
                                        @break
                                    @case('paid')
                                        Terbayar
                                        @break
                                    @case('cancelled')
                                        Dibatalkan
                                        @break
                                    @default
                                        {{ ucfirst($sale->status) }}
                                @endswitch
                            </div>
                        </div>
                        <div class="sale-details">
                            <h3>{{ $sale['service_name'] }}</h3>
                            <p>Pembeli: {{ $sale->user->fullname }}</p>
                            <p>Harga: Rp {{ number_format($sale['harga'], 0, ',', '.') }}</p>
                            @php
                                $refundPending = isset($sale->refunds) && $sale->refunds->where('status', 'pending')->count() > 0;
                                $pendingRefund = isset($sale->refunds) ? $sale->refunds->where('status', 'pending')->first() : null;
                                $refundStatus = null;
                                if ($pendingRefund) {
                                    $refundStatus = $pendingRefund->provider_response ?? 'pending';
                                }
                            @endphp
                            <span class="status-badge
                                @if($sale['status'] === 'completed') completed
                                @elseif($sale['status'] === 'pending') pending
                                @elseif($sale['status'] === 'cancelled') cancelled
                                @elseif($sale['status'] === 'paid' && $refundPending && $refundStatus === 'pending') refund-request
                                @elseif($sale['status'] === 'paid' && $refundPending && $refundStatus === 'accepted') refund-accepted
                                @elseif($sale['status'] === 'paid' && $refundPending && $refundStatus === 'declined') refund-declined
                                @endif
                            ">
                                @if($sale['status'] === 'paid' && $refundPending)
                                    @if($refundStatus === 'pending')
                                        Request Refund
                                    @elseif($refundStatus === 'accepted')
                                        Refund Diterima, Menunggu Verifikasi Admin
                                    @elseif($refundStatus === 'declined')
                                        Refund Ditolak Penyedia Jasa
                                    @else
                                        Request Refund
                                    @endif
                                @else
                                    {{ ucfirst($sale['status']) }}
                                @endif
                            </span>
                            @if($sale['status'] === 'paid' && $refundPending && $pendingRefund)
                                <br>
                                <a href="{{ route('provider.refunds.show', $pendingRefund->id) }}" class="btn btn-info" style="margin-top:8px;">
                                    Lihat Detail Refund
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-receipt"></i>
                    <h3>Belum ada penjualan</h3>
                    <p>Riwayat penjualan Anda akan muncul di sini</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('css/sales-history.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('status-filter');
    
    statusFilter.addEventListener('change', function() {
        const selectedStatus = this.value;
        const saleCards = document.querySelectorAll('.sale-card');
        
        saleCards.forEach(card => {
            const status = card.dataset.status;
            if (selectedStatus === 'all' || status === selectedStatus) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>
@endpush