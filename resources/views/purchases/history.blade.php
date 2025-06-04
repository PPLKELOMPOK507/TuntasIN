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
                    <option value="pending">Menunggu Pembayaran</option>
                    <option value="awaiting_verification">Menunggu Verifikasi</option>
                    <option value="paid">Pembayaran Diterima</option>
                    <option value="cancelled">Pembayaran Ditolak</option>
                </select>
            </div>
        </div>

        <div class="purchases-grid">
            @forelse($purchases as $purchase)
                <div class="purchase-card" data-status="{{ $purchase->status }}">
                    <div class="service-image">
                        <img src="{{ asset('storage/' . $purchase->jasa->gambar) }}" alt="{{ $purchase->jasa->nama_jasa }}">
                    </div>
                    <div class="purchase-info" style="display: flex; flex-direction: column; height: 100%;">
                        <div>
                            <div class="purchase-header">
                                <span class="order-id">#{{ $purchase->id }}</span>
                                <span class="purchase-date">{{ $purchase->created_at->format('d M Y') }}</span>
                            </div>
                            <h3 class="service-name">{{ $purchase->jasa->nama_jasa }}</h3>
                            <div class="provider-info">
                                <i class="fas fa-user-circle"></i>
                                <span>Oleh: {{ $purchase->jasa->user->full_name }}</span>
                            </div>
                            <div class="price-info">
                                <span>Total Pembayaran:</span>
                                <strong>Rp {{ number_format($purchase->harga, 0, ',', '.') }}</strong>
                            </div>
                            @php
                                $refundApproved = isset($purchase->refunds) && $purchase->refunds->where('status', 'approved')->count() > 0;
                                $refundRejected = isset($purchase->refunds) && $purchase->refunds->where('status', 'rejected')->count() > 0;
                            @endphp
                            <div class="status-badge
                                @if($refundApproved)
                                    refund-approved
                                @elseif($refundRejected)
                                    refund-rejected
                                @else
                                    {{ $purchase->status }}
                                @endif
                            ">
                                @if($refundApproved)
                                    Refund Disetujui Admin
                                @elseif($refundRejected)
                                    Refund Ditolak
                                @else
                                    @switch($purchase->status)
                                        @case('pending')
                                            Menunggu Pembayaran
                                            @break
                                        @case('awaiting_verification')
                                            Menunggu Verifikasi Admin
                                            @break
                                        @case('paid')
                                            Pembayaran Diterima
                                            @break
                                        @case('cancelled')
                                            Pembayaran Ditolak
                                            @break
                                        @default
                                            {{ ucfirst($purchase->status) }}
                                    @endswitch
                                @endif
                            </div>

                            <!-- Refund Status if exists -->
                            @if($purchase->refunds && $purchase->refunds->count() > 0)
                                @php $refund = $purchase->refunds->first(); @endphp
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
                                    @elseif($refund->status === 'rejected' || $refund->provider_response === 'rejected')
                                        Refund Ditolak oleh Penyedia Jasa
                                    @endif
                                </span>
                            @endif
                        </div>
                        <div class="action-buttons" style="margin-left:auto; margin-top:auto;">
                            @if($purchase->status === 'pending')
                                <a href="{{ route('payment.form', $purchase->id) }}" class="btn-pay">
                                    Bayar Sekarang
                                </a>
                            @endif

                            @if($purchase->status === 'paid')
                                @if($purchase->hasReview()->exists())
                                    <!-- Tampilkan tombol edit jika sudah ada review -->
                                    <a href="{{ route('review.edit', $purchase->review->id) }}" class="btn-edit-review">
                                        <i class="fas fa-edit"></i> Edit Review
                                    </a>
                                @else
                                    <!-- Tampilkan tombol beri review jika belum ada -->
                                    <a href="{{ route('review.create', $purchase->id) }}" class="btn-review">
                                        <i class="fas fa-star"></i> Beri Review
                                    </a>
                                @endif

                                @if(!$refundApproved && !$refundRejected)
                                    <a href="{{ route('refunds.create', $purchase->id) }}" class="btn-refund">
                                        Ajukan refund
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <h2>Belum ada pembelian</h2>
                    <p>Riwayat pembelian Anda akan muncul di sini</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('css/purchases-history.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('status-filter');
    
    statusFilter.addEventListener('change', function() {
        const selectedStatus = this.value;
        const purchaseCards = document.querySelectorAll('.purchase-card');
        
        purchaseCards.forEach(card => {
            const status = card.getAttribute('data-status');
            if (selectedStatus === 'all' || status === selectedStatus) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

function showPurchaseDetail(purchaseId) {
    // Implement purchase detail modal/page navigation
    window.location.href = `/purchases/${purchaseId}`;
}
</script>
@endpush