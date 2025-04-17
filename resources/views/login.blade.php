@extends('layouts.app')

@section('content')
<div class="login-container">
    <nav class="nav-container">
        <div class="logo">
            <a href="/">TUNTAS<span class="logo-in">IN</span></a>
        </div>
        <div class="nav-buttons">
            <a href="{{ route('login') }}" class="login-btn">Login</a>
            <a href="{{ route('register') }}" class="register-btn">Register</a>
        </div>
    </nav>

    <div class="form-container">
        <h1>Welcome Back!</h1>
        <p class="subtitle">Login to your account</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <button type="submit" class="login-submit-btn">Login</button>
            </div>

            <p class="register-link">
                Don't have an account? <a href="{{ route('register') }}">Register here</a>
            </p>
        </form>
    </div>
</div>
@endsection