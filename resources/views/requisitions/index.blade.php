@extends('layouts.app')

@section('title', 'My Requisitions')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="fas fa-clipboard-list"></i> My Vehicle Requisitions</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('requisitions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Requisition
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($requisitions->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No requisitions yet</h5>
                <p class="text-muted">Click the button above to create your first vehicle requisition.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Purpose</th>
                            <th>Journey Date</th>
                            <th>Pickup → Drop</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requisitions as $req)
                        <tr>
                            <td>#{{ $req->id }}</td>
                            <td>{{ Str::limit($req->purpose, 40) }}</td>
                            <td>
                                {{ $req->starting_date->format('d M Y') }}<br>
                                <small class="text-muted">{{ $req->starting_time }} - {{ $req->ending_time }}</small>
                            </td>
                            <td>
                                <small>
                                    <strong>From:</strong> {{ Str::limit($req->pickup_address, 25) }}<br>
                                    <strong>To:</strong> {{ Str::limit($req->drop_address, 25) }}
                                </small>
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
                            <td>{{ $req->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('requisitions.show', $req) }}" class="btn btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($req->status == 'pending')
                                    <a href="{{ route('requisitions.edit', $req) }}" class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('requisitions.destroy', $req) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this requisition?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $requisitions->links() }}
            </div>
        @endif
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="mb-0">{{ $requisitions->total() }}</h3>
                <small class="text-muted">Total Requisitions</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="mb-0 text-warning">{{ $requisitions->where('status', 'pending')->count() }}</h3>
                <small class="text-muted">Pending</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="mb-0 text-success">{{ $requisitions->where('status', 'approved')->count() }}</h3>
                <small class="text-muted">Approved</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="mb-0 text-danger">{{ $requisitions->where('status', 'rejected')->count() }}</h3>
                <small class="text-muted">Rejected</small>
            </div>
        </div>
    </div>
</div>
@endsection