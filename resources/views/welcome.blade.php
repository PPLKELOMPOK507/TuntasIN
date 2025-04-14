@extends('layouts.app')

@section('content')
<div class="welcome-container">
    <!-- Navigation -->
    <nav class="nav-container">
        <div class="logo">
            <a href="/">Tuntas<span class="logo-in">IN</span></a>
        </div>
        <div class="nav-buttons">
            <a href="{{ route('login') }}" class="login-btn">Login</a>
            <a href="{{ route('register') }}" class="register-btn">Register</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-left">
            <h1>
                <span class="title-main">TuntasIN:</span>
                <span class="title-sub">Satu Tempat, Semua Beres.</span>
            </h1>
            <p>Please register to be a part of the event!</p>
            <a href="{{ route('register') }}" class="register-now-btn">Register Now</a>
        </div>
        <div class="content-right">
            <img src="http://localhost/TuntasIN/public/images/CHECKLIST_REGIS.png" alt="Checklist Illustration" class="illustration">
        </div>
    </div>

    <!-- Wave Background -->
    <div class="wave-container">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" class="wave-svg">
            <path fill="#f5f5f5" fill-opacity="1" d="M0,160L48,170.7C96,181,192,203,288,197.3C384,192,480,160,576,165.3C672,171,768,213,864,224C960,235,1056,213,1152,186.7C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</div>
@endsection