@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Refund #{{ $refund->id }}</h5>
                </div>
                
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Informasi Pesanan</h6>
                        <p class="mb-1">Jasa: {{ $refund->pemesanan->jasa->nama_jasa }}</p>
                        <p class="mb-1">Pengguna: {{ $refund->user->name }}</p>
                        <p class="mb-1">Tanggal Pengajuan: {{ $refund->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div class="mb-4">
                        <h6>Alasan Refund</h6>
                        <p>{{ $refund->reason }}</p>
                    </div>

                    @if($refund->bukti_refund)
                    <div class="mb-4">
                        <h6>Bukti Pendukung</h6>
                        <img src="{{ Storage::url($refund->bukti_refund) }}" class="img-fluid rounded">
                    </div>
                    @endif

                    @if(!$refund->provider_response)
                    <form action="{{ route('provider.refunds.response', $refund->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tanggapan Anda</label>
                            <textarea name="response" class="form-control @error('response') is-invalid @enderror" rows="4" required>{{ old('response') }}</textarea>
                            @error('response')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Tanggapan</button>
                    </form>
                    @else
                    <div class="mb-4">
                        <h6>Tanggapan Anda</h6>
                        <p>{{ $refund->provider_response }}</p>
                        <small class="text-muted">Dikirim pada: {{ $refund->provider_responded_at->format('d M Y H:i') }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection