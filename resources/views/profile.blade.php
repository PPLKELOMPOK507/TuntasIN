@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <nav class="nav-container">
        <div class="logo">
            @auth
                <a href="{{ route('dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
            @else
                <a href="/">TUNTAS<span class="logo-in">IN</span></a>
            @endauth
        </div>
        
        <!-- User Menu -->
        <div class="user-profile">
            <div class="user-info">
                <div class="profile-image">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile">
                    @else
                        <div class="profile-placeholder"></div>
                    @endif
                </div>
                <span class="user-name">{{ Auth::user()->full_name }}</span>
            </div>
            <div class="dropdown-menu">
                <a href="{{ route('profile') }}" class="menu-item active">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>

                @if(Auth::user()->role === 'Pengguna Jasa')
                    <a href="{{ route('purchases.history') }}" class="menu-item">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Riwayat Pembelian</span>
                    </a>
                @endif

                @if(Auth::user()->role === 'Penyedia Jasa')
                    <a href="{{ route('account.balance') }}" class="menu-item">
                        <i class="fas fa-wallet"></i>
                        <span>My Balance</span>
                    </a>

                    <a href="{{ route('sales.history') }}" class="menu-item">
                        <i class="fas fa-history"></i>
                        <span>Riwayat Penjualan</span>
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="profile-container">
        <div class="profile-header">
            <div class="header-content">
                <h1>My Profile</h1>
                <p>Manage your account information and settings</p>
            </div>
            <div class="header-actions">
                <button type="button" class="btn-save-all" form="profile-form">
                    <i class="fas fa-save"></i>
                    Save Changes
                </button>
            </div>
        </div>

        <div class="profile-layout">
            <!-- Profile Sidebar -->
            <div class="profile-sidebar">
                <div class="profile-photo-section">
                    <div class="profile-photo">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile">
                        @else
                            <div class="photo-placeholder">
                                <span>{{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <button type="button" class="change-photo-btn" onclick="document.getElementById('photo').click()">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <div class="profile-info-summary">
                        <h3>{{ Auth::user()->full_name }}</h3>
                        <span class="role-badge">{{ Auth::user()->role }}</span>
                    </div>
                </div>

                <nav class="profile-nav">
                    <button type="button" class="nav-item active" data-section="general">
                        <i class="fas fa-user"></i>
                        General Information
                    </button>
                    <button type="button" class="nav-item" data-section="security">
                        <i class="fas fa-lock"></i>
                        Security
                    </button>
                    @if(Auth::user()->role === 'Pengguna Jasa')
                        <button type="button" class="nav-item" data-section="address">
                            <i class="fas fa-map-marker-alt"></i>
                            Address
                        </button>
                    @endif
                    @if(Auth::user()->role === 'Penyedia Jasa')
                        <button type="button" class="nav-item" data-section="documents">
                            <i class="fas fa-file-alt"></i>
                            Documents
                        </button>
                    @endif
                </nav>
            </div>

            <!-- Profile Content -->
            <div class="profile-content">
                <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="file" id="photo" name="photo" accept="image/*" hidden>

                    <!-- General Information Section -->
                    <div class="profile-section active" id="general-section">
                        <div class="section-grid">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" value="{{ Auth::user()->first_name }}" class="form-input">
                            </div>
                            
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" value="{{ Auth::user()->last_name }}" class="form-input">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <div class="static-input">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="form-group">
                                <label>Phone Number</label>
                                <div class="static-input">{{ Auth::user()->mobile_number }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="profile-section" id="security-section">
                        <div class="section-grid">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <div class="password-input-group">
                                    <input type="password" id="current_password" name="current_password" class="form-input">
                                    <button type="button" class="toggle-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <div class="password-input-group">
                                    <input type="password" id="new_password" name="new_password" class="form-input">
                                    <button type="button" class="toggle-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">Confirm New Password</label>
                                <div class="password-input-group">
                                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-input">
                                    <button type="button" class="toggle-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Section (Pengguna Jasa) -->
                    @if(Auth::user()->role === 'Pengguna Jasa')
                        <div class="profile-section" id="address-section">
                            <div class="section-grid">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <div class="address-container">
                                        <textarea 
                                            id="address" 
                                            name="address" 
                                            class="form-input" 
                                            rows="3" 
                                            placeholder="Enter your address">{{ Auth::user()->address }}</textarea>
                                        
                                        <div id="map"></div>
                                        
                                        <input type="hidden" id="latitude" name="latitude" value="{{ Auth::user()->latitude }}">
                                        <input type="hidden" id="longitude" name="longitude" value="{{ Auth::user()->longitude }}">
                                        
                                        <button type="button" class="btn-get-location" onclick="getCurrentLocation()">
                                            <i class="fas fa-map-marker-alt"></i> Get Current Location
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group description">
                                    <label for="description">Description</label>
                                    <textarea 
                                        id="description" 
                                        name="description" 
                                        class="form-input" 
                                        rows="4" 
                                        placeholder="Tell us about yourself">{{ Auth::user()->description }}</textarea>
                                    <small class="form-text">Share some information about yourself, your interests, or what kind of services you're looking for.</small>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Documents Section (Penyedia Jasa) -->
                    @if(Auth::user()->role === 'Penyedia Jasa')
                        <div class="profile-section" id="documents-section">
                            <div class="section-grid">
                                <div class="form-group">
                                    <label for="cv_file">Curriculum Vitae</label>
                                    <div class="cv-upload-container">
                                        @if(Auth::user()->cv_file)
                                            <div class="current-cv">
                                                <i class="fas fa-file-pdf"></i>
                                                <span class="cv-filename">{{ basename(Auth::user()->cv_file) }}</span>
                                                <a href="{{ asset('storage/' . Auth::user()->cv_file) }}" 
                                                   class="view-cv-btn" 
                                                   target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                    View CV
                                                </a>
                                            </div>
                                        @endif
                                        <input type="file" 
                                               id="cv_file" 
                                               name="cv_file" 
                                               accept=".pdf,.doc,.docx" 
                                               hidden>
                                        <button type="button" 
                                                class="upload-cv-btn" 
                                                onclick="document.getElementById('cv_file').click()">
                                            <i class="fas fa-upload"></i>
                                            {{ Auth::user()->cv_file ? 'Change CV' : 'Upload CV' }}
                                        </button>
                                        <p class="cv-help-text">Accepted formats: PDF, DOC, DOCX (Max. 5MB)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab Navigation
    const initTabs = () => {
        const navButtons = document.querySelectorAll('.nav-item');
        const sections = document.querySelectorAll('.profile-section');

        navButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons and sections
                navButtons.forEach(btn => btn.classList.remove('active'));
                sections.forEach(section => section.classList.remove('active'));

                // Add active class to clicked button and corresponding section
                button.classList.add('active');
                const targetSection = document.getElementById(button.dataset.section + '-section');
                if (targetSection) {
                    targetSection.classList.add('active');
                }
            });
        });
    };

    // Password Toggle Functionality
    const initPasswordToggles = () => {
        const toggleButtons = document.querySelectorAll('.toggle-password');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');

                input.type = input.type === 'password' ? 'text' : 'password';
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    };

    // Profile Photo Handling
    const initProfilePhoto = () => {
        const photoInput = document.getElementById('photo');
        const photoContainer = document.querySelector('.profile-photo');

        photoInput?.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imageUrl = e.target.result;
                    
                    // Update profile photo preview
                    let img = photoContainer.querySelector('img');
                    if (!img) {
                        img = document.createElement('img');
                        const placeholder = photoContainer.querySelector('.photo-placeholder');
                        if (placeholder) placeholder.remove();
                        photoContainer.insertBefore(img, photoContainer.firstChild);
                    }
                    img.src = imageUrl;
                    img.alt = 'Profile Preview';

                    // Show success notification
                    Swal.fire({
                        title: 'Photo Selected',
                        text: 'Click Save Changes to update your profile photo',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                };

                reader.readAsDataURL(file);
            }
        });
    };

    // Form Submission Handler
    const initFormSubmission = () => {
        const form = document.getElementById('profile-form');
        const saveButton = document.querySelector('.btn-save-all');

        saveButton?.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Show loading state
            this.disabled = true;
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json' // Tambahkan header Accept
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Profile updated successfully',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Failed to update profile');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Jika update berhasil tapi response JSON error, tetap refresh
                if (error.message.includes('JSON')) {
                    window.location.reload();
                    return;
                }
                
                Swal.fire({
                    title: 'Error!', 
                    text: 'Profile has been updated but encountered display error',
                    icon: 'info',
                    showConfirmButton: true
                }).then(() => {
                    window.location.reload();
                });
            })
            .finally(() => {
                // Restore button state
                this.disabled = false;
                this.innerHTML = originalText;
            });
        });
    };

    // Map Initialization (if address section exists)
    const initMap = () => {
        const mapElement = document.getElementById('map');
        if (!mapElement) return;

        let map = L.map('map').setView([-6.200000, 106.816666], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        let marker = L.marker([-6.200000, 106.816666], { draggable: true }).addTo(map);

        // Update coordinates when marker is dragged
        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
            updateAddress(position.lat, position.lng);
        });

        // Get current location button
        document.querySelector('.btn-get-location')?.addEventListener('click', () => {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const { latitude, longitude } = position.coords;
                    map.setView([latitude, longitude], 15);
                    marker.setLatLng([latitude, longitude]);
                    updateAddress(latitude, longitude);
                },
                error => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Unable to get your location',
                        icon: 'error'
                    });
                }
            );
        });
    };

    // Helper function to update address from coordinates
    const updateAddress = async (lat, lng) => {
        try {
            const response = await fetch(
                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`
            );
            const data = await response.json();
            document.getElementById('address').value = data.display_name;
        } catch (error) {
            console.error('Error fetching address:', error);
        }
    };

    // Initialize all components
    initTabs();
    initPasswordToggles();
    initProfilePhoto();
    initFormSubmission();
    initMap();
});
</script>
@endpush