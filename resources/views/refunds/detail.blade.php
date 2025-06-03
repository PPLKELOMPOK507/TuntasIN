@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Detail Refund</h2>
    <div class="row">
        <!-- Left Column - Information -->
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Informasi Refund</h5>
                </div>
                <div class="card-body">
                    <div class="info-group mb-4">
                        <h6 class="border-bottom pb-2 mb-3">Detail Pemesanan</h6>
                        <div class="mb-3">
                            <p class="mb-2"><strong>Nama Pembeli:</strong> {{ $refund->user->full_name ?? $refund->user->email }}</p>
                            <p class="mb-2"><strong>Jasa:</strong> {{ $refund->pemesanan->jasa->nama_jasa ?? '-' }}</p>
                            <p class="mb-2"><strong>Penyedia Jasa:</strong> {{ $refund->pemesanan->jasa->user->full_name ?? $refund->pemesanan->jasa->user->name }}</p>
                            <p class="mb-2"><strong>Tanggal Pengajuan:</strong> {{ $refund->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="info-group mb-4">
                        <h6 class="border-bottom pb-2 mb-3">Status Refund</h6>
                        <span class="badge status-badge fs-6 
                            @if($refund->status === 'pending') bg-warning text-dark
                            @elseif($refund->status === 'rejected') bg-danger
                            @elseif($refund->status === 'accepted' || $refund->status === 'approved') bg-success
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($refund->status) }}
                        </span>
                    </div>

                    <div class="info-group">
                        <h6 class="border-bottom pb-2 mb-3">Alasan Refund</h6>
                        <p class="reason-text">{{ $refund->reason }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Bukti & Actions -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Bukti Refund</h5>
                </div>
                <div class="card-body">
                    @if($refund->bukti_refund)
                        <div class="bukti-wrapper mb-4">
                            <img src="{{ asset('storage/' . $refund->bukti_refund) }}" 
                                 alt="Bukti Refund" 
                                 class="img-fluid rounded bukti-image">
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-image text-muted fa-3x mb-3"></i>
                            <p class="text-muted">Tidak ada bukti refund</p>
                        </div>
                    @endif

                    @if($refund->status === 'pending' && empty($refund->provider_response))
                        <div class="action-section mt-4">
                            <div class="d-grid gap-2">
                                <form action="{{ route('provider.refunds.response', $refund->id) }}" 
                                      method="POST" 
                                      id="acceptForm" 
                                      class="d-inline">
                                    @csrf
                                    <input type="hidden" name="response" value="accepted">
                                    <button type="button" class="btn btn-success w-100" onclick="confirmAccept()">
                                        <i class="fas fa-check"></i> Accept
                                    </button>
                                </form>
                                <form action="{{ route('provider.refunds.response', $refund->id) }}" 
                                      method="POST" 
                                      id="rejectForm" 
                                      class="d-inline">
                                    @csrf
                                    <input type="hidden" name="response" value="rejected">
                                    <button type="button" class="btn btn-danger w-100" onclick="confirmReject()">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </form>
                                <a href="{{ route('sales.history') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center mt-4">
                            <a href="{{ route('sales.history') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
/* Card Styling */
.card {
    border: none;
    border-radius: 0.75rem;
    background: linear-gradient(to bottom, #ffffff, #f8fafc);
}

.card-header {
    padding: 1.25rem;
    background: linear-gradient(to right, #f1f5f9, #f8fafc);
    border-bottom: 2px solid #e2e8f0;
}

.card-header h5 {
    color: #1e293b;
    font-weight: 600;
}

/* Info Groups */
.info-group {
    padding: 1rem;
    background: #ffffff;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.info-group h6 {
    color: #334155;
    font-weight: 600;
}

/* Status Badge */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
}

/* Reason Text */
.reason-text {
    background: #f1f5f9;
    padding: 1.25rem;
    border-radius: 0.5rem;
    border-left: 4px solid #2563eb;
    color: #334155;
    margin: 0;
}

/* Image Section */
.bukti-wrapper {
    position: relative;
    border-radius: 0.75rem;
    overflow: hidden;
    background: #f1f5f9;
    padding: 0.5rem;
    border: 2px dashed #e2e8f0;
}

.bukti-image {
    width: 100%;
    height: auto;
    object-fit: contain;
    max-height: 400px;
    border-radius: 0.5rem;
}

/* Action Section */
.action-section {
    border-top: 2px solid #e2e8f0;
    padding-top: 1.5rem;
    margin-top: 1.5rem;
    background: linear-gradient(to bottom, #ffffff, #f8fafc);
}

/* Buttons */
.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-success {
    background: linear-gradient(to right, #059669, #047857);
    border: none;
}

.btn-danger {
    background: linear-gradient(to right, #dc2626, #b91c1c);
    border: none;
}

.btn-secondary {
    background: linear-gradient(to right, #64748b, #475569);
    border: none;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .col-md-7, .col-md-5 {
        padding: 0 0.5rem;
    }
    
    .card {
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmAccept() {
    Swal.fire({
        title: 'Konfirmasi Terima Refund',
        text: "Apakah Anda yakin ingin menerima pengajuan refund ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Terima',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('acceptForm').submit();
        }
    });
}

function confirmReject() {
    Swal.fire({
        title: 'Konfirmasi Tolak Refund',
        text: "Apakah Anda yakin ingin menolak pengajuan refund ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('rejectForm').submit();
        }
    });
}
</script>
@endpush