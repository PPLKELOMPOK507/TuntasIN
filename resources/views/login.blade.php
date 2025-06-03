@extends('layouts.app')

@section('content')
<div class="login-page">
    <div class="nav-container">
        <div class="logo">
            <a href="/">Tuntas<span class="logo-in">IN</span></a>
        </div>
    </div>

    <div class="form-container">
        <h1>Welcome Back!</h1>  
        <p class="subtitle">Login to your account</p>
        <p class="instruction">Enter your credentials</p>

        <form action="{{ route('login.submit') }}" method="POST" novalidate>
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
                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="done-btn">Login</button>
                </div>

                <p class="register-link">
                    Don't have an account? <a href="{{ route('register') }}">Register here</a>
                </p>
            </div>
        </form>
    </div>
</div>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to top, #4fbafc, #dadada);
        margin: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .login-page {
        width: 100%; /* Changed from 75rem */
        margin: auto;
        padding: 2rem 0;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .nav-container {
        width: 90%; /* Added width control */
        max-width: 1200px; /* Added max-width */
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
        max-width: 450px;
        width: 90%; /* Added width control */
        margin: auto;
        position: relative;
        top: -2rem; /* This moves the form up */
    }

    h1 {
        text-align: center;
        font-size: 2.5rem;
        color: #003366;
        margin-bottom: 0.5rem;
    }

    .subtitle {
        text-align: center;
        margin-bottom: 0.5rem;
        color: #003366;
    }

    .instruction {
        text-align: center;
        font-weight: 600;
        margin-bottom: 2rem;
        color: #003366;
    }

    .form-section {
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .required {
        color: red;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: #f9f9f9;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    input:focus {
        border-color: #008CFF;
        box-shadow: 0 0 0 2px rgba(0,140,255,0.1);
        outline: none;
    }

    .done-btn {
        display: block;
        width: 100%;
        background-color: #008CFF;
        color: #fff;
        padding: 0.75rem;
        font-size: 1.1rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        margin-top: 1rem;
        transition: all 0.3s ease;
    }

    .done-btn:hover {
        background-color: #0077cc;
        transform: translateY(-1px);
    }

    .register-link {
        text-align: center;
        margin-top: 1.5rem;
        color: #666;
    }

    .register-link a {
        color: #008CFF;
        text-decoration: none;
        font-weight: 600;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 1000px) {
        .login-page {
            padding: 1rem;
        }

        .form-container {
            padding: 2rem;
            width: 95%; /* Slightly wider on mobile */
            margin: 0 auto;
        }

        .nav-container {
            width: 95%;
        }
    }

    @media (max-width: 480px) {
        .form-container {
            padding: 1.5rem;
        }

        h1 {
            font-size: 2rem;
        }
    }
</style>
@endsection