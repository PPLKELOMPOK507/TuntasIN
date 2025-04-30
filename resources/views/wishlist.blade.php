@extends('layouts.app')

@section('content')
<div class="wishlist-container">
    <div class="wishlist-header">
        <h1>Wishlist Layanan Anda</h1>
    </div>

    <div class="service-grid">
        @for ($i = 1; $i <= 8; $i++)
            <div class="service-card" data-wishlist-id="{{ $i }}">
                <div class="service-image">
                    <img src="{{ asset('images/Dashboard (2).png') }}" alt="Checklist Illustration" class="illustration">
                    <button class="remove-wishlist-btn" data-wishlist-id="{{ $i }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="service-info">
                    <div class="service-provider">
                        <img src="https://via.placeholder.com/30x30" alt="Provider" class="provider-image">
                        <span class="provider-name">Provider Dummy {{ $i }}</span>
                        <span class="provider-level">Level 2</span>
                    </div>
                    <h3 class="service-title">Saya akan melakukan sesuatu yang luar biasa untuk bisnis Anda</h3>
                    <div class="service-rating">
                        <span class="stars">⭐ 4.9</span>
                        <span class="rating-count">(153)</span>
                    </div>
                    <div class="service-price">
                        <span>Mulai dari</span>
                        <strong>Rp 250.000</strong>
                    </div>
                    <a href="#" class="view-service-btn">Lihat Detail</a>
                </div>
            </div>
        @endfor
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* semua style tetap sama, tidak perlu diubah */
        {{--
            ... (copy style kamu tanpa perubahan)
        --}}
    </style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handler dummy untuk tombol hapus wishlist
        const removeButtons = document.querySelectorAll('.remove-wishlist-btn');
        
        removeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const wishlistId = this.getAttribute('data-wishlist-id');
                const card = document.querySelector(`.service-card[data-wishlist-id="${wishlistId}"]`);
                
                // Dummy remove tanpa backend
                card.remove();
                
                const remainingItems = document.querySelectorAll('.service-card');
                if (remainingItems.length === 0) {
                    const wishlistContainer = document.querySelector('.wishlist-container');
                    wishlistContainer.innerHTML = `
                        <div class="wishlist-header">
                            <h1>Wishlist Layanan Anda Sekarang</h1>
                        </div>
                        <div class="empty-wishlist">
                            <div class="empty-icon">
                                <i class="fas fa-heart-broken"></i>
                            </div>
                            <p>Wishlist Anda masih kosong</p>
                            <a href="#" class="browse-services-btn">Jelajahi Layanan</a>
                        </div>
                    `;
                }

                alert('Layanan dummy berhasil dihapus dari wishlist');
            });
        });
    });
</script>
@endpush
