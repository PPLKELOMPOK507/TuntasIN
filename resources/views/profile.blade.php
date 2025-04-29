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
        
        <!-- User Menu -->
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
                <a href="{{ route('profile') }}" class="menu-item active">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                @if(Auth::user()->role === 'Penyedia Jasa')
                    <a href="{{ route('sales.history') }}" class="menu-item">
                        <i class="fas fa-history"></i>
                        <span>Riwayat Penjualan</span>
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="profile-container">
        <div class="profile-header">
            <h1>My Profile</h1>
        </div>

        <div class="profile-content">
            <div class="profile-photo">
                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile Photo">
                @else
                    <div class="photo-placeholder"></div>
                @endif
                <button class="change-photo-btn">Change Photo</button>
            </div>

            <div class="profile-info">
                <div class="info-group">
                    <label>Full Name</label>
                    <p>{{ Auth::user()->full_name }}</p>
                </div>
                <div class="info-group">
                    <label>Email</label>
                    <p>{{ Auth::user()->email }}</p>
                </div>
                <div class="info-group">
                    <label>Role</label>
                    <p>{{ Auth::user()->role }}</p>
                </div>
                <div class="info-group">
                    <label>Mobile Number</label>
                    <p>{{ Auth::user()->mobile_number }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush