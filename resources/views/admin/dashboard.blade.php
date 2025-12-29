@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-chart-line"></i> Admin Dashboard</h2>
        <p class="text-muted">Welcome to the Vehicle Requisition Management System</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                        <small>Total Users</small>
                    </div>
                    <div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $stats['total_requisitions'] }}</h3>
                        <small>Total Requisitions</small>
                    </div>
                    <div>
                        <i class="fas fa-clipboard-list fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $stats['pending_requisitions'] }}</h3>
                        <small>Pending</small>
                    </div>
                    <div>
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $stats['approved_requisitions'] }}</h3>
                        <small>Approved</small>
                    </div>
                    <div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $stats['rejected_requisitions'] }}</h3>
                        <small>Rejected</small>
                    </div>
                    <div>
                        <i class="fas fa-times-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Requisitions -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list"></i> Recent Requisitions</h5>
            </div>
            <div class="card-body">
                @if($recentRequisitions->isEmpty())
                    <p class="text-muted text-center py-3">No requisitions yet</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
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
                                    <td>{{ $req->user->name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($req->purpose, 30) }}</td>
                                    <td>{{ $req->starting_date->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $req->status_color }}">
                                            {{ ucfirst($req->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.requisitions') }}?id={{ $req->id }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-2">
                        <a href="{{ route('admin.requisitions') }}" class="btn btn-sm btn-outline-primary">
                            View All <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history"></i> Recent Activities</h5>
            </div>
            <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                @if($recentActivities->isEmpty())
                    <p class="text-muted text-center py-3">No activities yet</p>
                @else
                    <div class="timeline">
                        @foreach($recentActivities as $activity)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-{{ $activity->action == 'create' ? 'plus' : ($activity->action == 'update' ? 'edit' : ($activity->action == 'delete' ? 'trash' : 'info')) }}-circle text-{{ $activity->action == 'create' ? 'success' : ($activity->action == 'delete' ? 'danger' : 'info') }}"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <small class="text-muted d-block">
                                        {{ $activity->user->name ?? 'System' }}
                                    </small>
                                    <small>{{ $activity->description }}</small>
                                    <div>
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> {{ $activity->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-end mt-2">
                        <a href="{{ route('admin.activities') }}" class="btn btn-sm btn-outline-primary">
                            View All <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.requisitions') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-clipboard-list"></i> View All Requisitions
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-users"></i> Manage Users
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.export.requisitions.excel') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.export.requisitions.pdf') }}" class="btn btn-outline-danger w-100">
                            <i class="fas fa-file-pdf"></i> Export to PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection