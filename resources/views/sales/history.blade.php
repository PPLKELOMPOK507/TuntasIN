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
                        <div class="action-buttons">
                            <button class="btn-detail">Lihat Detail</button>
                            <button class="btn-chat">Chat Penjual</button>
                            @if($sale['status'] === 'completed' && !$sale['hasReview'])
                                <button class="btn-review" onclick="openReviewModal({{ $sale['id'] }}, '{{ $sale['service_name'] }}')">
                                    <i class="fas fa-star"></i> Nilai
                                </button>
                            @endif
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

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Beri Ulasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('review.store') }}" method="POST" id="reviewForm">
                @csrf
                <input type="hidden" name="pemesanan_id" id="pemesanan_id">
                <div class="modal-body">
                    <div class="jasa-name mb-3"></div>
                    <div class="rating-input mb-3">
                        <label>Rating:</label>
                        <div class="star-rating">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}">
                                <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                    </div>
                    <div class="review-input">
                        <label>Review:</label>
                        <textarea name="review" class="form-control" rows="3" required></textarea>
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

        .action-buttons {
            margin-top: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .btn-detail, .btn-chat, .btn-review {
            flex: 1;
            padding: 0.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-detail {
            background: #007bff;
            color: white;
        }

        .btn-chat {
            background: #28a745;
            color: white;
        }

        .btn-review {
            background: #ffc107;
            color: white;
        }

        .btn-detail:hover {
            background: #0056b3;
        }

        .btn-chat:hover {
            background: #218838;
        }

        .btn-review:hover {
            background: #e0a800;
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

function openReviewModal(pemesananId, jasaName) {
    document.getElementById('pemesanan_id').value = pemesananId;
    document.querySelector('.jasa-name').innerText = jasaName;
    const modal = new bootstrap.Modal(document.getElementById('reviewModal'));
    modal.show();
}
</script>
@endpush
@endsection