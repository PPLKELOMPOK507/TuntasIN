@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <nav class="nav-container">
        <div class="logo">
            <a href="{{ route('manage') }}">TUNTAS<span class="logo-in">IN</span></a>
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
        <input type="radio" id="refunds-tab" name="admin-section" class="tab-toggle" hidden>

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

            <label class="stat-card" for="refunds-tab">
                <i class="fas fa-undo-alt"></i>
                <div class="stat-info">
                    <h3>Total Refunds</h3>
                    <p>{{ $refunds->count() ?? 0 }}</p>
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
                                        <form action="{{ route('manage.categories.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn" 
                                                    onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td class="actions">
                                    @if($user->role !== 'Admin')
                                        <form action="{{ route('manage.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
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
                                    <form action="{{ route('manage.jasa.destroy', $service->id) }}" method="POST" class="d-inline">
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

            <!-- Add hidden radio button for section control -->
            <input type="radio" id="categories-tab" name="admin-tab" class="admin-tab-input" {{ session('current_section') == 'categories' ? 'checked' : '' }}>

            <!-- Categories Section -->
            <div id="categories-section" class="admin-section {{ session('current_section') == 'categories' ? 'active' : '' }}">
                <div class="section-header">
                    <h2>Manajemen Kategori</h2>
                    <a href="{{ route('manage.categories.create') }}" class="add-category-btn">
                        <i class="fas fa-plus"></i> Tambah Kategori
                    </a>
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
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->services_count }}</td>
                                <td class="actions">
                                    <a href="{{ route('manage.categories.edit', $category->id) }}" class="action-btn edit-btn">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('manage.categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete-btn" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada kategori</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
            </div>

            <!-- Payment/Transaction Section -->
            <div class="admin-section" id="transactions-section">
                <div class="section-header">
                    <h2>Manajemen Pembayaran</h2>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>Pengguna</th>
                                <th>Jasa</th>
                                <th>Metode</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_reference }}</td>
                                <td>{{ $payment->user->full_name }}</td>
                                <td>{{ $payment->pemesanan->jasa->nama_jasa }}</td>
                                <td>{{ ucfirst($payment->payment_method) }}</td>
                                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="status-badge {{ $payment->status }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Refunds Section -->
            <div class="admin-section" id="refunds-section">
                <div class="section-header">
                    <h2>Manajemen Refund</h2>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID Refund</th>
                                <th>Pengguna</th>
                                <th>Jasa</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($refunds as $refund)
                            <tr>
                                <td>#{{ $refund->id }}</td>
                                <td>{{ $refund->user->full_name }}</td>
                                <td>{{ $refund->pemesanan->jasa->nama_jasa }}</td>
                                <td>{{ Str::limit($refund->reason, 30) }}</td>
                                <td>
                                    <span class="status-badge 
                                        @if($refund->status === 'pending') bg-warning text-dark
                                        @elseif($refund->status === 'declined') bg-danger
                                        @elseif($refund->status === 'accepted' || $refund->status === 'approved') bg-success
                                        @elseif($refund->status === 'completed') bg-primary
                                        @else bg-secondary
                                        @endif
                                    ">
                                        @if($refund->status === 'pending' && $refund->provider_response === 'accepted')
                                            Menunggu Verifikasi Admin
                                        @elseif($refund->status === 'pending' && $refund->provider_response === 'declined')
                                            Ditolak Penyedia Jasa
                                        @elseif($refund->status === 'pending')
                                            Menunggu Tanggapan Penyedia Jasa
                                        @elseif($refund->status === 'declined')
                                            Refund Ditolak
                                        @elseif($refund->status === 'accepted' || $refund->status === 'approved')
                                            Refund Disetujui
                                        @elseif($refund->status === 'completed')
                                            Refund Selesai
                                        @else
                                            {{ ucfirst($refund->status) }}
                                        @endif
                                    </span>
                                </td>
                                <td>{{ $refund->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.refunds.show', $refund->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<style>
.status-select {
    min-width: 120px;
    border-radius: 0.5rem;
    border: 1.5px solid #e5e7eb;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
.status-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
}
.status-badge.bg-warning { background: #fff3cd; color: #856404; }
.status-badge.bg-danger { background: #f8d7da; color: #721c24; }
.status-badge.bg-success { background: #d4edda; color: #155724; }
.status-badge.bg-primary { background: #cce5ff; color: #004085; }
.status-badge.bg-secondary { background: #e2e3e5; color: #383d41; }

/* Tampilkan hanya section yang sesuai radio button aktif */
.admin-section { display: none; }
#users-tab:checked ~ .admin-sections #users-section,
#services-tab:checked ~ .admin-sections #services-section,
#transactions-tab:checked ~ .admin-sections #transactions-section,
#categories-tab:checked ~ .admin-sections #categories-section,
#refunds-tab:checked ~ .admin-sections #refunds-section {
    display: block;
}
</style>
@endsection

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush