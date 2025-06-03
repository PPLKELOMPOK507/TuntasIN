@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <nav class="nav-container">
        <div class="logo">
            <a href="{{ route('dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
        </div>
    </nav>

    <div class="review-container">
        <div class="review-header">
            <h1>Beri Ulasan</h1>
            <a href="{{ route('purchases.history') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="review-card">
            <!-- Informasi Jasa -->
            <div class="service-info">
                <img src="{{ asset('storage/' . $pemesanan->jasa->gambar) }}" alt="{{ $pemesanan->jasa->nama_jasa }}">
                <div class="service-details">
                    <h3>{{ $pemesanan->jasa->nama_jasa }}</h3>
                    <p>Penyedia: {{ $pemesanan->jasa->user->full_name }}</p>
                </div>
            </div>

            <!-- Form Review -->
            <form action="{{ route('review.store', $pemesanan->id) }}" method="POST" class="review-form">
                @csrf
                <div class="rating-section">
                    <label>Rating:</label>
                    <div class="star-rating">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                            <label for="star{{ $i }}">
                                <i class="fas fa-star"></i>
                            </label>
                        @endfor
                    </div>
                </div>

                <div class="review-section">
                    <label>Ulasan:</label>
                    <textarea name="review" rows="4" required placeholder="Bagikan pengalaman Anda menggunakan jasa ini..."></textarea>
                    @error('review')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Kirim Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('css/reviews.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush