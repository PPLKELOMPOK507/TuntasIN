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
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile Photo">
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