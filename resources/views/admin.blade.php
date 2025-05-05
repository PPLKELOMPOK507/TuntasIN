@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <nav class="nav-container">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
        </div>

        <!-- Admin Menu -->
        <div class="user-profile">
            <div class="user-info">
                <div class="profile-image">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile">
                    @else
                        <div class="profile-placeholder"></div>
                    @endif
                </div>
                <span class="admin-label">Administrator</span>
                <button class="dropdown-toggle"> ⌵ </button>
            </div>
            <div class="dropdown-menu">
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

    <div class="admin-dashboard">
        <!-- Hidden radio buttons -->
        <input type="radio" id="users-tab" name="admin-section" class="tab-toggle" hidden>
        <input type="radio" id="services-tab" name="admin-section" class="tab-toggle" hidden checked>
        <input type="radio" id="transactions-tab" name="admin-section" class="tab-toggle" hidden>
        <input type="radio" id="categories-tab" name="admin-section" class="tab-toggle" hidden>

        <!-- Stats Container -->
        <div class="stats-container">
            <label class="stat-card" for="users-tab">
                <i class="fas fa-users"></i>
                <div class="stat-info">
                    <h3>Total Users</h3>
                    <p>{{ $totalUsers ?? 0 }}</p>
                </div>
            </label>

            <label class="stat-card" for="services-tab">
                <i class="fas fa-briefcase"></i>
                <div class="stat-info">
                    <h3>Total Services</h3>
                    <p>{{ $jasa->count() }}</p>
                </div>
            </label>

            <label class="stat-card" for="transactions-tab">
                <i class="fas fa-chart-line"></i>
                <div class="stat-info">
                    <h3>Total Transactions</h3>
                    <p>{{ $totalTransactions ?? 0 }}</p>
                </div>
            </label>

            <label class="stat-card" for="categories-tab">
                <i class="fas fa-tags"></i>
                <div class="stat-info">
                    <h3>Categories</h3>
                    <p>{{ $categories->count() ?? 0 }}</p>
                </div>
            </label>
        </div>

        <!-- Content Sections -->
        <div class="admin-sections">
            <!-- Users Section -->
            <div class="admin-section" id="users-section">
                <div class="section-header">
                    <h2>User Management</h2>
                    <div class="search-bar">
                        <input type="text" placeholder="Search users...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role === 'Admin')
                                        <span class="admin-label">{{ $user->role }}</span>
                                    @else
                                        {{ $user->role }}
                                    @endif
                                </td>
                                <td class="actions">
                                    @if($user->role !== 'Admin')
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn" 
                                                    onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Services Section -->
            <div class="admin-section" id="services-section">
                <div class="section-header">
                    <h2>Service Management</h2>
                    <div class="search-bar">
                        <input type="text" placeholder="Search services...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>Provider</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jasa as $service)
                            <tr>
                                <td>{{ $service->nama_jasa }}</td>
                                <td>{{ $service->user->name }}</td>
                                <td>{{ $service->category->name ?? 'Uncategorized' }}</td>
                                <td>Rp {{ number_format($service->minimal_harga, 0, ',', '.') }}</td>
                                <td><span class="status-badge active">Active</span></td>
                                <td class="actions">
                                    <button class="action-btn view-btn" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <form action="{{ route('admin.jasa.destroy', $service->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete-btn" title="Delete Service">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No services found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Categories Section -->
            <div id="categories-section" class="admin-section">
                <div class="section-header">
                    <h2>Manajemen Kategori</h2>
                    <button class="add-category-btn" onclick="openAddCategoryModal()">
                        <i class="fas fa-plus"></i> Tambah Kategori
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Kategori</th>
                                <th>Jumlah Jasa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->services_count }}</td>
                                <td class="actions">
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div class="modal" id="categoryModal">
    <div class="modal-content">
        <h2>Add New Category</h2>
        <form id="categoryForm" action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="categoryName">Category Name</label>
                <input type="text" id="categoryName" name="name" required>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn">Cancel</button>
                <button type="submit" class="submit-btn">Save Category</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="modal">
    <div class="modal-content">
        <h2>Tambah Kategori Baru</h2>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Kategori</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="closeAddCategoryModal()">Batal</button>
                <button type="submit" class="submit-btn">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.querySelector('.search-bar input');
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const tableRows = document.querySelectorAll('.admin-table tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Stats card navigation
    const statCards = document.querySelectorAll('.stat-card.clickable');
    const sections = document.querySelectorAll('.admin-section');

    statCards.forEach(card => {
        card.addEventListener('click', function() {
            const sectionId = this.getAttribute('data-section') + '-section';
            sections.forEach(section => {
                section.style.display = section.id === sectionId ? '' : 'none';
            });
        });
    });

    // Modal functionality
    const addCategoryBtn = document.querySelector('.add-category-btn');
    const categoryModal = document.getElementById('categoryModal');
    const cancelBtn = categoryModal.querySelector('.cancel-btn');

    addCategoryBtn.addEventListener('click', function() {
        categoryModal.style.display = 'block';
    });

    cancelBtn.addEventListener('click', function() {
        categoryModal.style.display = 'none';
    });
});
</script>
@endpush
@endsection