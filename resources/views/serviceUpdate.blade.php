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

    <div class="service-container">
        <div class="service-header">
            <h1>Edit Jasa</h1>
        </div>

        <form action="{{ route('jasa.update', $jasa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nama_jasa">Nama Jasa</label>
                <input type="text" id="nama_jasa" name="nama_jasa" class="form-control" value="{{ old('nama_jasa', $jasa->nama_jasa) }}" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" required>{{ old('deskripsi', $jasa->deskripsi) }}</textarea>
            </div>

            <div class="form-group">
                <label for="minimal_harga">Harga</label>
                <input type="number" id="minimal_harga" name="minimal_harga" class="form-control" value="{{ old('minimal_harga', $jasa->minimal_harga) }}" required>
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
                <label for="gambar">Gambar (Opsional)</label>
                <input type="file" id="gambar" name="gambar" class="form-control">
            </div>

            <button type="submit" class="add-service-button">Update Jasa</button>
        </form>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/services.css') }}" rel="stylesheet">
@endpush
