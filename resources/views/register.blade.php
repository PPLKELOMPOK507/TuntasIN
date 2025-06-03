@extends('layouts.app')

@section('content')
<div class="register-page">
    <div class="nav-container">
        <div class="logo">
            <a href="/">Tuntas<span class="logo-in">IN</span></a>
        </div>
    </div>

    <div class="form-container">
        <h1>Register Now!</h1>
        <p class="subtitle">To be a part of the event</p>
        <p class="instruction">Fill the information carefully</p>

        <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data" novalidate>
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
                    <label for="first_name">First Name <span class="required">*</span></label>
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
                    <label for="photo">Upload Photo</label>
                    <div class="photo-upload">
                        <div class="profile-pic-placeholder"></div>
                        <div class="upload-button">Select photo</div>
                        <input type="file" id="photo" name="photo" hidden>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="done-btn">Register</button>
                </div>

                <p class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Login here</a>
                </p>
            </div>
        </form>
    </div>
</div>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<script src="{{ asset('js/register.js') }}"></script>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to top, #4fbafc, #dadada);
        margin: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .register-page {
        width: 100%;
        margin: 0 auto;
        padding: 2rem 0;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .nav-container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto 2rem auto;
    }

    .logo {
        font-size: 2rem;
        font-weight: bold;
        color: white;
        text-shadow: 2px 2px 4px #00000047;
        -webkit-text-stroke: 1px rgba(0, 0, 0, 0.465);
    }

    .logo a {
        text-decoration: none;
        color: #0e69a1;
    }

    .logo-in {
        color: #ffffffcc;
    }

    .form-container {
        background-color: #ffffff;
        padding: 2.5rem 3rem;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        max-width: 500px; /* Reduced from 800px to match login form */
        width: 90%;
        margin: 0 auto;
        position: relative;
        top: -2rem;
        margin-bottom: 4rem;
    }

    .form-section {
        padding: 2rem;
        background: #f8fafc;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .form-section h3 {
        border-left: 3px solid #008CFF;
        padding-left: 0.75rem;
        color: #003366;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
        width: 100%; /* Make form groups full width */
    }

    /* Remove the two-column layout */
    @media (min-width: 768px) {
        .form-section .form-group {
            width: 100%;
            display: block;
            margin-right: 0;
        }
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .required {
        color: red;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: #f9f9f9;
        font-size: 1rem;
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
        color: #0077cc;
        font-weight: 500;
        cursor: pointer;
    }

    .done-btn {
        background-color: #008CFF;
        color: #fff;
        padding: 1rem;
        font-size: 1.1rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        width: 100%;
        margin-top: 2rem;
        transition: all 0.3s ease;
    }

    .done-btn:hover {
        background-color: #0077cc;
        transform: translateY(-2px);
    }

    /* Remove nav buttons styles since we're removing them */
    .nav-buttons {
        display: none;
    }

    /* Style for login link */
    .login-link {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 1.1rem;
    }

    .login-link a {
        color: #008CFF;
        text-decoration: none;
        font-weight: 600;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 1000px) {
        .form-container {
            max-width: 90%;
            padding: 2rem;
        }
    }
</style>
@endsection
