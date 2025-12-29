@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="fas fa-user-circle"></i> My Profile</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Profile
        </a>
        <a href="{{ route('profile.password.edit') }}" class="btn btn-warning">
            <i class="fas fa-key"></i> Change Password
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <!-- Profile Card -->
        <div class="card mb-3">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-5x" style="color: var(--oxfam-green);"></i>
                </div>
                <h4>{{ $user->name }}</h4>
                <p class="text-muted mb-1">{{ $user->designation ?? 'Staff Member' }}</p>
                <p class="text-muted">{{ $user->department ?? 'N/A' }}</p>
                <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Quick Stats</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span><i class="fas fa-clipboard-list text-primary"></i> Total Requisitions</span>
                    <strong>{{ $requisitionsCount }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-calendar-check text-success"></i> Member Since</span>
                    <strong>{{ $user->created_at->format('M Y') }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Personal Information Card -->
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Full Name:</strong><br>
                        {{ $user->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Email Address:</strong><br>
                        {{ $user->email }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Designation:</strong><br>
                        {{ $user->designation ?? 'Not Set' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Mobile Number:</strong><br>
                        {{ $user->mobile ?? 'Not Set' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong>Department:</strong><br>
                        {{ $user->department ?? 'Not Set' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Account Status:</strong><br>
                        <span class="badge bg-success">Active</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Requisitions Card -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-history"></i> Recent Requisitions</h5>
            </div>
            <div class="card-body">
                @if($recentRequisitions->isEmpty())
                    <p class="text-muted text-center py-3">No requisitions yet</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Purpose</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentRequisitions as $req)
                                <tr>
                                    <td>#{{ $req->id }}</td>
                                    <td>{{ Str::limit($req->purpose, 30) }}</td>
                                    <td>{{ $req->starting_date->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $req->status_color }}">
                                            {{ ucfirst($req->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('requisitions.show', $req) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-2">
                        <a href="{{ route('requisitions.index') }}" class="btn btn-sm btn-outline-primary">
                            View All Requisitions <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection