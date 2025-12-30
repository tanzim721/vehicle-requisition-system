@extends('layouts.app')

@section('title', 'All Requisitions')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="fas fa-clipboard-list"></i> All Vehicle Requisitions</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('admin.export.requisitions.excel') }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="{{ route('admin.export.requisitions.pdf') }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.requisitions') }}">
            <div class="row">
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="from_date" class="form-control" placeholder="From Date" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="to_date" class="form-control" placeholder="To Date" value="{{ request('to_date') }}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by name, purpose, email..." value="{{ request('search') }}">
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

<!-- Requisitions Table -->
<div class="card">
    <div class="card-body">
        @if($requisitions->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No requisitions found</h5>
                <p class="text-muted">No requisitions match your filter criteria.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Staff Name</th>
                            <th>Purpose</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requisitions as $req)
                        <tr>
                            <td>#{{ $req->id }}</td>
                            <td>
                                <strong>{{ $req->user->name }}</strong><br>
                                <small class="text-muted">{{ $req->user->email }}</small>
                            </td>
                            <td>{{ $req->staff_name }}</td>
                            <td>{{ Str::limit($req->purpose, 40) }}</td>
                            <td>
                                {{ $req->starting_date->format('d M Y') }}<br>
                                <small class="text-muted">{{ $req->starting_time }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $req->requisition_type == 'official' ? 'info' : 'secondary' }}">
                                    {{ ucfirst($req->requisition_type) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $req->status_color }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('requisitions.show', $req) }}" class="btn btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.export.requisition.pdf', $req) }}" class="btn btn-danger" title="Export PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $requisitions->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection