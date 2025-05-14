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
                @if(Auth::user()->role === 'Penyedia Jasa')
                    <a href="{{ route('sales.history') }}" class="menu-item">
                        <i class="fas fa-history"></i>
                        <span>Riwayat Penjualan</span>
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="profile-container">
        <div class="profile-header">
            <h1>My Profile</h1>
        </div>

        <div class="profile-content">
            <div class="profile-photo">
                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile Photo">
                @else
                    <div class="photo-placeholder">
                        <i class="fas fa-user fa-3x" style="color: #0077cc;"></i>
                    </div>
                @endif
                <button type="button" class="change-photo-btn" onclick="document.getElementById('photo').click()">
                    <i class="fas fa-camera"></i>
                    Change Photo
                </button>
            </div>

            <div class="profile-info">
                <form action="{{ route('profile.update') }}" method="POST" class="profile-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <input type="file" 
                           id="photo" 
                           name="photo" 
                           accept="image/*" 
                           hidden>
                    
                    <div class="info-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ Auth::user()->first_name }}" class="profile-input">
                    </div>
                    
                    <div class="info-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ Auth::user()->last_name }}" class="profile-input">
                    </div>

                    <div class="info-group">
                        <label>Email</label>
                        <p class="static-info">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="info-group">
                        <label>Role</label>
                        <p class="static-info">{{ Auth::user()->role }}</p>
                    </div>

                    <div class="info-group">
                        <label>Mobile Number</label>
                        <p class="static-info">{{ Auth::user()->mobile_number }}</p>
                    </div>

                    @if(Auth::user()->role === 'Pengguna Jasa')
                        <div class="info-group">
                            <label for="address">Address</label>
                            <textarea 
                                id="address" 
                                name="address" 
                                class="profile-input" 
                                rows="3" 
                                placeholder="Enter your address">{{ Auth::user()->address }}</textarea>
                        </div>
                    @endif

                    <div class="password-section">
                        <h3>
                            <i class="fas fa-lock"></i>
                            Change Password
                        </h3>
                        <div class="info-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password" 
                                   class="profile-input"
                                   placeholder="Enter your current password">
                        </div>

                        <div class="info-group">
                            <label for="new_password">New Password</label>
                            <input type="password" 
                                   id="new_password" 
                                   name="new_password" 
                                   class="profile-input"
                                   placeholder="Enter new password">
                        </div>

                        <div class="info-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <input type="password" 
                                   id="new_password_confirmation" 
                                   name="new_password_confirmation" 
                                   class="profile-input"
                                   placeholder="Confirm your new password">
                        </div>
                    </div>

                    @if(Auth::user()->role === 'Penyedia Jasa')
                        <div class="cv-section">
                            <h3>
                                <i class="fas fa-file-alt"></i>
                                Curriculum Vitae
                            </h3>
                            <div class="info-group">
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

                    <div class="button-group">
                        <button type="submit" class="save-btn">Save Changes</button>
                    </div>
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
@endpush

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.nextElementSibling.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

document.getElementById('cv_file')?.addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const file = e.target.files[0];
        const container = document.querySelector('.cv-upload-container');
        let currentCV = container.querySelector('.current-cv');
        
        if (!currentCV) {
            currentCV = document.createElement('div');
            currentCV.className = 'current-cv';
            container.insertBefore(currentCV, container.firstChild);
        }
        
        currentCV.innerHTML = `
            <i class="fas fa-file-pdf"></i>
            <span class="cv-filename">${file.name}</span>
        `;

        // Auto submit form when file is selected
        document.querySelector('.profile-form').submit();
    }
});

document.getElementById('photo').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const file = e.target.files[0];
        const reader = new FileReader();
        const photoContainer = document.querySelector('.profile-photo');
        
        reader.onload = function(e) {
            const result = e.target.result;
            
            // Remove existing elements if any
            const existingPreview = photoContainer.querySelector('.preview-label');
            const existingRevert = photoContainer.querySelector('.revert-photo-btn');
            const existingImg = photoContainer.querySelector('img');
            const existingPlaceholder = photoContainer.querySelector('.photo-placeholder');
            
            if (existingPreview) existingPreview.remove();
            if (existingRevert) existingRevert.remove();
            
            // Create or update image
            let imageElement;
            if (existingImg) {
                imageElement = existingImg;
                imageElement.dataset.originalSrc = imageElement.src;
            } else {
                imageElement = document.createElement('img');
                if (existingPlaceholder) existingPlaceholder.remove();
            }
            
            // Set image properties
            imageElement.src = result;
            imageElement.alt = 'Profile Photo Preview';
            imageElement.style.width = '180px';
            imageElement.style.height = '180px';
            imageElement.style.borderRadius = '50%';
            imageElement.style.objectFit = 'cover';
            imageElement.style.border = '4px solid #f0f7ff';
            imageElement.style.marginBottom = '1.5rem';
            
            // Add image if it's new
            if (!existingImg) {
                photoContainer.insertBefore(imageElement, photoContainer.firstChild);
            }
            
            // Add preview label
            const previewLabel = document.createElement('div');
            previewLabel.className = 'preview-label';
            previewLabel.textContent = 'Preview - Click Save Changes to update';
            photoContainer.insertBefore(previewLabel, photoContainer.querySelector('.change-photo-btn'));
            
            // Add cancel button
            const revertBtn = document.createElement('button');
            revertBtn.type = 'button';
            revertBtn.className = 'revert-photo-btn';
            revertBtn.innerHTML = '<i class="fas fa-undo"></i> Cancel';
            photoContainer.insertBefore(revertBtn, photoContainer.querySelector('.change-photo-btn'));
            
            // Handle cancel click
            revertBtn.addEventListener('click', function() {
                if (existingImg) {
                    // Restore original image
                    imageElement.src = imageElement.dataset.originalSrc;
                } else {
                    // Restore placeholder
                    const placeholder = document.createElement('div');
                    placeholder.className = 'photo-placeholder';
                    placeholder.innerHTML = '<i class="fas fa-user fa-3x" style="color: #0077cc;"></i>';
                    imageElement.replaceWith(placeholder);
                }
                
                // Cleanup
                previewLabel.remove();
                revertBtn.remove();
                document.getElementById('photo').value = '';
            });
        };
        
        reader.readAsDataURL(file);
    }
});
</script>
@endpush