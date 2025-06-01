@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ajukan Refund</h5>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('refunds.store', $pemesanan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Jasa</label>
                            <input type="text" class="form-control" value="{{ $pemesanan->jasa->nama_jasa }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Jasa</label>
                            <textarea class="form-control" rows="3" readonly>{{ $pemesanan->jasa->deskripsi }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alasan Refund</label>
                            <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" rows="4" required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bukti Pendukung</label>
                            <input type="file" name="bukti_refund" class="form-control @error('bukti_refund') is-invalid @enderror" required>
                            @error('bukti_refund')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Ajukan Refund</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection