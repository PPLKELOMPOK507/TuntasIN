@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <nav class="dashboard-nav">
        <div class="logo">
            <a href="/">TUNTAS<span class="logo-in">IN</span></a>
        </div>
        
        <div class="user-profile">
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->full_name }}</span>
                <div class="profile-image">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                             alt="Profile Photo">
                    @else
                        <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path fill='%23999' d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z'/></svg>" 
                             alt="Default Profile">
                    @endif
                </div>
            </div>
            <div class="dropdown-menu">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="dashboard-content">
        <h1>Welcome, {{ auth()->user()->first_name }}!</h1>
        <p>This is your dashboard. More features coming soon.</p>
    </div>
</div>

@endsection