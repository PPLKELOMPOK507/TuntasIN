@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <nav class="nav-container">
        <div class="logo">
            @auth
                <a href="{{ route('dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
            @else
                <a href="/">TUNTAS<span class="logo-in">IN</span></a>
            @endauth
        </div>
    </nav>

    {{-- Form Tambah Jasa --}}
    <div class="service-container">
        <div class="service-header">
            <h1>Tambah Jasa</h1>
            <a href="{{ route('services') }}" class="add-service-button">← Kembali</a>
        </div>

        <form action="{{ route('jasa.store') }}" method="POST" enctype="multipart/form-data" class="add-service-form">
            @csrf

            <div class="form-group">
                <label for="nama_jasa">Nama Jasa</label>
                <input type="text" name="nama_jasa" id="nama_jasa" value="{{ old('nama_jasa') }}" required>
                @error('nama_jasa')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="minimal_harga">Minimal Harga (Rp)</label>
                <input type="number" name="minimal_harga" id="minimal_harga" value="{{ old('minimal_harga') }}" min="0" required>
                @error('minimal_harga')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori Jasa</label>
                <select name="kategori" id="kategori" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="Kebersihan">Kebersihan</option>
                    <option value="Perbaikan">Perbaikan</option>
                    <option value="Rumah Tangga">Rumah Tangga</option>
                    <option value="Teknologi">Teknologi</option>
                    <option value="Transportasi">Transportasi</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Jasa</label>
                <input type="file" name="gambar" id="gambar" accept="image/*" required>
                @error('gambar')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="add-service-button">Simpan Jasa</button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('css/services.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
