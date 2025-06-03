@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Detail Refund</h2>
    <div class="card shadow-sm mx-auto" style="padding: 2rem; margin-bottom: 2rem; max-width: 100%; width: 100%; max-width: 600px;">
        <div class="mb-3">
            <p><strong>Nama Pembeli:</strong> {{ $refund->user->full_name ?? $refund->user->email }}</p>
            <p><strong>Jasa:</strong> {{ $refund->pemesanan->jasa->nama_jasa ?? '-' }}</p>
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
            <p><strong>Alasan Refund:</strong> {{ $refund->reason }}</p>
            @if($refund->bukti_refund)
                <p><strong>Bukti Refund:</strong><br>
                    <img src="{{ asset('storage/' . $refund->bukti_refund) }}" alt="Bukti Refund" style="max-width:100%; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                </p>
            @endif
        </div>

        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mt-4" style="flex-direction: column; align-items: stretch;">
            <a href="{{ route('sales.history') }}" class="btn btn-secondary mb-2 w-100">
                <i class="fas fa-arrow-left"></i> Kembali ke Detail Penjualan
            </a>
            @if($refund->status === 'pending' && empty($refund->provider_response))
                <div class="d-flex gap-2 w-100" style="justify-content: center;">
                    <form action="{{ route('provider.refunds.response', ['id' => $refund->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="response" value="accepted">
                        <button type="submit" class="btn btn-success" 
                            onclick="return confirm('Terima refund dan teruskan ke admin?')">
                            <i class="fas fa-check"></i> Accept
                        </button>
                    </form>
                    
                    <form action="{{ route('provider.refunds.response', ['id' => $refund->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="response" value="rejected">
                        <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Yakin ingin menolak refund ini?')">
                            <i class="fas fa-times"></i> Reject
                        </button>
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
            flex-direction: column !!important;
            gap: 0.5rem !important;
        }
    }
</style>
@endpush