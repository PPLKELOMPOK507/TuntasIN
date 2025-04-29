<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUNTASIN - Logo Design Service</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        
        body {
            background-color: #f9fafb;
            color: #374151;
            line-height: 1.5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        /* Navigation */
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #e5e7eb;
            background-color: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .logo a {
            text-decoration: none;
            color: #1f2937;
        }
        
        .logo-in {
            color: #3b82f6;
        }
        
        /* Category Navigation */
        .category-nav {
            position: sticky;
            top: 4rem;
            z-index: 9;
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 0;
        }
        
        .category-scroll {
            display: flex;
            overflow-x: auto;
            gap: 1.5rem;
            padding: 0 1rem;
            scrollbar-width: none;
        }
        
        .category-scroll::-webkit-scrollbar {
            display: none;
        }
        
        .category-link {
            white-space: nowrap;
            color: #4b5563;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 0;
            transition: color 0.2s;
        }
        
        .category-link.active {
            color: #3b82f6;
            border-bottom: 2px solid #3b82f6;
        }
        
        .category-link:hover {
            color: #3b82f6;
        }
        
        /* Category Pills */
        .category-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin: 2rem 0;
        }
        
        .category-pill {
            padding: 0.5rem 1rem;
            background-color: white;
            border-radius: 9999px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            font-size: 0.875rem;
            font-weight: 500;
            color: #4b5563;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .category-pill:hover {
            background-color: #f3f4f6;
        }
        
        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        
        .breadcrumb-divider {
            margin: 0 0.5rem;
        }
        
        .breadcrumb-current {
            font-weight: 500;
            color: #374151;
        }
        
        /* Service Title */
        .service-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1.5rem;
            line-height: 1.3;
        }
        
        /* Freelancer Info */
        .freelancer-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .freelancer-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .divider {
            color: #d1d5db;
        }
        
        .freelancer-name {
            font-weight: 600;
            color: #1f2937;
        }
        
        .queue-info {
            color: #6b7280;
        }
        
        .rating-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .stars {
            color: #fbbf24;
        }
        
        .review-count {
            color: #6b7280;
        }
        
        /* Clients Section */
        .clients-section {
            margin: 2rem 0;
        }
        
        .clients-title {
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 1rem;
        }
        
        .client-avatars {
            display: flex;
            gap: 0.5rem;
        }
        
        .client-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 9999px;
        }
        
        /* Packages Grid */
        .packages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 2.5rem 0;
        }
        
        .package-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background-color: white;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .package-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .package-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .package-type {
            font-weight: 600;
            font-size: 1.25rem;
            color: #1f2937;
        }
        
        .package-options {
            display: flex;
            gap: 0.25rem;
        }
        
        .package-option {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            background-color: #f3f4f6;
            border-radius: 0.25rem;
            color: #4b5563;
        }
        
        .package-price {
            margin-bottom: 1.5rem;
        }
        
        .price-amount {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
        }
        
        .price-discount {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }
        
        .package-subtitle {
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 0.5rem;
        }
        
        .package-description {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        
        .package-features {
            list-style-type: none;
            margin-bottom: 1.5rem;
        }
        
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }
        
        .feature-icon {
            color: #10b981;
            margin-top: 0.125rem;
        }
        
        .feature-text {
            font-size: 0.875rem;
        }
        
        .package-button {
            width: 100%;
            padding: 0.75rem 0;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .package-button:hover {
            background-color: #2563eb;
        }
        
        /* CTA Section */
        .cta-container {
            display: flex;
            justify-content: space-between;
            margin: 2.5rem 0;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .cta-secondary {
            padding: 0.75rem 1.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            color: #4b5563;
            background-color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .cta-secondary:hover {
            background-color: #f9fafb;
        }
        
        .cta-primary {
            padding: 0.75rem 1.5rem;
            background-color: #1f2937;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .cta-primary:hover {
            background-color: #374151;
        }
        
        /* Reviews Section */
        .reviews-section {
            margin: 3rem 0;
        }
        
        .reviews-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        
        .view-reviews {
            color: #3b82f6;
            font-weight: 500;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }
        
        .view-reviews:hover {
            text-decoration: underline;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .service-title {
                font-size: 1.5rem;
            }
            
            .freelancer-info {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .packages-grid {
                grid-template-columns: 1fr;
            }
            
            .cta-container {
                flex-direction: column;
            }
            
            .cta-primary, .cta-secondary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Main Navigation -->
    <nav class="nav-container">
        <div class="container">
            <div class="logo">
                <a href="/">TUNTAS<span class="logo-in">IN</span></a>
            </div>
        </div>
    </nav>
    
    <!-- Category Navigation -->
    <div class="category-nav">
        <div class="container">
            <div class="category-scroll">
            <a href="{{ route('graphics-design') }}" class="category-link {{ request()->routeIs('graphics-design') ? 'active' : '' }}">Graphics & Design</a>
            <a href="{{ route('programming-tech') }}" class="category-link {{ request()->routeIs('programming-tech') ? 'active' : '' }}">Programming & Tech</a>
            <a href="{{ route('digital-marketing') }}" class="category-link {{ request()->routeIs('digital-marketing') ? 'active' : '' }}">Digital Marketing</a>
            <a href="{{ route('video-animation') }}" class="category-link {{ request()->routeIs('video-animation') ? 'active' : '' }}">Video & Animation</a>
            <a href="{{ route('writing-translation') }}" class="category-link {{ request()->routeIs('writing-translation') ? 'active' : '' }}">Writing & Translation</a>
            <a href="{{ route('music-audio') }}" class="category-link {{ request()->routeIs('music-audio') ? 'active' : '' }}">Music & Audio</a>
            <a href="{{ route('business') }}" class="category-link {{ request()->routeIs('business') ? 'active' : '' }}">Business</a>
            </div>
        </div>
    </div>
    
    <main class="container">    
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <span>Graphics & Design</span>
            <span class="breadcrumb-divider">/</span>
            <span class="breadcrumb-current">Logo Design</span>
        </div>
        
        <!-- Service Title -->
        <h1 class="service-title">Desain Logo NEHH!!</h1>
        
        <!-- Freelancer Info -->
        <div class="freelancer-info">
            <div class="freelancer-meta">
                <span>All</span>
                <span class="divider">|</span>
                <span class="freelancer-name">Big Rides</span>
                <span class="divider">|</span>
                <span class="queue-info">21 pesanan dalam antrian</span>
            </div>
            
            <div class="rating-container">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <span class="review-count">(3653 ulasan)</span>
            </div>
        </div>
        
        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 2rem 0;">
        
        <!-- Clients Section -->
        <div class="clients-section">
            <h3 class="clients-title">Di antara klien saya</h3>
            <div class="client-avatars">
                <div class="client-avatar" style="background-color: #4ade80;"></div>
                <div class="client-avatar" style="background-color: #a78bfa;"></div>
                <div class="client-avatar" style="background-color: #a16207;"></div>
                <div class="client-avatar" style="background-color: #fb923c;"></div>
                <div class="client-avatar" style="background-color: #f9a8d4;"></div>
            </div>
        </div>
        
        <!-- Packages Grid -->
        <div class="packages-grid">
            <!-- Basic Package -->
            <div class="package-card">
                <div class="package-header">
                    <h3 class="package-type">Basic</h3>
                    <div class="package-options">
                        <span class="package-option">Standard</span>
                        <span class="package-option">Premium</span>
                    </div>
                </div>
                
                <div class="package-price">
                    <div class="price-amount">$80</div>
                </div>
                
                <h4 class="package-subtitle">STARTER</h4>
                <p class="package-description">2 desain logo custom, file jpeg resolusi tinggi dan file transparan</p>
                
                <ul class="package-features">
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">pengerjaan 3 hari</span>
                    </li>
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Revisi tanpa batas</span>
                    </li>
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">2 konsep termasuk</span>
                    </li>
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Logo transparan</span>
                    </li>
                </ul>
                
                <button class="package-button">Pilih</button>
            </div>
            
            <!-- Standard Package -->
            <div class="package-card">
                <div class="package-header">
                    <h3 class="package-type">Standard</h3>
                    <div class="package-options">
                        <span class="package-option">Premium</span>
                    </div>
                </div>
                
                <div class="package-price">
                    <div class="price-amount">$120</div>
                </div>
                
                <h4 class="package-subtitle">PROFESSIONAL</h4>
                <p class="package-description">4 desain logo custom, file source, semua format file</p>
                
                <ul class="package-features">
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">pengerjaan 2 hari</span>
                    </li>
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Revisi tanpa batas</span>
                    </li>
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">4 konsep termasuk</span>
                    </li>
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">File source (AI, PSD)</span>
                    </li>
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Semua format file</span>
                    </li>
                </ul>
                
                <button class="package-button">Pilih</button>
            </div>
            
            <!-- Premium Package -->
            <div class="package-card">
                <div class="package-header">
                    <h3 class="package-type">Premium</h3>
                </div>
                
                <div class="package-price">
                    <div class="price-amount">$200</div>
                </div>
                
                <h4 class="package-subtitle">BUSINESS</h4>
                <p class="package-description">Paket lengkap branding dengan 6 desain, stationery dan brand guide</p>
                
                <ul class="package-features">
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">pengerjaan 1 hari</span>
                    </li>
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Revisi tanpa batas</span>
                    </li>
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">6 konsep termasuk</span>
                    </li>
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Stationery design</span>
                    </li>
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Brand guideline</span>
                    </li>
                    <li class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span class="feature-text">Hak cipta logo</span>
                    </li>
                </ul>
                
                <button class="package-button">Pilih</button>
            </div>
        </div>
        
        <!-- CTA Section -->
        <div class="cta-container">
            <button class="cta-secondary">Lanjutkan</button>
            <button class="cta-primary">Hubungi Saya</button>
        </div>
        
        <!-- Reviews Section -->
        <div class="reviews-section">
            <h3 class="reviews-title">Yang disukai orang tentang freelancer ini</h3>
            <button class="view-reviews">Lihat semua ulasan</button>
            
            <!-- Reviews can be added here -->
        </div>
    </main>
</body>
</html>