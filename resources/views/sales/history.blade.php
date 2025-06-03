@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Navigation -->
    <nav class="nav-container">
        <div class="logo">
            <a href="{{ route('dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
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

    <div class="purchases-history-container">
        <div class="history-header">
            <h1>Riwayat Pembelian</h1>
        </div>

        <div class="purchases-grid">
            @forelse($sales as $sale)
                <div class="purchase-card">
                    <div class="service-image">
                        <img src="{{ asset('storage/' . $sale->jasa->gambar) }}" alt="{{ $sale->jasa->nama_jasa }}">
                    </div>
                    <div class="purchase-info">
                        <div class="purchase-header">
                            <span class="order-id">#{{ $sale->id }}</span>
                            <span class="purchase-date">{{ $sale->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="service-details">
                            <h3>{{ $sale->jasa->nama_jasa }}</h3>
                            <p><span class="label">Pembeli:</span> {{ $sale->user->full_name }}</p>
                            <p><span class="label">Alamat:</span> {{ $sale->user->address ?? 'Alamat tidak tersedia' }}</p>
                            <p><span class="label">Total Pembayaran:</span> Rp {{ number_format($sale->harga, 0, ',', '.') }}</p>
                            
                            <!-- Status Badge dengan Refund Status -->
                            @php
                                $refund = $sale->refunds->first();
                            @endphp
                            <div class="status-badges">
                                <!-- Payment Status -->
                                <span class="status-badge {{ $sale->status }}">
                                    @switch($sale->status)
                                        @case('paid')
                                            Pembayaran Diterima
                                            @break
                                        @case('completed')
                                            Selesai
                                            @break
                                        @case('cancelled')
                                            Cancelled
                                            @break
                                        @default
                                            {{ ucfirst($sale->status) }}
                                    @endswitch
                                </span>

                                <!-- Refund Status if exists -->
                                @if($refund)
                                    <span class="status-badge refund-badge
                                        @if($refund->status === 'pending' && !$refund->provider_response) bg-warning
                                        @elseif($refund->status === 'pending' && $refund->provider_response === 'accepted') bg-info 
                                        @elseif($refund->status === 'approved') bg-success
                                        @elseif($refund->status === 'rejected' || $refund->provider_response === 'rejected') bg-danger
                                        @endif">
                                        @if($refund->status === 'pending' && !$refund->provider_response)
                                            Permintaan Refund Baru
                                        @elseif($refund->status === 'pending' && $refund->provider_response === 'accepted')
                                            Menunggu Admin
                                        @elseif($refund->status === 'approved')
                                            Refund Disetujui
                                        @elseif($refund->status === 'rejected')
                                            Refund Ditolak
                                        @endif
                                    </span>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                @if($refund && $refund->status === 'pending' && !$refund->provider_response)
                                    <a href="{{ route('provider.refunds.detail', $refund->id) }}" class="btn btn-warning">
                                        <i class="fas fa-eye"></i> Review Refund
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>Belum ada riwayat penjualan</p>
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
