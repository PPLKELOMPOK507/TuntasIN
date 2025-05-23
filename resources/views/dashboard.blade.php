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
            <div class="search-container">
                <input type="search" class="search-input" placeholder="Find services...">
                <button class="filter-btn">
                    <i class="fas fa-sliders-h"></i>
                </button>
            </div>
        </div>

        @if(Auth::user()->role === 'Pengguna Jasa')
            <div class="tooltip-container" style="margin-right: 12px;">
                <a href="{{ route('forum') }}" class="forum-btn">
                    <i class="fas fa-users"></i>
                </a>
                <span class="tooltip-text">Forum</span>
            </div>
        @endif

        @if(Auth::user()->role === 'Pengguna Jasa')
            <div class="tooltip-container">
                <a href="{{ route('wishlist') }}" class="wishlist-btn">❤</a>
                <span class="tooltip-text">Wishlist</span>
            </div>
        @endif

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
                <button class="dropdown-toggle"> ⌵ </button>
            </div>
            <div class="dropdown-menu">
                <a href="{{ route('profile') }}" class="menu-item">
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
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="dashboard-main">
        @if(Auth::user()->role === 'Pengguna Jasa')
            <!-- Featured Section for Pengguna Jasa -->
            <section class="featured-section">
                <h2>Available Services</h2>

                <!-- Add category filter -->
                <div class="category-filter">
                    <select id="category-select" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="service-grid">
                    @foreach($jasa as $item)
                    <div class="service-card" data-category="{{ $item->category_id }}">
                        <div class="service-image">
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_jasa }}">
                            <!-- Tambahkan tombol wishlist -->
                            <a href="{{ route('wishlist') }}" class="wishlist-heart">
                                <i class="fas fa-heart"></i>
                            </a>
                        </div>
                        <div class="service-info">
                            <!-- Info Penyedia Jasa -->                            
                            <h3 class="service-title">{{ $item->nama_jasa }}</h3>
                            <p>{{ $item->deskripsi }}</p>
                            <span class="service-price">Rp {{ number_format($item->minimal_harga, 0, ',', '.') }}</span>
                            
                            <div class="service-actions">
                                <a href="{{ route('jasa.detail', $item->id) }}" class="view-service-btn">
                                    Lihat Detail Jasa
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        @elseif(Auth::user()->role === 'Penyedia Jasa')
            <!-- Dashboard for Penyedia Jasa -->
            <div class="service-container">
                <div class="service-header">
                    <h1>Jasa Saya</h1>
                    <a href="{{ route('jasa.tambah') }}" class="add-service-button">+ Tambah Jasa</a>
                </div>

                @if($jasa->isEmpty())
                    <div class="empty-state">
                        <h2>Belum ada Jasa yang ditawarkan</h2>
                        <p>Jasa yang anda tawarkan akan muncul disini</p>
                    </div>
                @else
                    <div class="service-grid">
                        @foreach($jasa as $item)
                            <div class="service-card">
                                <div class="service-image">
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_jasa }}">
                                </div>
                                <div class="service-info">
                                    <h3 class="service-title">{{ $item->nama_jasa }}</h3>
                                    <p>{{ $item->deskripsi }}</p>
                                    <span class="service-price">Rp {{ number_format($item->minimal_harga, 0, ',', '.') }}</span>
                                </div>

                                <div class="service-actions">
                                    <a href="{{ route('jasa.edit', $item->id) }}" class="edit-btn">Edit</a>
                                    <form action="{{ route('jasa.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus jasa ini?')">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/services.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
