@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Section Kiri - Informasi Pembayaran -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Pembayaran #{{ $payment->payment_reference }}</h5>
                </div>
                
                <div class="card-body">
                    <div class="info-section mb-4">
                        <h6 class="border-bottom pb-2">Status Pembayaran</h6>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-{{ $payment->status === 'awaiting_verification' ? 'warning text-dark' : ($payment->status === 'completed' ? 'success' : 'danger') }} me-2">
                                {{ ucfirst($payment->status) }}
                            </span>
                            <small class="text-muted">Updated: {{ $payment->updated_at->format('d M Y H:i') }}</small>
                        </div>
                    </div>

                    <div class="info-section mb-4">
                        <h6 class="border-bottom pb-2">Detail Transaksi</h6>
                        <p class="mb-2"><strong>Jasa:</strong> {{ $payment->pemesanan->jasa->nama_jasa }}</p>
                        <p class="mb-2"><strong>Pembeli:</strong> {{ $payment->pemesanan->user->full_name ?? $payment->pemesanan->user->name }}</p>
                        <p class="mb-2"><strong>Penyedia Jasa:</strong> {{ $payment->pemesanan->jasa->user->full_name ?? $payment->pemesanan->jasa->user->name }}</p>
                        <p class="mb-2"><strong>Total:</strong> <span class="text-primary">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span></p>
                        <p class="mb-2"><strong>Metode Pembayaran:</strong> {{ ucfirst($payment->payment_method) }}</p>
                        <p class="mb-2"><strong>Tanggal:</strong> {{ $payment->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <!-- Catatan Admin jika sudah diverifikasi -->
                    @if($payment->admin_notes)
                    <div class="info-section">
                        <h6 class="border-bottom pb-2">Catatan Admin</h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-1">{{ $payment->admin_notes }}</p>
                            <small class="text-muted">Diverifikasi pada: {{ $payment->verified_at?->format('d M Y H:i') }}</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Section Kanan - Bukti & Verifikasi -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Bukti & Verifikasi</h5>
                </div>
                
                <div class="card-body">
                    <!-- Bukti Pembayaran -->
                    <div class="info-section mb-4">
                        <h6 class="border-bottom pb-2">Bukti Pembayaran</h6>
                        <div class="bukti-wrapper">
                            @if($payment->bukti_pembayaran)
                                <img src="{{ asset('storage/'.$payment->bukti_pembayaran) }}" 
                                     class="img-fluid rounded shadow-sm" 
                                     alt="Bukti Pembayaran">
                            @else
                                <div class="text-center p-4 bg-light rounded">
                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Bukti pembayaran tidak tersedia</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Form Verifikasi -->
                    @if($payment->status === 'awaiting_verification')
                    <div class="review-section p-4 bg-light rounded">
                        <h6 class="border-bottom pb-2 mb-3">Verifikasi Pembayaran</h6>
                        <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label"><strong>Catatan Admin (Opsional)</strong></label>
                                <textarea name="admin_notes" class="form-control" rows="3" 
                                    placeholder="Tulis catatan verifikasi di sini...">{{ old('admin_notes') }}</textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="status" value="completed" class="btn btn-success">
                                    <i class="fas fa-check-circle"></i> Terima Pembayaran
                                </button>
                                <button type="submit" name="status" value="declined" class="btn btn-danger">
                                    <i class="fas fa-times-circle"></i> Tolak Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-3">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-bottom: none;
    padding: 1.25rem;
}

.info-section {
    background: #ffffff;
    border-radius: 10px;
    padding: 1.25rem;
}

.info-section h6 {
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 1rem;
}

.bukti-wrapper {
    background: #f8fafc;
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
}

.bukti-wrapper img {
    max-height: 400px;
    width: 100%;
    object-fit: contain;
}

.review-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
}

.form-control {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.75rem;
}

.form-control:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.badge {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 500;
}

@media (max-width: 768px) {
    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection