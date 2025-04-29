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
        
        <!-- User Profile -->
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
                <a href="{{ route('services') }}" class="menu-item active">
                    <i class="fas fa-briefcase"></i>
                    <span>Jasa Saya</span>
                </a>
                <a href="{{ route('sales.history') }}" class="menu-item">
                    <i class="fas fa-history"></i>
                    <span>Riwayat Penjualan</span>
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

    <!-- Jasa Saya Section -->
    <div class="service-container">
        <div class="service-header">
            <h1>Jasa saya</h1>
            <div>
                <a href="{{ route('jasa.tambah') }}" class="add-service-button">+ Tambah Jasa</a>
            </div>
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
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_jasa }}" class="service-image">
                        </div>
                        <div class="service-info">
                            <h3 class="service-title">{{ $item->nama_jasa }}</h3>
                            <p>{{ $item->deskripsi }}</p>
                            <span class="service-price">Rp {{ number_format($item->minimal_harga, 0, ',', '.') }}</span>
                        </div>

                        <!-- Tombol Edit -->
                        <div class="service-actions">
                            <a href="{{ route('jasa.edit', $item->id) }}" class="edit-btn">Edit</a>

                            <!-- Tombol Hapus -->
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
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/services.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
