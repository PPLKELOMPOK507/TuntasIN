@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Review Refund #{{ $refund->id }}</h5>
                    <span class="badge bg-{{ $refund->status === 'pending' ? 'warning' : ($refund->status === 'approved' ? 'success' : 'danger') }}">
                        {{ ucfirst($refund->status) }}
                    </span>
                </div>
                
                <div class="card-body">
                    <!-- Informasi Pesanan -->
                    <div class="mb-4">
                        <h6>Detail Pesanan</h6>
                        <p class="mb-1">Jasa: {{ $refund->pemesanan->jasa->nama_jasa }}</p>
                        <p class="mb-1">Pengguna: {{ $refund->user->name }}</p>
                        <p class="mb-1">Penyedia: {{ $refund->pemesanan->jasa->user->name }}</p>
                        <p class="mb-1">Total: Rp {{ number_format($refund->pemesanan->total_price, 0, ',', '.') }}</p>
                        <p class="mb-1">Tanggal Pengajuan: {{ $refund->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <!-- Alasan Refund -->
                    <div class="mb-4">
                        <h6>Alasan Refund</h6>
                        <p>{{ $refund->reason }}</p>
                    </div>

                    <!-- Bukti Refund -->
                    @if($refund->bukti_refund)
                    <div class="mb-4">
                        <h6>Bukti Pendukung</h6>
                        <img src="{{ Storage::url($refund->bukti_refund) }}" class="img-fluid rounded">
                    </div>
                    @endif

                    <!-- Tanggapan Penyedia Jasa -->
                    @if($refund->provider_response)
                    <div class="mb-4">
                        <h6>Tanggapan Penyedia Jasa</h6>
                        <p>{{ $refund->provider_response }}</p>
                        <small class="text-muted">Ditanggapi pada: {{ $refund->provider_responded_at->format('d M Y H:i') }}</small>
                    </div>
                    @endif

                    <!-- Form Review Admin -->
                    @if(!$refund->admin_reviewed_at)
                    <form action="{{ route('admin.refunds.review', $refund->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Status Refund</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">Pilih Status</option>
                                <option value="approved">Setujui Refund</option>
                                <option value="rejected">Tolak Refund</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Admin</label>
                            <textarea name="admin_notes" class="form-control @error('admin_notes') is-invalid @enderror" rows="4" required>{{ old('admin_notes') }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Review</button>
                    </form>
                    @else
                    <div class="mb-4">
                        <h6>Review Admin</h6>
                        <p>{{ $refund->admin_notes }}</p>
                        <small class="text-muted">Direview pada: {{ $refund->admin_reviewed_at->format('d M Y H:i') }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tombol Kembali -->
<div class="text-center mt-3">
    <a href="{{ route('manage') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>
@endsection