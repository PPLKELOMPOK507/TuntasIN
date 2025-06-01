@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Navigation -->
    <nav class="nav-container">
        <div class="logo">
            @auth
                <a href="{{ route('dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
            @else
                <a href="/">TUNTAS<span class="logo-in">IN</span></a>
            @endauth
        </div>
        
        <!-- Search Section -->
        <div class="search-section">
            <form action="{{ route('dashboard') }}" method="GET">
                <select name="category" class="category-select" onchange="this.form.submit()">
                    <option value="">-- Semua Kategori --</option>
                    <option value="Kebersihan" {{ request('dasoard') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                    <option value="Perbaikan" {{ request('category') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                    <option value="Rumah Tangga" {{ request('category') == 'Rumah Tangga' ? 'selected' : '' }}>Rumah Tangga</option>
                    <option value="Teknologi" {{ request('category') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                    <option value="Transformasi" {{ request('category') == 'Transformasi' ? 'selected' : '' }}>Transformasi</option>
                </select>
            </form>
        </div>

        @if(Auth::user()->role === 'Pengguna Jasa')
            <div class="tooltip-container" style="margin-right: 12px;">
                <a href="{{ route('forum') }}" class="nav-icon-btn">
                    <i class="fas fa-users"></i>
                </a>
                <span class="tooltip-text">Forum</span>
            </div>
            <div class="tooltip-container">
                <a href="{{ route('wishlist') }}" class="nav-icon-btn">
                    <i class="fas fa-heart"></i>
                </a>
                <span class="tooltip-text">Wishlist</span>
            </div>
        @endif
        
        <div class="user-profile">
            <div class="user-info">
                <div class="profile-image">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile">
                    @else
                        <div class="profile-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                <button class="dropdown-toggle"> ⌵ </button>
            </div>
            <div class="dropdown-menu">
                <a href="{{ route('profile') }}" class="menu-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
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

    <style>
        :root {
            --primary-color: #3498db;
            --primary-light: #75C5F0;
            --primary-dark: #2980b9;
            --secondary-color: #ff9f43;
            --secondary-dark: #f39c12;
            --success-color: #2ecc71;
            --warning-color: #f1c40f;
            --danger-color: #e74c3c;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
            --dark-gray: #495057;
            --card-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            background-color: #f4f7fc;
            color: #333;
            font-family: 'Nunito', sans-serif;
        }

        .nav-container {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            padding: 15px 25px;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .logo a {
            color: white;
            font-size: 1.8rem;
            font-weight: 800;
            text-decoration: none;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        .logo-in {
            color: var(--secondary-color);
            font-weight: 900;
        }
        
        .category-select {
            background-color: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            border-radius: 8px;
            padding: 10px 15px;
            width: 100%;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .category-select:focus {
            background-color: white;
            color: var(--dark-gray);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.25);
        }
        
        .category-select option {
            background-color: white;
            color: var(--dark-gray);
        }
        
        .nav-icon-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .nav-icon-btn:hover {
            background-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }
        
        .tooltip-container {
            position: relative;
        }
        
        .tooltip-text {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }
        
        .tooltip-container:hover .tooltip-text {
            opacity: 1;
            visibility: visible;
        }
        
        .user-profile {
            position: relative;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 1.2rem;
        }
        
        .dropdown-toggle {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            margin-left: 5px;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            min-width: 180px;
            padding: 10px 0;
            display: none;
            z-index: 100;
        }
        
        .user-profile:hover .dropdown-menu {
            display: block;
        }
        
        .menu-item, .logout-btn {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: var(--dark-gray);
            text-decoration: none;
            transition: var(--transition);
            width: 100%;
            text-align: left;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
        }
        
        .menu-item:hover, .logout-btn:hover {
            background-color: var(--light-gray);
            color: var(--primary-color);
        }
        
        .menu-item i, .logout-btn i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Detail page specific styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            border: none;
            background-color: white;
            color: var(--primary-dark);
            font-weight: 600;
            transition: var(--transition);
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .btn-back:hover {
            background-color: var(--primary-light);
            color: white;
            transform: translateX(-3px);
        }

        .service-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .service-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 80px;
            height: 4px;
            background: var(--secondary-color);
            border-radius: 2px;
        }

        .detail-container {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            margin-top: 30px;
        }

        .image-section {
            flex: 1 1 45%;
            min-width: 300px;
            position: relative;
        }

        .service-image {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .service-image:hover {
            transform: scale(1.02);
        }

        .service-category {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: var(--primary-color);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .info-section {
            flex: 1 1 50%;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .provider-info {
            display: flex;
            align-items: center;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border-left: 5px solid var(--primary-color);
        }

        .provider-info:hover {
            transform: translateY(-5px);
        }

        .provider-info img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin-right: 20px;
            object-fit: cover;
            border: 3px solid var(--primary-light);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .provider-placeholder {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin-right: 20px;
            background: linear-gradient(135deg, #e0e0e0, #cccccc);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: white;
        }

        .provider-details h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark-gray);
            margin-bottom: 8px;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 20px;
            background-color: var(--warning-color);
            color: #333;
        }

        .description-box {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--card-shadow);
        }

        .description-box h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .description-box h3::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--secondary-color);
            border-radius: 2px;
        }

        .service-description {
            line-height: 1.7;
            color: var(--dark-gray);
            text-align: justify;
        }

        .card-box {
            border: none;
            border-radius: 12px;
            padding: 30px;
            background: white;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .card-box::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(117, 197, 240, 0) 70%);
            border-radius: 0 0 0 120px;
            opacity: 0.5;
        }

        .package-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 15px;
        }

        .package-price {
            font-size: 2rem;
            font-weight: 800;
            color: var(--secondary-color);
            margin-bottom: 10px;
            display: flex;
            align-items: baseline;
        }

        .price-currency {
            font-size: 1.2rem;
            font-weight: 600;
            margin-right: 5px;
        }

        .package-desc {
            color: var(--dark-gray);
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .feature-list {
            margin-bottom: 30px;
            padding-left: 0;
            list-style-type: none;
        }

        .feature-list li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background-color: var(--light-gray);
            border-radius: 8px;
            transition: var(--transition);
        }

        .feature-list li:hover {
            background-color: var(--medium-gray);
            transform: translateX(5px);
        }

        .feature-list i {
            margin-right: 12px;
            color: var(--primary-color);
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-custom {
            display: block;
            width: 100%;
            padding: 15px;
            border-radius: 8px;
            font-weight: 700;
            border: none;
            transition: var(--transition);
            text-align: center;
            text-decoration: none;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .btn-secondary-custom {
            background: white;
            color: var(--primary-dark);
            border: 2px solid var(--primary-color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .btn-secondary-custom:hover {
            background: var(--light-gray);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .rating-section {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 5px;
        }

        .star {
            color: var(--secondary-color);
        }

        .rating-number {
            font-weight: 600;
            color: var(--dark-gray);
        }

        .review-count {
            color: #6c757d;
            font-size: 0.9rem;
        }

        @media (max-width: 992px) {
            .detail-container {
                flex-direction: column;
                gap: 30px;
            }
            
            .service-title {
                font-size: 1.8rem;
            }
            
            .card-box {
                padding: 25px;
            }
        }

        @media (max-width: 576px) {
            .service-title {
                font-size: 1.6rem;
            }
            
            .package-price {
                font-size: 1.6rem;
            }
            
            .btn-custom {
                padding: 12px;
            }
            
            .provider-info {
                padding: 15px;
            }
            
            .provider-info img {
                width: 50px;
                height: 50px;
            }
        }
    </style>

    <div class="container py-4">
        <a href="{{ route('dashboard') }}" class="btn-back">
            <i class="fas fa-chevron-left"></i> Kembali ke Dashboard
        </a>

        <h1 class="service-title">{{ $jasa->nama_jasa }}</h1>

        <div class="detail-container">
            <!-- Gambar Jasa -->
            <div class="image-section">
                <div class="service-category">{{ $jasa->kategori }}</div>
                <img src="{{ asset('storage/' . $jasa->gambar) }}" alt="{{ $jasa->nama_jasa }}" class="service-image">
            </div>

            <!-- Detail Informasi -->
            <div class="info-section">
                @php
                    // Modified photo path handling
                    $fotoPenyedia = optional($jasa->penyedia)->foto;
                    $namaPenyedia = optional($jasa->penyedia)->nama ?? 'Nama Penyedia';
                    
                    // Check if photo exists in storage
                    $photoExists = $fotoPenyedia && Storage::disk('public')->exists($fotoPenyedia);
                @endphp

                <div class="provider-info">
                    @if($jasa->user->photo)
                                <img src="{{ asset('storage/' . $jasa->user->photo) }}" 
                                     alt="Foto Penyedia" 
                                     class="rounded-circle shadow-sm" 
                                     width="60">
                            @else
                                <i class="fas fa-user-circle fa-3x text-secondary"></i>
                            @endif
                    <div class="provider-details">
                        <h3>{{ $jasa->user->full_name }}</h3>

                        <span class="badge">
                            <i class="fas fa-award"></i> Top Rated Seller
                        </span>
                    </div>
                </div>

                <div class="description-box">
                    <h3>Deskripsi Layanan</h3>
                    <p class="service-description">{{ $jasa->deskripsi }}</p>
                </div>

                <div class="card-box">
                    <h3 class="package-title">Harga Jasa</h3>
                    <div class="package-price">
                        <span class="price-currency">Rp</span>
                        {{ number_format($jasa->minimal_harga, 0, ',', '.') }}
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('pesanan.create', $jasa->id) }}" class="btn-custom btn-primary-custom">
                            <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                        </a>
                        <a href="{{ route('chat.show', $jasa->id) }}" class="btn-custom btn-secondary-custom">
                            <i class="fas fa-comments"></i> Chat Negosiasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/services.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dropdown menu toggle
        const userProfile = document.querySelector('.user-profile');
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        
        if (dropdownToggle) {
            dropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const dropdownMenu = userProfile.querySelector('.dropdown-menu');
                dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                const dropdownMenu = userProfile.querySelector('.dropdown-menu');
                if (dropdownMenu) {
                    dropdownMenu.style.display = 'none';
                }
            });
        }
        
        // Image hover animation effect
        const serviceImage = document.querySelector('.service-image');
        if (serviceImage) {
            serviceImage.addEventListener('mouseover', function() {
                this.style.transform = 'scale(1.02)';
            });
            
            serviceImage.addEventListener('mouseout', function() {
                this.style.transform = 'scale(1)';
            });
        }
    });
</script>
@endpush