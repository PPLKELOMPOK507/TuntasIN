<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuntasIN</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-item">
                <a href="{{ route('wishlist.index') }}" class="nav-link">
                    <i class="fas fa-heart"></i> <!-- Icon wishlist -->
                    <span class="wishlist-count">
                        {{ auth()->check() ? auth()->user()->wishlists()->count() : 0 }}
                    </span>
                </a>
            </div>
        </div>
    </nav>

    @yield('content')
</body>
</html>
