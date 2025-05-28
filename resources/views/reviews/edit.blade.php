@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <nav class="nav-container">
        <!-- ... existing nav code ... -->
    </nav>

    <div class="review-edit-container">
        <div class="review-header">
            <h1>Edit Review</h1>
            <a href="{{ route('purchases.history') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="review-form-container">
            <form action="{{ route('review.update', $review->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Jasa:</label>
                    <p class="service-name">{{ $review->jasa->nama_jasa }}</p>
                </div>

                <div class="form-group">
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
                </div>

                <div class="form-group">
                    <label>Review:</label>
                    <textarea name="review" class="form-control" rows="4" required>{{ $review->review }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="history.back()">Batal</button>
                    <button type="submit" class="btn-submit">Update Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('css/reviews.css') }}" rel="stylesheet">
@endpush