@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="fas fa-user-circle"></i> User Details</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit User
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <!-- User Info Card -->
        <div class="card mb-3">
            <div class="card-body text-center">
                <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                <h4>{{ $user->name }}</h4>
                <p class="text-muted mb-1">{{ $user->designation ?? 'Staff Member' }}</p>
                <p class="text-muted">{{ $user->department ?? 'N/A' }}</p>
                <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }} fs-6">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Contact Information</h5>
            </div>
            <div class="card-body">
                <p><strong><i class="fas fa-envelope"></i> Email:</strong><br>{{ $user->email }}</p>
                <p><strong><i class="fas fa-phone"></i> Mobile:</strong><br>{{ $user->mobile ?? 'N/A' }}</p>
                <p><strong><i class="fas fa-building"></i> Department:</strong><br>{{ $user->department ?? 'N/A' }}</p>
                <p class="mb-0"><strong><i class="fas fa-calendar"></i> Joined:</strong><br>{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Requisitions -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Vehicle Requisitions ({{ $requisitions->total() }})</h5>
            </div>
            <div class="card-body">
                @if($requisitions->isEmpty())
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
                                @foreach($requisitions as $req)
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
                    {{ $requisitions->links() }}
                @endif
            </div>
        </div>

        <!-- Activity Logs -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Recent Activities</h5>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @if($activityLogs->isEmpty())
                    <p class="text-muted text-center py-3">No activities yet</p>
                @else
                    @foreach($activityLogs as $activity)
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-{{ $activity->action == 'create' ? 'plus' : ($activity->action == 'update' ? 'edit' : ($activity->action == 'delete' ? 'trash' : 'info')) }}-circle text-{{ $activity->action == 'create' ? 'success' : ($activity->action == 'delete' ? 'danger' : 'info') }}"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <strong>{{ ucfirst($activity->action) }}</strong>
                                <p class="mb-1">{{ $activity->description }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> {{ $activity->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection