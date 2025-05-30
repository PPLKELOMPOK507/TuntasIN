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

                        <button type="submit" class="btn btn-primary w-100">
                            Bayar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('css/payment.css') }}" rel="stylesheet">
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

// Form submission handler
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
    if (!selectedMethod) {
        Swal.fire({
            title: 'Peringatan',
            text: 'Silakan pilih metode pembayaran',
            icon: 'warning',
            confirmButtonColor: '#2563eb'
        });
        return;
    }

    Swal.fire({
        title: 'Konfirmasi Pembayaran',
        text: 'Apakah Anda yakin akan melakukan pembayaran?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#d1d5db',
        confirmButtonText: 'Ya, Bayar Sekarang',
        cancelButtonText: 'Batalkan'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Pembayaran Diproses!',
                        text: 'Pembayaran sedang diverifikasi oleh admin',
                        icon: 'success',
                        confirmButtonColor: '#2563eb'
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: error.message || 'Terjadi kesalahan saat memproses pembayaran',
                    icon: 'error',
                    confirmButtonColor: '#2563eb'
                });
            });
        }
    });
});
</script>
@endpush
@endsection