@extends('layouts.app')

@section('content')
<div class="welcome-container">
    <!-- Navigation -->
    <nav class="nav-container">
        <div class="logo">
            <a href="/">TUNTAS<span class="logo-in">IN</span></a>
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
                <span class="title-main">Tuntasin: </span>
                <span class="title-sub">Satu Tempat, Tuntas Semua</span>
            </h1>
            <p>Please register to be a part of the event.</p>
            <a href="{{ route('register') }}" class="register-now-btn">Register Now</a>
        </div>
        <div class="content-right">
            <img src="{{ asset('images/CHECKLIST_REGIS.png') }}" alt="Checklist Illustration" class="illustration" style="width: 1000px; ">
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

<style>
.welcome-container {
    min-height: 100vh;
    position: relative;
    overflow: hidden;
}

.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
}

.logo {
    font-size: 2rem;
    font-weight: bold;
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.logo a {
    text-decoration: none;
    color: #0e69a1;
}

.logo-in {
    color: rgba(255, 255, 255, 0.8);
}

.nav-buttons a {
    text-decoration: none;
}

.login-btn {
    color: #0e69a1;
    font-weight: 600;
    margin-right: 1rem;
    transition: color 0.3s ease;
}

.login-btn:hover {
    color: #0077cc;
}

.register-btn {
    background: #008CFF;
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.register-btn:hover {
    background: #0077cc;
    transform: translateY(-1px);
}

.main-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 2rem;
    gap: 2rem;
}

.content-left h1 {
    font-size: 2.8rem;
    margin-bottom: 1rem;
    line-height: 1.2;
    color: #003366;
}

.title-main {
    font-weight: 700;
}

.title-sub {
    font-weight: 600;
    color: #0e69a1;
}

.content-left p {
    font-size: 1.2rem;
    color: #4a5568;
    margin-bottom: 2rem;
}

.register-now-btn {
    display: inline-block;
    padding: 1rem 2rem;
    background: #008CFF;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.register-now-btn:hover {
    background: #0077cc;
    transform: translateY(-2px);
}

.illustration {
    max-width: 100%;
    height: auto;
}

@media (max-width: 768px) {
    .main-content {
        flex-direction: column;
        text-align: center;
    }
    
    .content-left h1 {
        font-size: 2rem;
    }
}
</style>