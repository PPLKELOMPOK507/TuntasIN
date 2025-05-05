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
                    <option value="Kebersihan" {{ request('category') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                    <option value="Perbaikan" {{ request('category') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                    <option value="Rumah Tangga" {{ request('category') == 'Rumah Tangga' ? 'selected' : '' }}>Rumah Tangga</option>
                    <option value="Teknologi" {{ request('category') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                    <option value="Transformasi" {{ request('category') == 'Transformasi' ? 'selected' : '' }}>Transformasi</option>
                </select>
            </form>
        </div>

        @if(Auth::user()->role === 'Pengguna Jasa')
            <div class="tooltip-container" style="margin-right: 12px;">
                <a href="{{ route('forum') }}" class="forum-btn">
                    <i class="fas fa-users"></i>
                </a>
                <span class="tooltip-text">Forum</span>
            </div>
            <div class="tooltip-container">
                <a href="{{ route('wishlist') }}" class="wishlist-btn">❤</a>
                <span class="tooltip-text">Wishlist</span>
            </div>
        @endif
        
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
        .detail-container {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            margin-top: 30px;
        }

        .image-section {
            flex: 1 1 45%;
            min-width: 300px;
        }

        .image-section img {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .image-section img:hover {
            transform: scale(1.02);
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
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .provider-info img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .provider-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #888;
        }

        .card-box {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 25px;
            background: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .btn-custom {
            display: block;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 15px;
            border: none;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
        }

        .btn-primary-custom {
            background: #75C5F0;
            color: white;
        }

        .btn-primary-custom:hover {
            background: #75C5F0;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(78, 115, 223, 0.3);
        }

        .btn-secondary-custom {
            background: #fff;
            color: #75C5F0;
            border: 1px solid #4e73df;
        }

        .btn-secondary-custom:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-back {
            margin-bottom: 25px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            color: #333;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #e9ecef;
            color: #000;
            transform: translateX(-3px);
        }

        .service-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 15px;
        }

        .service-description {
            line-height: 1.6;
            color: #4a5568;
            margin-bottom: 20px;
        }

        .package-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 15px;
        }

        .package-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: #75C5F0;
            margin-bottom: 10px;
        }

        .package-desc {
            color: #718096;
            margin-bottom: 20px;
        }

        .feature-list {
            margin-bottom: 25px;
        }

        .feature-list li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .feature-list i {
            margin-right: 10px;
            color: #4e73df;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .detail-container {
                flex-direction: column;
                gap: 30px;
            }
            
            .service-title {
                font-size: 1.8rem;
            }
            
            .card-box {
                padding: 20px;
            }
        }
    </style>

    <div class="container py-4">
        <a href="{{ route('dashboard') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>

        <h1 class="service-title">{{ $jasa->nama_jasa }}</h1>

        <div class="detail-container">
            {{-- Gambar Jasa --}}
            <div class="image-section">
                <img src="{{ asset('storage/' . $jasa->gambar) }}" alt="{{ $jasa->nama_jasa }}" class="service-image">
            </div>

            {{-- Detail Informasi --}}
            <div class="info-section">
                @php
                    // Modified photo path handling
                    $fotoPenyedia = optional($jasa->penyedia)->foto;
                    $namaPenyedia = optional($jasa->penyedia)->nama ?? 'Nama Penyedia';
                    
                    // Check if photo exists in storage
                    $photoExists = $fotoPenyedia && Storage::disk('public')->exists($fotoPenyedia);
                @endphp

                <div class="provider-info">
                    @if($photoExists)
                        <img src="{{ asset('storage/' . $fotoPenyedia) }}" alt="Foto Penyedia">
                    @else
                        <div class="provider-placeholder">
                            <i class="fas fa-user-circle"></i>
                        </div>
                    @endif
                    <div>
                        <h3 class="mb-1" style="font-size: 1.2rem; font-weight: 600;">{{ $namaPenyedia }}</h3>
                        <span class="badge bg-warning text-dark">Top Rated Seller</span>
                    </div>
                </div>

                <div class="description-box">
                    <h3 class="mb-3" style="font-size: 1.3rem; font-weight: 600;">Deskripsi Layanan</h3>
                    <p class="service-description">{{ $jasa->deskripsi }}</p>
                </div>

                <div class="card-box">
                    <h3 class="package-title">Paket Basic</h3>
                    <div class="package-price">Rp {{ number_format($jasa->minimal_harga, 0, ',', '.') }}</div>
                    <p class="package-desc">Layanan standar sesuai deskripsi dengan kualitas terjamin.</p>

                    <ul class="feature-list">
                        <li><i class="bi bi-clock"></i> Pengerjaan dalam 3 Hari</li>
                        <li><i class="bi bi-arrow-repeat"></i> Garansi 2 Revisi</li>
                        <li><i class="bi bi-check-circle"></i> Konsultasi Gratis</li>
                        <li><i class="bi bi-shield-check"></i> Garansi Kepuasan</li>
                    </ul>

                    <a href="{{ route('pesanan.create', $jasa->id) }}" class="btn-custom btn-primary-custom">Pesan Sekarang</a>
                    <a href="#" class="btn-custom btn-secondary-custom">Hubungi Penjual</a>
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
@endpush

