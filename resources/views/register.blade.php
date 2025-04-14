@extends('layouts.app')

@section('content')
<div class="register-container">
    <div class="nav-container">
        <div class="logo">
            <a href="/">Tuntas<span class="logo-in">IN</span></a>
        </div>
        <div class="nav-buttons">
            <a href="{{ route('login') }}" class="login-btn">Login</a>
            <a href="{{ route('register') }}" class="register-btn">Register</a>
        </div>
    </div>
 
    <div class="form-container">
        <h1>Register Now!</h1>
        <p class="subtitle">to be a part of the event.</p>
        <p class="instruction">Fill the information carefully</p>

        <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-section">
                <h3>Personal Information</h3>
                
                <div class="form-group">
                    <label for="first_name">First name <span class="required">*</span></label>
                    <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                </div>
                
                <div class="form-group">
                    <label for="last_name">Last Name <span class="required">*</span></label>
                    <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                </div>
                
                <div class="form-group">
                    <label for="user_as">User As <span class="required">*</span></label>
                    <select id="user_as" name="user_as" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="Penyedia Jasa">Penyedia Jasa</option>
                        <option value="Pengguna Jasa">Pengguna Jasa</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="mobile_number">Mobile Number <span class="required">*</span></label>
                    <input type="text" id="mobile_number" name="mobile_number" placeholder="Enter mobile number" required>
                </div>
                
                <div class="form-group">
                    <label for="photo">Upload Photo <span class="required">*</span></label>
                    <div class="photo-upload">
                        <div class="profile-pic-placeholder"></div>
                        <div class="upload-button">Select photo</div>
                        <input type="file" id="photo" name="photo" required hidden>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="done-btn">Done</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/register.js') }}"></script>

<style>
    .register-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 1rem;
    }
    
    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .logo {
        font-weight: bold;
        font-size: 1.5rem;
    }
    
    .logo-in {
        color: #777;
    }
    
    .logo a {
        text-decoration: none;
        color: #000;
    }
    
    .register-btn {
        background: #000;
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        text-decoration: none;
    }
    
    .login-btn {
        color: #333;
        text-decoration: none;
        margin-right: 1rem;
    }
    
    h1 {
        text-align: center;
        color: #999;
        font-size: 2rem;
        margin-bottom: 0;
    }
    
    .subtitle {
        text-align: center;
        margin-top: 0;
    }
    
    .instruction {
        text-align: center;
        font-weight: bold;
        margin-bottom: 2rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
    }
    
    .form-section h3 {
        color: #555;
        border-bottom: 1px solid #eee;
        padding-bottom: 0.5rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .required {
        color: red;
    }
    
    input[type="text"],
    input[type="email"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f5f5f5;
    }
    
    .photo-upload {
        display: flex;
        align-items: center;
    }
    
    .profile-pic-placeholder {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #eee;
        margin-right: 1rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23999' d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z'/%3E%3C/svg%3E");
        background-size: 60%;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    .upload-button {
        color: #555;
        cursor: pointer;
    }
    
    .done-btn {
        display: block;
        width: 120px;
        margin: 0 auto;
        margin-top: 2rem;
        padding: 0.75rem 2rem;
        background: #000;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>
@endsection