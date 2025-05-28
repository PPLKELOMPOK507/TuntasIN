@extends('layouts.app')

@section('content')
<!-- Navbar -->
<nav class="nav-container">
    <div class="logo">
        <a href="{{ route('dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
    </div>
</nav>

<div class="container py-5">
    <!-- Tombol Kembali -->
    <div class="mb-5">
        <a href="{{ route('dashboard') }}" class="back-button">
            <span class="back-button-circle">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="back-button-text">Kembali ke Dashboard</span>
        </a>
    </div>

    <div class="row gx-5">
        <!-- Kolom Kiri - Detail Pesanan -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4">Detail Pesanan</h4>
                    
                    <div class="order-info mb-4">
                        <div class="service-info p-3 bg-light rounded mb-4">
                            <h6 class="fw-bold mb-3">Informasi Jasa</h6>
                            <p class="mb-2"><strong>Nama Jasa:</strong><br>{{ $pemesanan->jasa->nama_jasa }}</p>
                            <p class="mb-2"><strong>Penyedia:</strong><br>{{ $pemesanan->jasa->user->full_name }}</p>
                        </div>

                        <div class="order-notes p-3 bg-light rounded">
                            <h6 class="fw-bold mb-3">Catatan Pemesanan</h6>
                            <p class="mb-0">{{ $pemesanan->catatan ?: 'Tidak ada catatan' }}</p>
                        </div>
                    </div>

                    <!-- Price Summary -->
                    <div class="price-details mt-4">
                        <h6 class="fw-bold mb-3">Ringkasan Pembayaran</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Harga Jasa</span>
                            <span id="service-price" data-price="{{ $pemesanan->harga }}">
                                Rp {{ number_format($pemesanan->harga, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Biaya Admin</span>
                            <span id="admin-fee" class="text-primary">Rp 0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total Pembayaran</span>
                            <span id="total-tagihan" class="text-primary fs-5">
                                Rp {{ number_format($pemesanan->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan - Form Pembayaran -->
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4">Metode Pembayaran</h4>
                    
                    <form action="{{ route('payment.process', $pemesanan->id) }}" method="POST">
                        @csrf
                        <div class="payment-options mb-4">
                            <!-- Credit Card -->
                            <div class="payment-method-item">
                                <input type="radio" name="payment_method" value="credit_card" id="credit_card" class="payment-radio" required>
                                <label for="credit_card" class="payment-method-label">
                                    <div class="payment-icon-wrapper">
                                        <img src="https://img.icons8.com/color/48/visa.png" alt="Credit Card">
                                    </div>
                                    <div class="payment-info">
                                        <span class="payment-name">Kartu Kredit</span>
                                        <span class="payment-desc">Visa, Mastercard, JCB</span>
                                    </div>
                                    <div class="payment-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </label>
                            </div>

                            <!-- Bank Transfer -->
                            <div class="payment-method-item">
                                <input type="radio" name="payment_method" value="bank_transfer" id="bank_transfer" class="payment-radio">
                                <label for="bank_transfer" class="payment-method-label">
                                    <div class="payment-icon-wrapper">
                                        <img src="https://img.icons8.com/color/48/bank.png" alt="Bank Transfer">
                                    </div>
                                    <div class="payment-info">
                                        <span class="payment-name">Transfer Bank</span>
                                        <span class="payment-desc">BCA, BNI, Mandiri, BRI</span>
                                    </div>
                                    <div class="payment-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </label>
                            </div>

                            <!-- E-Wallet -->
                            <div class="payment-method-item">
                                <input type="radio" name="payment_method" value="e_wallet" id="e_wallet" class="payment-radio">
                                <label for="e_wallet" class="payment-method-label">
                                    <div class="payment-icon-wrapper">
                                        <img src="https://img.icons8.com/color/48/google-pay.png" alt="E-Wallet">
                                    </div>
                                    <div class="payment-info">
                                        <span class="payment-name">E-Wallet</span>
                                        <span class="payment-desc">GoPay, OVO, DANA, LinkAja</span>
                                    </div>
                                    <div class="payment-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </label>
                            </div>

                            <!-- QRIS -->
                            <div class="payment-method-item">
                                <input type="radio" name="payment_method" value="qris" id="qris" class="payment-radio">
                                <label for="qris" class="payment-method-label">
                                    <div class="payment-icon-wrapper">
                                        <img src="https://img.icons8.com/color/48/qr-code.png" alt="QRIS">
                                    </div>
                                    <div class="payment-info">
                                        <span class="payment-name">QRIS</span>
                                        <span class="payment-desc">Scan untuk pembayaran instan</span>
                                    </div>
                                    <div class="payment-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Detail Sections -->
                        <div id="payment-details" class="mt-4">
                            <!-- Bank Transfer Options -->
                            <div id="bank-options" class="payment-detail-section" style="display: none;">
                                <h6 class="mb-3">Pilih Bank</h6>
                                <div class="bank-list mb-4">
                                    <div class="form-check mb-2">
                                        <input type="radio" name="bank_name" value="bca" id="bca" class="form-check-input" onchange="showBankDetails('bca')">
                                        <label for="bca" class="form-check-label">BCA</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="radio" name="bank_name" value="bni" id="bni" class="form-check-input" onchange="showBankDetails('bni')">
                                        <label for="bni" class="form-check-label">BNI</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="radio" name="bank_name" value="mandiri" id="mandiri" class="form-check-input" onchange="showBankDetails('mandiri')">
                                        <label for="mandiri" class="form-check-label">Mandiri</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="radio" name="bank_name" value="bri" id="bri" class="form-check-input" onchange="showBankDetails('bri')">
                                        <label for="bri" class="form-check-label">BRI</label>
                                    </div>
                                </div>

                                <!-- Virtual Account Info -->
                                <div id="va-details" class="va-info p-4 rounded" style="display: none;">
                                    <div class="text-center mb-4">
                                        <h6 class="fw-bold mb-1">Virtual Account Number</h6>
                                        <div class="va-number-container">
                                            <span id="va-number" class="va-number">-</span>
                                            <button type="button" class="btn-copy" onclick="copyVANumber()">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="payment-instructions mt-4">
                                        <h6 class="fw-bold mb-3">Cara Pembayaran:</h6>
                                        <div id="payment-steps" class="steps-container">
                                            <!-- Steps will be inserted here -->
                                        </div>
                                    </div>

                                    <div class="payment-notes mt-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-clock text-warning me-2"></i>
                                            <small>Selesaikan pembayaran dalam <span class="fw-bold">24 jam</span></small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle text-info me-2"></i>
                                            <small>Pembayaran akan diverifikasi oleh Admin</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Credit Card Details -->
                            <div id="card-details" class="payment-detail-section" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Kartu</label>
                                    <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Kadaluarsa</label>
                                    <input type="text" name="card_expiry" class="form-control" placeholder="MM/YY">
                                </div>
                            </div>

                            <!-- QRIS Code -->
                            <div id="qris-code" class="payment-detail-section" style="display: none;">
                                <div class="qris-container">
                                    <div class="qris-wrapper">
                                        <img src="{{ asset('images/QRCode.png') }}" 
                                             alt="QRIS Code" 
                                             class="qris-image">
                                        <div class="qris-info">
                                            <h5 class="mb-3">Pembayaran QRIS</h5>
                                            <p class="text-muted mb-3">Scan QR code menggunakan aplikasi e-wallet atau m-banking Anda</p>
                                            <div class="qris-amount">
                                                <span>Total Pembayaran:</span>
                                                <span class="amount" id="qris-total">Rp {{ number_format($pemesanan->harga, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- E-Wallet Details -->
                            <div id="ewallet-details" class="payment-detail-section" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Ponsel</label>
                                    <input type="tel" name="phone_number" class="form-control" placeholder="08xxxxxxxxxx">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 mt-4">
                            Bayar Sekarang
                        </button>
                    </form>
                </div>
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

/* Back Button Styles */
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
    background: linear-gradient(145deg, #2563eb, #1d4ed8);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
    transition: all 0.3s ease;
}

.back-button:hover .back-button-circle {
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
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
    color: #2563eb;
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

/* Responsive Design */
@media (max-width: 768px) {
    .nav-container {
        padding: 1rem;
    }
    
    .logo {
        font-size: 1.5rem;
    }
}

/* Tambahkan style yang diperlukan */
.payment-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.payment-method-item {
    position: relative;
    border: 2px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.payment-method-item:hover {
    border-color: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.payment-method-label {
    display: flex;
    align-items: center;
    gap: 1rem;
    cursor: pointer;
}

.payment-icon {
    width: 48px;
    height: 48px;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.payment-method-item:hover .payment-icon {
    transform: scale(1.1);
}

.payment-method-item input[type="radio"] {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.payment-method-item input[type="radio"]:checked + label .payment-icon {
    transform: scale(1.1);
}

.payment-method-item input[type="radio"]:checked + label {
    color: #2563eb;
}

.payment-method-item input[type="radio"]:checked {
    border-color: #2563eb;
    background-color: #2563eb;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .payment-methods {
        grid-template-columns: 1fr;
    }
    
    .payment-icon {
        width: 36px;
        height: 36px;
    }
}

.payment-options {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.payment-method-item {
    position: relative;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    transition: all 0.3s ease;
    overflow: hidden;
}

.payment-method-item:hover {
    border-color: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
}

.payment-radio {
    display: none;
}

.payment-method-label {
    display: flex;
    align-items: center;
    padding: 1.25rem;
    cursor: pointer;
    width: 100%;
    gap: 1rem;
}

.payment-icon-wrapper {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    border-radius: 8px;
    padding: 0.5rem;
}

.payment-icon-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.payment-info {
    flex: 1;
}

.payment-name {
    display: block;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.payment-desc {
    display: block;
    font-size: 0.875rem;
    color: #64748b;
}

.payment-check {
    font-size: 1.25rem;
    color: #2563eb;
    opacity: 0;
    transition: all 0.3s ease;
}

.payment-radio:checked + .payment-method-label {
    background-color: #f0f7ff;
}

.payment-radio:checked + .payment-method-label .payment-check {
    opacity: 1;
}

.payment-radio:checked + .payment-method-label .payment-name {
    color: #2563eb;
}

.order-info {
    font-size: 0.95rem;
}

.price-details {
    font-size: 0.95rem;
}

/* Responsive adjustments */
@media (max-width: 991.98px) {
    .payment-method-label {
        padding: 1rem;
    }
    
    .payment-icon-wrapper {
        width: 40px;
        height: 40px;
    }
}

.va-info {
    background-color: #f8fafc;
    border: 2px dashed #e2e8f0;
}

.va-number-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.va-number {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2563eb;
    letter-spacing: 1px;
}

.btn-copy {
    background: none;
    border: none;
    color: #64748b;
    padding: 0.25rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-copy:hover {
    color: #2563eb;
    transform: scale(1.1);
}

.steps-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.step-item {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.step-number {
    background: #2563eb;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.step-content {
    flex: 1;
    font-size: 0.95rem;
    color: #4b5563;
}

/* Bank title style */
.bank-title {
    font-size: 2rem;
    font-weight: 600;
    color: #2563eb;
    margin-bottom: 1.5rem;
}

/* QRIS container style */
.qris-container {
    background: #f8fafc;
    border: 2px dashed #e2e8f0;
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
}

.qris-wrapper {
    max-width: 400px;
    margin: 0 auto;
}

.qris-image {
    width: 200px; /* Ukuran lebih kecil */
    height: 200px; /* Ukuran lebih kecil */
    object-fit: contain;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.qris-image:hover {
    transform: scale(1.02);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .qris-image {
        width: 180px;
        height: 180px;
    }
}

/* Card and Container Styles */
.card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
}

.card-body {
    padding: 2rem !important;
}

/* Detail Section Styles */
.service-info, 
.order-notes {
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    background-color: #f8fafc !important;
}

/* Payment Method Styles */
.payment-method-item {
    border: 1.5px solid #e5e7eb;
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.payment-method-item:hover {
    border-color: #2563eb;
}

.payment-method-item.selected {
    border-color: #2563eb;
    background-color: #f0f7ff;
}

/* Bank Options Styles */
.bank-list .form-check {
    border: 1.5px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1rem;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
}

.bank-list .form-check:hover {
    border-color: #2563eb;
    background-color: #f8fafc;
}

.bank-list .form-check-input:checked + .form-check-label {
    color: #2563eb;
}

/* VA Details Styles */
.va-info {
    border: 2px dashed #e2e8f0;
    border-radius: 1rem;
    background-color: #f8fafc;
}

/* QRIS Container Styles */
.qris-container {
    border: 2px dashed #e2e8f0;
    border-radius: 1rem;
    background-color: #f8fafc;
}

/* Input Fields Styles */
.form-control {
    border: 1.5px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
}

.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
}

/* Submit Button Styles */
.btn-primary {
    border-radius: 0.75rem;
    border: none;
    background: linear-gradient(to right, #2563eb, #1d4ed8);
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 8px -1px rgba(37, 99, 235, 0.3);
}

/* Sweet Alert Custom Styles */
.swal2-popup-custom {
    padding: 2rem;
}

.swal2-confirm-large {
    padding: 1.2rem 2rem !important;
    font-size: 1.1rem !important;
    font-weight: 600 !important;
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2) !important;
    transform: scale(1.05);
}

.swal2-cancel-small {
    padding: 0.8rem 1.5rem !important;
    font-size: 0.9rem !important;
    font-weight: normal !important;
    opacity: 0.8;
}

.swal2-confirm-large:hover {
    transform: scale(1.1) !important;
    box-shadow: 0 6px 8px -1px rgba(37, 99, 235, 0.3) !important;
}

.swal2-cancel-small:hover {
    opacity: 1;
}

/* Progress bar customization */
.swal2-timer-progress-bar {
    background: #2563eb !important;
}

/* Popup animation */
.swal2-show {
    animation: popup 0.3s ease-out;
}

@keyframes popup {
    0% {
        transform: scale(0.9);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}
</style>

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bankOptions = document.getElementById('bank-options');
    const cardDetails = document.getElementById('card-details');
    const qrisCode = document.getElementById('qris-code');
    const ewalletDetails = document.getElementById('ewallet-details');
    const servicePriceElement = document.getElementById('service-price');
    const adminFeeElement = document.getElementById('admin-fee');
    const totalTagihanElement = document.getElementById('total-tagihan');

    const servicePrice = parseInt(servicePriceElement.dataset.price) || 0;

    function calculateAdminFee(method) {
        const fees = {
            'credit_card': 10000,
            'bank_transfer': 5000,
            'e_wallet': 3000,
            'qris': 2000
        };
        return fees[method] || 0;
    }

    function updatePaymentDetails(method) {
        const adminFee = calculateAdminFee(method);
        const total = servicePrice + adminFee;

        adminFeeElement.textContent = `Rp ${adminFee.toLocaleString('id-ID')}`;
        totalTagihanElement.textContent = `Rp ${total.toLocaleString('id-ID')}`;

        // Hide all payment details
        [bankOptions, cardDetails, qrisCode, ewalletDetails].forEach(el => {
            if (el) el.style.display = 'none';
        });

        // Show relevant payment details
        switch (method) {
            case 'bank_transfer':
                bankOptions.style.display = 'block';
                break;
            case 'credit_card':
                cardDetails.style.display = 'block';
                break;
            case 'qris':
                qrisCode.style.display = 'block';
                break;
            case 'e_wallet':
                ewalletDetails.style.display = 'block';
                break;
        }
    }

    // Add event listeners to payment method radios
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            updatePaymentDetails(e.target.value);
        });
    });
});

function showBankDetails(bank) {
    const vaDetails = document.getElementById('va-details');
    const vaNumber = document.getElementById('va-number');
    const paymentSteps = document.getElementById('payment-steps');
    
    // Show VA details section
    vaDetails.style.display = 'block';
    
    // Generate VA number berdasarkan bank
    const vaPrefix = {
        bca: '126',
        bni: '988',
        mandiri: '885',
        bri: '776'
    };
    
    // Generate random VA number dengan prefix bank
    const randomDigits = Math.floor(Math.random() * 100000000).toString().padStart(8, '0');
    const generatedVA = `${vaPrefix[bank]}${randomDigits}`;
    vaNumber.textContent = generatedVA;
    
    // Set payment steps
    const steps = getBankSteps(bank);
    paymentSteps.innerHTML = steps.map((step, index) => `
        <div class="step-item">
            <div class="step-number">${index + 1}</div>
            <div class="step-content">${step}</div>
        </div>
    `).join('');
}

function getBankSteps(bank) {
    const steps = {
        bca: [
            'Buka aplikasi BCA Mobile',
            'Pilih m-BCA',
            'Pilih m-Transfer',
            'Pilih BCA Virtual Account',
            'Masukkan nomor Virtual Account',
            'Konfirmasi detail pembayaran',
            'Masukkan PIN m-BCA'
        ],
        bni: [
            'Buka aplikasi BNI Mobile',
            'Pilih Transfer',
            'Pilih Virtual Account Billing',
            'Masukkan nomor Virtual Account',
            'Konfirmasi detail pembayaran',
            'Masukkan Password'
        ],
        mandiri: [
            'Buka aplikasi Livin\' by Mandiri',
            'Pilih Bayar',
            'Pilih Virtual Account',
            'Masukkan nomor Virtual Account',
            'Periksa detail transaksi',
            'Masukkan PIN'
        ],
        bri: [
            'Buka aplikasi BRImo',
            'Pilih Pembayaran',
            'Pilih Virtual Account',
            'Masukkan nomor Virtual Account',
            'Konfirmasi detail pembayaran',
            'Masukkan PIN BRImo'
        ]
    };
    
    return steps[bank] || [];
}

function copyVANumber() {
    const vaNumber = document.getElementById('va-number').textContent;
    navigator.clipboard.writeText(vaNumber).then(() => {
        // Show toast or notification
        alert('Nomor VA berhasil disalin!');
    });
}

// Modifikasi event listener form submit
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Konfirmasi Pembayaran',
        text: 'Apakah Anda yakin akan melakukan pembayaran?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#d1d5db', // Warna abu-abu untuk tombol Tidak
        confirmButtonText: '<span style="font-size: 1.1rem; padding: 0.5rem 1rem;">Ya, Bayar Sekarang</span>',
        cancelButtonText: '<span style="font-size: 0.9rem;">Tidak, Kembali</span>',
        customClass: {
            confirmButton: 'swal2-confirm-large',
            cancelButton: 'swal2-cancel-small',
            popup: 'swal2-popup-custom'
        },
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika user memilih Ya
            Swal.fire({
                title: 'Pembayaran Berhasil!',
                text: 'Pembayaran akan diverifikasi oleh Admin',
                icon: 'success',
                confirmButtonColor: '#2563eb',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "{{ route('dashboard') }}";
            });

            this.submit();
        } else {
            // Jika user memilih Tidak
            window.location.href = "{{ route('dashboard') }}";
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ...existing code...

    // Update form submit handler
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Apakah Anda yakin akan melakukan pembayaran?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: '<span style="font-size: 1.1rem; padding: 0.5rem 1rem;">Ya, Bayar Sekarang</span>',
                cancelButtonText: '<span style="font-size: 0.9rem;">Tidak, Kembali</span>',
                customClass: {
                    confirmButton: 'swal2-confirm-large',
                    cancelButton: 'swal2-cancel-small',
                    popup: 'swal2-popup-custom'
                },
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form using fetch
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            Swal.fire({
                                title: 'Pembayaran Berhasil!',
                                text: 'Pembayaran akan diverifikasi oleh Admin',
                                icon: 'success',
                                confirmButtonColor: '#2563eb',
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('dashboard') }}";
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat memproses pembayaran',
                            icon: 'error',
                            confirmButtonColor: '#2563eb'
                        });
                    });
                } else {
                    // Stay on current page if canceled
                    return false;
                }
            });
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Tampilkan konfirmasi pembayaran
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Apakah Anda yakin akan melakukan pembayaran?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: '<span style="font-size: 1.1rem; padding: 0.5rem 1rem;">Ya, Bayar Sekarang</span>',
                cancelButtonText: '<span style="font-size: 0.9rem;">Tidak, Kembali</span>',
                customClass: {
                    confirmButton: 'swal2-confirm-large',
                    cancelButton: 'swal2-cancel-small',
                    popup: 'swal2-popup-custom'
                },
                reverseButtons: true,
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user memilih Ya
                    const formData = new FormData(form);
                    
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Tampilkan notifikasi sukses
                            Swal.fire({
                                title: 'Pembayaran Berhasil!',
                                text: 'Pembayaran akan diverifikasi oleh Admin',
                                icon: 'success',
                                confirmButtonColor: '#2563eb',
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then(() => {
                                // Redirect ke dashboard setelah notifikasi hilang
                                window.location.href = "{{ route('dashboard') }}";
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat memproses pembayaran',
                            icon: 'error',
                            confirmButtonColor: '#2563eb'
                        });
                    });
                }
            });
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Apakah Anda yakin akan melakukan pembayaran?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Ya, Bayar Sekarang',
                cancelButtonText: 'Tidak, Kembali',
                reverseButtons: true,
                allowOutsideClick: false,
                showLoaderOnConfirm: true,
                customClass: {
                    confirmButton: 'swal2-confirm-large',
                    cancelButton: 'swal2-cancel-small',
                    popup: 'swal2-popup-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Pembayaran Berhasil!',
                        text: 'Pembayaran akan diverifikasi oleh Admin',
                        icon: 'success',
                        confirmButtonColor: '#2563eb',
                        timerProgressBar: true,
                        showConfirmButton: true, // Menambahkan tombol konfirmasi
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then(() => {
                        window.location.href = "{{ route('dashboard') }}";
                    });
                    
                    // Submit form jika user klik "Ya"
                    this.submit();
                }
            });
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Apakah Anda yakin akan melakukan pembayaran?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Ya, Bayar Sekarang',
                cancelButtonText: 'Tidak, Kembali',
                reverseButtons: true,
                allowOutsideClick: false,
                customClass: {
                    confirmButton: 'swal2-confirm-large',
                    cancelButton: 'swal2-cancel-small',
                    popup: 'swal2-popup-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Pembayaran Berhasil!',
                        text: 'Pembayaran akan diverifikasi oleh Admin',
                        icon: 'success',
                        confirmButtonColor: '#2563eb',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then(() => {
                        window.location.href = "{{ route('dashboard') }}";
                    });
                    // Jika ingin submit ke backend, aktifkan baris berikut:
                    // form.submit();
                }
                // Jika user memilih Tidak, tidak terjadi apa-apa (tetap di halaman)
            });
        });
    }
});
</script>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Apakah Anda yakin akan melakukan pembayaran?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Ya, Bayar Sekarang',
                cancelButtonText: 'Tidak, Kembali',
                reverseButtons: true,
                allowOutsideClick: false,
                customClass: {
                    confirmButton: 'swal2-confirm-large',
                    cancelButton: 'swal2-cancel-small',
                    popup: 'swal2-popup-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Pembayaran Berhasil!',
                        text: 'Pembayaran akan diverifikasi oleh Admin',
                        icon: 'success',
                        confirmButtonColor: '#2563eb',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then(() => {
                        window.location.href = "{{ route('dashboard') }}";
                    });
                    // Jika ingin submit ke backend, aktifkan baris berikut:
                    // form.submit();
                }
                // Jika user memilih Tidak, tidak terjadi apa-apa (tetap di halaman)
            });
        });
    }
});
</script>
@endpush
@endpush
@endsection