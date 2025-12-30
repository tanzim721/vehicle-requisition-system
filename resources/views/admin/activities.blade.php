@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <h2><i class="fas fa-history"></i> System Activity Logs</h2>
        <p class="text-muted">Monitor all user activities in the system</p>
    </div>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.activities') }}">
            <div class="row">
                <div class="col-md-3">
                    <select name="action" class="form-select">
                        <option value="">All Actions</option>
                        <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                        <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                        <option value="register" {{ request('action') == 'register' ? 'selected' : '' }}>Register</option>
                        <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                        <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                        <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                        <option value="export" {{ request('action') == 'export' ? 'selected' : '' }}>Export</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="from_date" class="form-control" placeholder="From Date" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="to_date" class="form-control" placeholder="To Date" value="{{ request('to_date') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($activities->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No activities found</h5>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                        <tr>
                            <td>
                                {{ $activity->created_at->format('d M Y') }}<br>
                                <small class="text-muted">{{ $activity->created_at->format('H:i:s') }}</small>
                            </td>
                            <td>
                                @if($activity->user)
                                    <strong>{{ $activity->user->name }}</strong><br>
                                    <small class="text-muted">{{ $activity->user->email }}</small>
                                @else
                                    <span class="text-muted">System</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ 
                                    $activity->action == 'create' ? 'success' : 
                                    ($activity->action == 'delete' ? 'danger' : 
                                    ($activity->action == 'login' ? 'info' : 
                                    ($activity->action == 'logout' ? 'secondary' : 'warning'))) 
                                }}">
                                    {{ ucfirst($activity->action) }}
                                </span>
                            </td>
                            <td>{{ $activity->description }}</td>
                            <td><small class="text-muted">{{ $activity->ip_address }}</small></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $activities->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection