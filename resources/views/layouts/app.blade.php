<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vehicle Requisition System') - Oxfam Bangladesh</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --oxfam-green: #61A534;
            --oxfam-dark-green: #4a7f28;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .navbar {
            background-color: var(--oxfam-green) !important;
        }
        
        .btn-primary {
            background-color: var(--oxfam-green);
            border-color: var(--oxfam-green);
        }
        
        .btn-primary:hover {
            background-color: var(--oxfam-dark-green);
            border-color: var(--oxfam-dark-green);
        }
        
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        
        .sidebar .nav-link {
            color: #333;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--oxfam-green);
            color: white;
        }
        
        .main-content {
            flex: 1;
        }
        
        footer {
            margin-top: auto;
            background-color: #f8f9fa;
            padding: 1.5rem 0;
            border-top: 1px solid #dee2e6;
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .badge {
            padding: 0.35em 0.65em;
        }
        
        .table th {
            background-color: #f8f9fa;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-car"></i> Vehicle Requisition System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        @if(!auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('requisitions.create') }}">
                                <i class="fas fa-plus"></i> New Requisition
                            </a>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user-circle"></i> Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar (for authenticated users) -->
        @auth
        <div class="sidebar p-3" style="width: 250px;">
            <nav class="nav flex-column">
                @if(auth()->user()->isAdmin())
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.requisitions') ? 'active' : '' }}" href="{{ route('admin.requisitions') }}">
                        <i class="fas fa-clipboard-list"></i> All Requisitions
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.activities') ? 'active' : '' }}" href="{{ route('admin.activities') }}">
                        <i class="fas fa-history"></i> Activity Logs
                    </a>
                    <hr>
                    <h6 class="px-3 text-muted">Exports</h6>
                    <a class="nav-link" href="{{ route('admin.export.requisitions.excel') }}">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                    <a class="nav-link" href="{{ route('admin.export.requisitions.pdf') }}">
                        <i class="fas fa-file-pdf"></i> Export to PDF
                    </a>
                @else
                    <a class="nav-link {{ request()->routeIs('requisitions.index') ? 'active' : '' }}" href="{{ route('requisitions.index') }}">
                        <i class="fas fa-list"></i> My Requisitions
                    </a>
                    <a class="nav-link {{ request()->routeIs('requisitions.create') ? 'active' : '' }}" href="{{ route('requisitions.create') }}">
                        <i class="fas fa-plus-circle"></i> New Requisition
                    </a>
                    <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                        <i class="fas fa-user-circle"></i> My Profile
                    </a>
                @endif
            </nav>
        </div>
        @endauth

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <div class="container-fluid p-4">
                <!-- Alerts -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> Please fix the following errors:
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-muted">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Oxfam Bangladesh. All rights reserved.</p>
            <small>Vehicle Requisition Management System v1.0</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>