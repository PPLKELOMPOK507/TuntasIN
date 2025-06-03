@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Detail Refund (Admin)</h2>
    <div class="card shadow-sm mx-auto" style="padding: 2rem; margin-bottom: 2rem; max-width: 100%; width: 100%; max-width: 600px;">
        <div class="mb-3">
            <p><strong>Nama Pembeli:</strong> {{ $refund->user->full_name ?? $refund->user->email }}</p>
            <p><strong>Jasa:</strong> {{ $refund->pemesanan->jasa->nama_jasa ?? '-' }}</p>
            <p><strong>Penyedia Jasa:</strong> {{ $refund->pemesanan->jasa->user->email ?? '-' }}</p>
            <p><strong>Tanggal Pengajuan:</strong> {{ $refund->created_at->format('d M Y H:i') }}</p>
            <p><strong>Status Refund:</strong>
                <span class="badge 
                    @if($refund->status === 'pending') bg-warning text-dark
                    @elseif($refund->status === 'rejected') bg-danger
                    @elseif($refund->status === 'accepted' || $refund->status === 'approved') bg-success
                    @else bg-secondary
                    @endif
                ">
                    {{ ucfirst($refund->status) }}
                </span>
            </p>
            <p><strong>Provider Response:</strong>
                @if($refund->provider_response === 'accepted')
                    <span class="badge bg-success">Accepted</span>
                @elseif($refund->provider_response === 'rejected')
                    <span class="badge bg-danger">Rejected</span>
                @else
                    <span class="badge bg-secondary">Belum Ditanggapi</span>
                @endif
            </p>
            <p><strong>Alasan Refund:</strong> {{ $refund->reason }}</p>
            @if($refund->bukti_refund)
                <p><strong>Bukti Refund:</strong><br>
                    <img src="{{ asset('storage/' . $refund->bukti_refund) }}" alt="Bukti Refund" style="max-width:100%; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                </p>
            @endif
        </div>

        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mt-4" style="flex-direction: column; align-items: stretch;">
            <a href="{{ route('manage') }}" class="btn btn-secondary mb-2 w-100">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Refund
            </a>
            
            {{-- Form ACC/Decline untuk admin selama belum diputuskan oleh admin --}}
            @if($refund->status === 'pending' || !in_array($refund->status, ['approved', 'rejected']))
                <div class="d-flex gap-2 w-100" style="justify-content: center;">
                    <form action="{{ route('admin.refunds.review', $refund->id) }}" method="POST" style="display:inline; width:100%;">
                        @csrf
                        <input type="hidden" name="review" id="review_action" value="">
                        
                        {{-- Info Provider Response --}}
                        <div class="alert @if($refund->provider_response === 'accepted') alert-info @else alert-warning @endif mb-3">
                            <strong>Tanggapan Penyedia Jasa:</strong> 
                            @if($refund->provider_response === 'accepted')
                                Penyedia jasa menyetujui refund. <br>
                                <small>Sebagai admin, Anda perlu memverifikasi apakah persetujuan ini valid.</small>
                            @elseif($refund->provider_response === 'rejected')
                                Penyedia jasa menolak refund. <br>
                                <small>Sebagai admin, Anda perlu memverifikasi apakah penolakan ini beralasan. Jika tidak beralasan, Anda dapat meng-override keputusan penyedia.</small>
                            @else
                                Penyedia jasa belum menanggapi. <br>
                                <small>Mohon tunggu tanggapan dari penyedia jasa terlebih dahulu.</small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">
                                <strong>Catatan Admin (wajib):</strong>
                                @if($refund->provider_response === 'accepted')
                                    <small class="text-muted">Jelaskan alasan verifikasi/penolakan Anda terhadap persetujuan refund dari penyedia</small>
                                @elseif($refund->provider_response === 'rejected') 
                                    <small class="text-muted">Jelaskan alasan Anda menyetujui refund (override) atau membenarkan penolakan dari penyedia</small>
                                @else
                                    <small class="text-muted">Mohon tunggu tanggapan penyedia jasa</small>
                                @endif
                            </label>
                            <textarea name="admin_notes" id="admin_notes" class="form-control @error('admin_notes') is-invalid @enderror" 
                                required rows="3" placeholder="Tulis alasan keputusan Anda...">{{ old('admin_notes') }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alert untuk response penyedia --}}
                        @if($refund->provider_response === 'rejected')
                            <div class="alert alert-warning mb-3">
                                <strong>Penyedia Jasa Menolak Refund</strong><br>
                                <small>Sebagai admin, Anda perlu memverifikasi apakah penolakan ini beralasan:
                                    <ul>
                                        <li>Klik "Override Penolakan & Setujui Refund" jika penolakan tidak beralasan</li>
                                        <li>Klik "Setuju dengan Penolakan Penyedia" jika penolakan sudah benar</li>
                                    </ul>
                                </small>
                            </div>
                        @endif

                        {{-- Tombol aksi admin --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success w-100" 
                                onclick="document.getElementById('review_action').value='approved';">
                                <i class="fas fa-check"></i> 
                                @if($refund->provider_response === 'rejected')
                                    Override Penolakan & Setujui Refund
                                @else
                                    Setujui Refund
                                @endif
                            </button>
                            <button type="submit" class="btn btn-danger w-100" 
                                onclick="document.getElementById('review_action').value='rejected';">
                                <i class="fas fa-times"></i>
                                @if($refund->provider_response === 'rejected')
                                    Setuju dengan Penolakan Penyedia
                                @else
                                    Tolak Refund
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            @elseif($refund->status === 'approved' || $refund->status === 'rejected')
                <div class="alert @if($refund->status === 'approved') alert-success @else alert-danger @endif">
                    Refund telah {{ $refund->status === 'approved' ? 'disetujui' : 'ditolak' }} oleh admin dengan catatan: {{ $refund->admin_notes }}
                </div>
            @endif
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