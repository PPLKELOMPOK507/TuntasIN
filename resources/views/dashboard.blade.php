@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Navigation -->
    <nav class="nav-container">
        <div class="logo">
            <a href="/">TUNTAS<span class="logo-in">IN</span></a>
        </div>
        
        <!-- Search Section -->
        <div class="search-section">
            <div class="search-container">
                <input type="search" class="search-input" placeholder="Find services...">
                <button class="filter-btn">
                    <i class="fas fa-sliders-h"></i>
                </button>
            </div>
        </div>

        <!-- User Menu -->
        <div class="user-profile">
            <div class="user-info">
                <span class="user-name">{{ Auth::user()->full_name }}</span>
                <div class="profile-image">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile">
                    @else
                        <div class="profile-placeholder"></div>
                    @endif
                </div>
            </div>
            <div class="dropdown-menu">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Category Navigation -->
    <div class="category-nav">
        <div class="category-scroll">
            <a href="#" class="category-link active">Graphics & Design</a>
            <a href="#" class="category-link">Programming & Tech</a>
            <a href="#" class="category-link">Digital Marketing</a>
            <a href="#" class="category-link">Video & Animation</a>
            <a href="#" class="category-link">Writing & Translation</a>
            <a href="#" class="category-link">Music & Audio</a>
            <a href="#" class="category-link">Business</a>
        </div>
    </div>

    <div class="dashboard-main">
        <!-- Featured Section -->
        <section class="featured-section">
            <h2>Popular Services</h2>
            <div class="service-grid">
                @for ($i = 1; $i <= 8; $i++)
                <div class="service-card">
                    <div class="service-image">
                        <img src="{{ asset('images/Dashboard (2).png') }}" alt="Checklist Illustration" class="illustration" style="width: 1000px; ">
                        <button class="favorite-btn">❤</button>
                    </div>
                    <div class="service-info">
                        <div class="service-provider">
                            <img src="https://via.placeholder.com/30x30" alt="Provider" class="provider-image">
                            <span class="provider-name">Service Provider {{$i}}</span>
                            <span class="provider-level">Level 2</span>
                        </div>
                        <h3 class="service-title">I will do something amazing for your business</h3>
                        <div class="service-rating">
                            <span class="stars">⭐ 4.9</span>
                            <span class="rating-count">(153)</span>
                        </div>
                        <div class="service-price">
                            <span>Starting at</span>
                            <strong>Rp 250.000</strong>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </section>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush