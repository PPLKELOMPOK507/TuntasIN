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
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
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
                    <a href="{{ route('account.balance') }}" class="menu-item account-balance">
                        <i class="fas fa-wallet wallet-icon"></i>
                        <span>My Account Balance</span>
                    </a>
                @endif

                 @if(Auth::user()->role === 'Pengguna Jasa')
                    <a href="{{ route('purchases.history') }}" class="menu-item">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Riwayat Pembelian</span>
                    </a>
                @endif

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
                <div class="service-grid">
                    @forelse($jasa as $item)
                        <div class="service-card" data-category="{{ $item->category_id }}">
                            <div class="service-image">
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_jasa }}">
                                @php
                                    $isWishlisted = Auth::user()->wishlists ? in_array($item->id, Auth::user()->wishlists->pluck('service_id')->toArray()) : false;
                                @endphp
                                
                                @if($isWishlisted)
                                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="wishlist-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="wishlist-btn active">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('wishlist.add', $item->id) }}" method="POST" class="wishlist-form">
                                        @csrf
                                        <button type="submit" class="wishlist-btn">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div class="service-info">
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
                    @empty
                        <p>Tidak ada jasa ditemukan.</p>
                    @endforelse
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
    <style>
        .account-balance {
            border-top: 1px solid #eaeaea;
            border-bottom: 1px solid #eaeaea;
            padding: 12px 15px;
        }
        
        .account-balance i {
            color: #808080;
        }
        
        .account-balance span {
            font-weight: 500;
        }
    </style>

@endpush
