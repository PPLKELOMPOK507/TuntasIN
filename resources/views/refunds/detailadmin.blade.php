@extends('layouts.app')

@section('content')
<div class="container">
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
                    @elseif($refund->status === 'declined') bg-danger
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
                @elseif($refund->provider_response === 'declined')
                    <span class="badge bg-danger">Declined</span>
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
            @if($refund->status === 'pending' && $refund->provider_response === 'accepted')
                <div class="d-flex gap-2 w-100" style="justify-content: center;">
                    <form action="{{ route('admin.refunds.review', $refund->id) }}" method="POST" style="display:inline; width:100%;">
                        @csrf
                        <input type="hidden" name="review" id="review_action" value="">
                        <div class="mb-2">
                            <label for="admin_notes" class="form-label"><strong>Catatan Admin (wajib):</strong></label>
                            <textarea name="admin_notes" id="admin_notes" class="form-control" required rows="2" placeholder="Tulis alasan atau catatan ACC/Decline"></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success w-100" onclick="document.getElementById('review_action').value='approved'; return confirm('ACC refund ini?')">
                                <i class="fas fa-check"></i> ACC
                            </button>
                            <button type="submit" class="btn btn-danger w-100" onclick="document.getElementById('review_action').value='rejected'; return confirm('Tolak refund ini?')">
                                <i class="fas fa-times"></i> Decline
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    @media (max-width: 600px) {
        .card.shadow-sm {
            padding: 1rem !important;
        }
        .btn, .btn.w-100 {
            width: 100% !important;
            margin-bottom: 0.5rem;
        }
        .d-flex.gap-2.w-100 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
    }
</style>
@endpush