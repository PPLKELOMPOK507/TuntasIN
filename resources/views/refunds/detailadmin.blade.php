@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Detail Refund (Admin)</h2>
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
                            <p class="mb-2"><strong>Nama Pembeli:</strong> {{ $refund->user->full_name ?? $refund->user->name }}</p>
                            <p class="mb-2"><strong>Jasa:</strong> {{ $refund->pemesanan->jasa->nama_jasa ?? '-' }}</p>
                            <p class="mb-2"><strong>Penyedia Jasa:</strong> {{ $refund->pemesanan->jasa->user->full_name ?? $refund->pemesanan->jasa->user->name }}</p>
                            <p class="mb-2"><strong>Tanggal Pengajuan:</strong> {{ $refund->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="info-group mb-4">
                        <h6 class="border-bottom pb-2 mb-3">Status</h6>
                        <div class="d-flex gap-3 mb-3">
                            <div class="status-item">
                                <label class="text-muted">Status Refund</label>
                                <span class="badge status-badge 
                                    @if($refund->status === 'pending') bg-warning text-dark
                                    @elseif($refund->status === 'declined') bg-danger
                                    @elseif($refund->status === 'accepted' || $refund->status === 'approved') bg-success
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($refund->status) }}
                                </span>
                            </div>
                            <div class="status-item">
                                <label class="text-muted">Tanggapan Penyedia</label>
                                <span class="badge 
                                    @if($refund->provider_response === 'accepted') bg-success
                                    @elseif($refund->provider_response === 'declined') bg-danger
                                    @else bg-secondary
                                    @endif">
                                    {{ $refund->provider_response ? ucfirst($refund->provider_response) : 'Belum Ditanggapi' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="info-group">
                        <h6 class="border-bottom pb-2 mb-3">Alasan Refund</h6>
                        <p class="reason-text">{{ $refund->reason }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Bukti Refund & Actions -->
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

                    @if($refund->status === 'pending' && $refund->provider_response === 'accepted')
                        <div class="action-section mt-4">
                            <form action="{{ route('admin.refunds.review', $refund->id) }}" 
                                  method="POST" 
                                  id="reviewForm">
                                @csrf
                                <input type="hidden" name="review" id="review_action">
                                <div class="mb-3">
                                    <label for="admin_notes" class="form-label">
                                        <strong>Catatan Admin</strong> <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="admin_notes" 
                                              id="admin_notes" 
                                              class="form-control @error('admin_notes') is-invalid @enderror" 
                                              required 
                                              rows="3"
                                              placeholder="Tulis catatan verifikasi...">{{ old('admin_notes') }}</textarea>
                                    @error('admin_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-success" onclick="confirmReview('approved')">
                                        <i class="fas fa-check"></i> Setujui Refund
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="confirmReview('rejected')">
                                        <i class="fas fa-times"></i> Tolak Refund
                                    </button>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('manage') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                                    </a>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
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

/* Status Badges */
.status-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 0.5rem;
    border-left: 4px solid #e2e8f0;
}

.status-item label {
    color: #64748b;
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

/* Form Elements */
textarea.form-control {
    border: 2px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 1rem;
    transition: all 0.3s ease;
}

textarea.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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
function confirmReview(action) {
    const adminNotes = document.getElementById('admin_notes').value.trim();
    
    if (!adminNotes) {
        Swal.fire({
            title: 'Peringatan',
            text: 'Catatan admin harus diisi',
            icon: 'warning'
        });
        return;
    }

    Swal.fire({
        title: action === 'approved' ? 'Setujui Refund?' : 'Tolak Refund?',
        text: action === 'approved' 
            ? 'Saldo penyedia jasa akan berkurang sesuai jumlah refund' 
            : 'Refund akan ditolak',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: action === 'approved' ? '#28a745' : '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: action === 'approved' ? 'Ya, Setuju' : 'Ya, Tolak',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('review_action').value = action;
            document.getElementById('reviewForm').submit();
        }
    });
}
</script>
@endpush