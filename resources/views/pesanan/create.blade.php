@extends('layouts.app')

@section('content')
<!-- Navbar -->
<nav class="nav-container">
    <div class="logo">
        <a href="{{ route('dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
    </div>
</nav>

<div class="container py-5">
    <!-- Tombol Kembali yang Baru -->
    <div class="mb-5">
        <a href="{{ route('dashboard') }}" class="back-button">
            <span class="back-button-circle">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="back-button-text">Kembali ke Dashboard</span>
        </a>
    </div>

    <div class="row gx-5">
        <!-- Bagian Kiri - Gambar dan Deskripsi -->
        <div class="col-lg-7 mb-4">
            <h1 class="service-title mb-4">{{ $jasa->nama_jasa }}</h1>
            
            <!-- Gambar Jasa -->
            <div class="image-section mb-4">
                <img src="{{ asset('storage/' . $jasa->gambar) }}" 
                     alt="{{ $jasa->nama_jasa }}" 
                     class="service-image">
            </div>
            
            <!-- Deskripsi Jasa -->
            <div class="description-box bg-white p-4 rounded-lg shadow-sm">
                <h4 class="mb-3 fw-bold">Deskripsi Layanan</h4>
                <p class="text-muted lh-lg">{{ $jasa->deskripsi }}</p>
                <div class="mt-4 pt-3 border-top">
                    <p class="mb-2"><strong>Harga Mulai Dari:</strong></p>
                    <h5 class="text-primary">Rp {{ number_format($jasa->minimal_harga, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>

        <!-- Bagian Kanan - Form Pemesanan -->
        <div class="col-lg-5">
            <div class="card-box bg-white rounded-lg shadow p-4 sticky-top" style="top: 2rem;">
                <!-- Info Penyedia Jasa -->
                <div class="provider-info p-3 mb-4 bg-light rounded-lg">
                    <div class="d-flex align-items-center">
                        <div class="provider-avatar me-3">
                            @if($jasa->user->photo)
                                <img src="{{ asset('storage/' . $jasa->user->photo) }}" 
                                     alt="Foto Penyedia" 
                                     class="rounded-circle shadow-sm" 
                                     width="60">
                            @else
                                <i class="fas fa-user-circle fa-3x text-secondary"></i>
                            @endif
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">{{ $jasa->user->full_name }}</h5>
                            <span class="badge bg-success">Penyedia Jasa Terpercaya</span>
                        </div>
                    </div>
                </div>

                <!-- Form Pemesanan -->
                <form action="{{ route('pesanan.store', $jasa->id) }}" method="POST">
                    @csrf
                    
                    <!-- Input Harga -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Masukkan Penawaran Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" 
                                   name="custom_price" 
                                   class="form-control @error('custom_price') is-invalid @enderror" 
                                   value="{{ old('custom_price') }}"
                                   placeholder="Masukkan harga penawaran Anda"
                                   required>
                        </div>
                        @error('custom_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Berikan harga terbaik Anda!</small>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tanggal Mulai Pengerjaan</label>
                        <input type="date" 
                               name="tanggal_mulai" 
                               class="form-control @error('tanggal_mulai') is-invalid @enderror"
                               min="{{ date('Y-m-d') }}" 
                               value="{{ old('tanggal_mulai') }}"
                               required>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Catatan Tambahan</label>
                        <textarea name="catatan" 
                                 class="form-control @error('catatan') is-invalid @enderror" 
                                 rows="4" 
                                 placeholder="Deskripsikan kebutuhan Anda secara detail...">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary w-100 py-3 mt-3">
                        <i class="fas fa-arrow-right me-2"></i>
                        Lanjutkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Navbar Styles */
    .nav-container {
        display: flex;
        align-items: center;
        padding: 1rem 2rem;
        background: linear-gradient(to right, #2563eb, #1d4ed8);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .logo {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .logo a {
        text-decoration: none;
        color: white;
    }

    .logo-in {
        color: #93c5fd;
    }

    .service-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: #1e40af;
        line-height: 1.2;
    }
    
    .image-section {
        width: 100%;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    .service-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }
    
    .description-box {
        border-radius: 16px;
        line-height: 1.6;
        background-color: white;
        border-left: 5px solid #2563eb;
    }
    
    .provider-info {
        border-left: 5px solid #2563eb; /* Ubah ke biru */
        background-color: #f0f7ff !important;
        border: 1px solid #dbeafe;
    }
    
    .form-control {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        font-size: 1rem;
    }
    
    .form-control:focus {
        border-color: #2563eb; /* Ubah ke biru */
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25); /* Ubah ke biru dengan opacity */
    }
    
    .btn-primary {
        background-color: #2563eb; /* Ubah ke biru */
        border: none;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #1d4ed8; /* Ubah ke biru yang lebih gelap */
        transform: translateY(-2px);
    }
    
    .sticky-top {
        z-index: 1020;
    }

    @media (max-width: 991.98px) {
        .sticky-top {
            position: relative !important;
            top: 0 !important;
        }
        
        .service-image {
            height: 300px;
        }
        
        .service-title {
            font-size: 1.75rem;
        }
    }

    /* Style untuk tombol kembali */
    .back-button {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 8px 5px;
    }

    .back-button:hover {
        transform: translateX(-5px);
    }

    .back-button-circle {
        background: linear-gradient(145deg, #2563eb, #1d4ed8); /* Ubah ke gradien biru */
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2); /* Ubah ke biru dengan opacity */
        transition: all 0.3s ease;
    }

    .back-button:hover .back-button-circle {
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3); /* Ubah ke biru dengan opacity */
        transform: scale(1.05);
    }

    .back-button-circle i {
        color: white;
        font-size: 1rem;
    }

    .back-button-text {
        color: #2d3436;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .back-button:hover .back-button-text {
        color: #2563eb; /* Ubah ke biru */
    }

    /* Animasi hover */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }

    .back-button:hover .back-button-circle {
        animation: pulse 1s infinite;
    }

    /* Badge untuk Penyedia Jasa */
    .badge.bg-success {
        background-color: #2563eb !important; /* Ubah ke biru */
    }

    /* Text Primary untuk harga */
    .text-primary {
        color: #2563eb !important; /* Ubah ke biru */
    }

    /* Hover effects */
    .back-button:hover {
        color: #2563eb; /* Ubah ke biru */
    }

    .provider-info {
        border-left: 5px solid #2563eb; /* Ubah ke biru */
        background-color: #f0f5ff !important; /* Tambah background biru muda */
    }

    /* Input group text */
    .input-group-text {
        background-color: #2563eb; /* Ubah ke biru */
        color: white;
        border: none;
    }

    /* Small text muted hover */
    .text-muted:hover {
        color: #2563eb !important; /* Ubah ke biru */
    }

    /* Additional hover effects */
    .card-box {
        transition: transform 0.3s ease;
    }
    
    .card-box:hover {
        transform: translateY(-5px);
    }
    
    /* Container adjustment for better spacing */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .nav-container {
            padding: 1rem;
        }
        
        .logo {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('css/services.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script>
    function updatePriceQty(qty) {
        let quantity = parseInt(qty);
        if (isNaN(quantity) || quantity < 1) quantity = 1;
        const pricePerItem = {{ $jasa->harga }};
        const total = pricePerItem * quantity;
        document.getElementById('hidden_price').value = total;
        document.getElementById('quantity').value = quantity;
        document.getElementById('continue-btn').innerText = `Pembayaran (Rp ${new Intl.NumberFormat('id-ID').format(total)})`;
    }
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInput = document.getElementById('quantity');
        qtyInput.addEventListener('input', function() {
            updatePriceQty(this.value);
        });
    });
</script>
@endpush