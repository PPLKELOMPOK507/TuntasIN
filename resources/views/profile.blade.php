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
                    <div class="photo-placeholder">
                        <i class="fas fa-user fa-3x" style="color: #0077cc;"></i>
                    </div>
                @endif
                <input type="file" 
                       id="photo" 
                       name="photo" 
                       accept="image/*" 
                       hidden>
                <button type="button" class="change-photo-btn" onclick="document.getElementById('photo').click()">
                    <i class="fas fa-camera"></i>
                    Change Photo
                </button>
            </div>

            <div class="profile-info">
                <form action="{{ route('profile.update') }}" method="POST" class="profile-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="info-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ Auth::user()->first_name }}" class="profile-input">
                    </div>
                    
                    <div class="info-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ Auth::user()->last_name }}" class="profile-input">
                    </div>

                    <div class="info-group">
                        <label>Email</label>
                        <p class="static-info">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="info-group">
                        <label>Role</label>
                        <p class="static-info">{{ Auth::user()->role }}</p>
                    </div>

                    <div class="info-group">
                        <label>Mobile Number</label>
                        <p class="static-info">{{ Auth::user()->mobile_number }}</p>
                    </div>

                    <div class="password-section">
                        <h3>
                            <i class="fas fa-lock"></i>
                            Change Password
                        </h3>
                        <div class="info-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password" 
                                   class="profile-input"
                                   placeholder="Enter your current password">
                        </div>

                        <div class="info-group">
                            <label for="new_password">New Password</label>
                            <input type="password" 
                                   id="new_password" 
                                   name="new_password" 
                                   class="profile-input"
                                   placeholder="Enter new password">
                        </div>

                        <div class="info-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <input type="password" 
                                   id="new_password_confirmation" 
                                   name="new_password_confirmation" 
                                   class="profile-input"
                                   placeholder="Confirm your new password">
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="button-group">
                        <button type="submit" class="save-btn">Save Changes</button>
                    </div>
                </form>
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