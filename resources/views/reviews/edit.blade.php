@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <nav class="nav-container">
        <div class="logo">
            <a href="{{ route('dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
        </div>
    </nav>

    <div class="review-edit-container">
        <div class="review-header">
            <h1>Edit Review</h1>
            <a href="{{ route('purchases.history') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="review-form-container">
            <!-- Service Info -->
            <div class="service-info">
                <img src="{{ asset('storage/' . $review->jasa->gambar) }}" alt="{{ $review->jasa->nama_jasa }}">
                <div class="service-details">
                    <h3>{{ $review->jasa->nama_jasa }}</h3>
                    <p>Oleh: {{ $review->jasa->user->first_name }} {{ $review->jasa->user->last_name }}</p>
                </div>
            </div>

            <form action="{{ route('review.update', $review->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Rating Section -->
                <div class="rating-section">
                    <label>Rating:</label>
                    <div class="star-rating">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" value="{{ $i }}" 
                                   id="star{{ $i }}" 
                                   {{ $review->rating == $i ? 'checked' : '' }} required>
                            <label for="star{{ $i }}">
                                <i class="fas fa-star"></i>
                            </label>
                        @endfor
                    </div>
                    @error('rating')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Review Section -->
                <div class="review-section">
                    <label>Review:</label>
                    <textarea name="review" rows="4" required 
                        placeholder="Bagikan pengalaman Anda menggunakan jasa ini...">{{ $review->review }}</textarea>
                    @error('review')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="history.back()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-check"></i> Update Review
                    </button>
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