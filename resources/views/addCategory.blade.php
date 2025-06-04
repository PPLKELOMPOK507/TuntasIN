@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <nav class="nav-container">
        <div class="logo">
            <a href="{{ route('manage') }}">TUNTAS<span class="logo-in">IN</span></a>
        </div>
        
        <div class="user-profile">
            <div class="user-info">
                <div class="profile-image">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile">
                    @else
                        <div class="profile-placeholder"></div>
                    @endif
                </div>
                <span class="admin-label">Administrator</span>
            </div>
            <div class="dropdown-menu">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="content-container">
        <div class="category-header">
            <a href="{{ route('manage') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
            
            <div class="header-content">
                <h1>Tambah Kategori</h1>
            </div>
            <div></div> <!-- Empty div for grid alignment -->
        </div>

        <div class="form-container">
            <form action="{{ route('manage.categories.store') }}" method="POST" class="add-category-form">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Kategori <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <small class="error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('manage') }}" class="cancel-btn">Batal</a>
                    <button type="submit" class="submit-btn">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endpush
@endsection