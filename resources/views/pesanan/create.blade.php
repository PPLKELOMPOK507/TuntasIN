@extends('layouts.app')

@section('content')
<div class="container py-4">
    <a href="{{ route('dashboard') }}" class="btn-back mb-3">
        <i class="fas fa-chevron-left"></i> Kembali ke Dashboard
    </a>
    <h1 class="service-title mb-4">{{ $jasa->nama_jasa }}</h1>
    <div class="row detail-container align-items-start">
        <!-- Gambar Jasa -->
        <div class="col-lg-6 mb-4 d-flex justify-content-center">
            <div class="image-section shadow" style="background:#fff; border-radius:12px; padding:20px;">
                <img src="{{ asset('storage/' . $jasa->gambar) }}" alt="{{ $jasa->nama_jasa }}" class="service-image w-100 rounded shadow">
            </div>
        </div>
        <!-- Form Pemesanan -->
        <div class="col-lg-6 d-flex align-items-center">
            <div class="card-box bg-white rounded shadow-sm p-4 w-100">
                <form action="{{ route('pesanan.store', $jasa->id) }}" method="POST">
                    @csrf
                    <input type="hidden" id="hidden_price" name="price" value="{{ $jasa->harga }}">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Masukan Jumlah Pesanan</label>
                        <div class="input-group">
                            <span class="input-group-text">Qty</span>
                            <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" oninput="updatePriceQty(this.value)">
                        </div>
                        <small class="text-muted">Minimal: 1</small>
                    </div>
                    <div class="mb-4">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label for="catatan" class="form-label">Catatan Tambahan</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Berikan detail tentang kebutuhan Anda"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-3 fs-5" id="continue-btn">
                        Pembayaran
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .detail-container {
        display: flex;
        flex-wrap: wrap;
        gap: 40px;
        align-items: flex-start;
    }
    .image-section {
        min-width: 320px;
        max-width: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .service-image {
        width: 100%;
        max-width: 350px;
        max-height: 400px;
        object-fit: cover;
        border-radius: 12px;
    }
    .card-box {
        margin-top: 0;
        box-shadow: 0 4px 24px rgba(24, 138, 208, 0.08);
        border: none;
        width: 100%;
        max-width: 420px;
        margin-left: auto;
        margin-right: auto;
    }
    @media (max-width: 991px) {
        .detail-container {
            flex-direction: column;
            gap: 24px;
        }
        .image-section, .card-box {
            max-width: 100%;
        }
    }
</style>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('css/services.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .service-title { font-size: 2rem; font-weight: bold; color: #333; }
    .btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 8px; border: none; background: #fff; color: #188ad0; font-weight: 600; text-decoration: none; margin-bottom: 20px; }
    .btn-back:hover { background: #188ad0; color: #fff; }
    .detail-container { display: flex; flex-wrap: wrap; gap: 40px; }
    .image-section { min-width: 300px; }
    .service-image { width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px; }
    .provider-info { border-left: 5px solid #ff9f43; }
    .description-box { margin-top: 20px; }
    .card-box {
        margin-top: 30px;
        box-shadow: 0 4px 24px rgba(24, 138, 208, 0.08);
        border: none;
    }
    .card-box form {
        max-width: 420px;
        margin: 0 auto;
    }
    .btn-success {
        background: linear-gradient(90deg, #188ad0 0%, #4fbafc 100%);
        border: none;
        font-weight: 700;
        letter-spacing: 1px;
        transition: background 0.2s;
    }
    .btn-success:hover {
        background: linear-gradient(90deg, #4fbafc 0%, #188ad0 100%);
    }
    .input-group-text {
        background: #f5f7fa;
        font-weight: 600;
        color: #188ad0;
    }
    .form-label {
        font-size: 1rem;
        margin-bottom: 6px;
    }
    .form-control {
        font-size: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #e4e6ef;
        background: #f9fbfd;
    }
    .form-control:focus {
        border-color: #188ad0;
        background: #fff;
        box-shadow: 0 0 0 2px #4fbafc33;
    }
    @media (max-width: 991px) {
        .card-box form {
            max-width: 100%;
        }
    }
</style>
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