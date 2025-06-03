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
            @forelse($purchases as $purchase)
                <div class="purchase-card">
                    <div class="service-image">
                        <img src="{{ asset('storage/' . $purchase->jasa->gambar) }}" alt="{{ $purchase->jasa->nama_jasa }}">
                    </div>
                    <div class="purchase-info">
                        <div class="purchase-header">
                            <span class="purchase-date">{{ $purchase->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="service-details">
                            <h3>{{ $purchase->jasa->nama_jasa }}</h3>
                            <p><span class="label">Oleh:</span> {{ $purchase->jasa->user->full_name }}</p>
                            <p><span class="label">Total Pembayaran:</span> Rp {{ number_format($purchase->harga, 0, ',', '.') }}</p>
                            <span class="status-badge {{ $purchase->status }}">
                                @switch($purchase->status)
                                    @case('paid')
                                        Pembayaran Diterima
                                        @break
                                    @case('pending')
                                        Menunggu Pembayaran
                                        @break
                                    @default
                                        {{ ucfirst($purchase->status) }}
                                @endswitch
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Modal Review -->
                <div class="modal fade" id="reviewModal-{{ $purchase->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Beri Ulasan untuk {{ $purchase->jasa->nama_jasa }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('review.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pemesanan_id" value="{{ $purchase->id }}">
                                <div class="modal-body">
                                    <div class="rating-input mb-3">
                                        <label>Rating:</label>
                                        <div class="star-rating">
                                            @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}-{{ $purchase->id }}" required>
                                                <label for="star{{ $i }}-{{ $purchase->id }}">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="review-input">
                                        <label>Review:</label>
                                        <textarea name="review" class="form-control" rows="3" placeholder="Bagikan pengalaman Anda menggunakan jasa ini..." required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Kirim Review</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>Belum ada riwayat pembelian</p>
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
<style>
.price-info {
    margin-top: 12px;
    padding: 8px 12px;
    background: #f8f9fa;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price-label {
    color: #6c757d;
    font-size: 14px;
}

.price-amount {
    font-weight: 600;
    color: #2563eb;
    font-size: 16px;
}
</style>
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
