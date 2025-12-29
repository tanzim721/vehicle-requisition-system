<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Requisition System - Oxfam Bangladesh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --oxfam-green: #61A534;
            --oxfam-dark-green: #4a7f28;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--oxfam-green) 0%, var(--oxfam-dark-green) 100%);
            color: white;
            padding: 100px 0;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }
        
        .feature-card {
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: var(--oxfam-green);
            margin-bottom: 1rem;
        }
        
        .btn-oxfam {
            background-color: var(--oxfam-green);
            border-color: var(--oxfam-green);
            color: white;
            padding: 12px 30px;
            font-size: 1.1rem;
        }
        
        .btn-oxfam:hover {
            background-color: var(--oxfam-dark-green);
            border-color: var(--oxfam-dark-green);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/" style="color: var(--oxfam-green);">
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
                        <a class="nav-link btn btn-oxfam text-white ms-2" href="{{ route('register') }}">Register</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link btn btn-oxfam text-white" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-3 fw-bold mb-4">Vehicle Requisition Made Easy</h1>
                    <p class="lead mb-4">Streamline your vehicle booking process with our digital requisition system. Request vehicles, track approvals, and manage your bookings all in one place.</p>
                    <div class="d-flex gap-3">
                        @guest
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-user-plus"></i> Get Started
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        @else
                        <a href="{{ route('requisitions.create') }}" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-plus-circle"></i> New Requisition
                        </a>
                        <a href="{{ route('requisitions.index') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-list"></i> My Requisitions
                        </a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <i class="fas fa-car-side" style="font-size: 15rem; opacity: 0.9;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Why Use Our System?</h2>
                <p class="text-muted">Efficient, transparent, and easy to use</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h4>Quick Booking</h4>
                            <p class="text-muted">Submit vehicle requisitions in minutes with our user-friendly form.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h4>Real-time Tracking</h4>
                            <p class="text-muted">Track the status of your requisitions from submission to approval.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4>Secure & Reliable</h4>
                            <p class="text-muted">Your data is protected with enterprise-grade security measures.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4>Multi-user Support</h4>
                            <p class="text-muted">Manage multiple passengers and team members easily.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-file-export"></i>
                            </div>
                            <h4>Export Reports</h4>
                            <p class="text-muted">Download requisition data in Excel or PDF format.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h4>Mobile Friendly</h4>
                            <p class="text-muted">Access the system from any device, anywhere, anytime.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">How It Works</h2>
                <p class="text-muted">Simple steps to book your vehicle</p>
            </div>
            <div class="row">
                <div class="col-md-3 text-center mb-4">
                    <div class="mb-3">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                    <h5>1. Register</h5>
                    <p class="text-muted">Create your account with basic information</p>
                </div>
                <div class="col-md-3 text-center mb-4">
                    <div class="mb-3">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                    <h5>2. Fill Form</h5>
                    <p class="text-muted">Complete the vehicle requisition form</p>
                </div>
                <div class="col-md-3 text-center mb-4">
                    <div class="mb-3">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                    </div>
                    <h5>3. Submit</h5>
                    <p class="text-muted">Send your requisition for approval</p>
                </div>
                <div class="col-md-3 text-center mb-4">
                    <div class="mb-3">
                        <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <h5>4. Get Approved</h5>
                    <p class="text-muted">Receive confirmation and vehicle details</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5" style="background-color: var(--oxfam-green);">
        <div class="container text-center text-white">
            <h2 class="fw-bold mb-3">Ready to Get Started?</h2>
            <p class="lead mb-4">Join hundreds of staff members using our system</p>
            @guest
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">
                <i class="fas fa-rocket"></i> Create Account Now
            </a>
            @else
            <a href="{{ route('requisitions.create') }}" class="btn btn-light btn-lg px-5">
                <i class="fas fa-plus-circle"></i> Create Requisition
            </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Vehicle Requisition System</h5>
                    <p class="text-muted"> Bangladesh</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; {{ date('Y') }}  Bangladesh. All rights reserved.</p>
                    <small class="text-muted">Version 1.0.0</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>