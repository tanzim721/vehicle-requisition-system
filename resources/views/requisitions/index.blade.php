@extends('layouts.app')

@section('title', 'Requisition Details')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="fas fa-file-alt"></i> Requisition #{{ $requisition->id }}</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        @if($requisition->status == 'pending' && $requisition->user_id == auth()->id())
        <a href="{{ route('requisitions.edit', $requisition) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        @endif
        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.export.requisition.pdf', $requisition) }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Main Information Card -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Requisition Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Status:</strong><br>
                        <span class="badge bg-{{ $requisition->status_color }} fs-6">
                            {{ ucfirst($requisition->status) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Type:</strong><br>
                        <span class="badge bg-{{ $requisition->requisition_type == 'official' ? 'info' : 'secondary' }} fs-6">
                            {{ ucfirst($requisition->requisition_type) }}
                        </span>
                    </div>
                </div>

                <hr>

                <h6 class="text-primary"><i class="fas fa-user"></i> Staff Information</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Name:</strong> {{ $requisition->staff_name }}<br>
                        <strong>Designation:</strong> {{ $requisition->designation }}
                    </div>
                    <div class="col-md-6">
                        <strong>Mobile:</strong> {{ $requisition->mobile }}<br>
                        <strong>Email:</strong> {{ $requisition->user->email }}
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Purpose:</strong><br>
                    <p class="ms-3">{{ $requisition->purpose }}</p>
                </div>

                <hr>

                <h6 class="text-primary"><i class="fas fa-calendar"></i> Journey Details</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Starting:</strong><br>
                        <i class="fas fa-calendar-alt text-success"></i> {{ $requisition->starting_date->format('d M Y') }}<br>
                        <i class="fas fa-clock text-success"></i> {{ $requisition->starting_time }}
                    </div>
                    <div class="col-md-6">
                        <strong>Ending:</strong><br>
                        <i class="fas fa-calendar-alt text-danger"></i> {{ $requisition->ending_date->format('d M Y') }}<br>
                        <i class="fas fa-clock text-danger"></i> {{ $requisition->ending_time }}
                    </div>
                </div>

                <hr>

                <h6 class="text-primary"><i class="fas fa-map-marker-alt"></i> Addresses</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Pickup Location:</strong><br>
                        <p class="ms-3">{{ $requisition->pickup_address }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Drop Location:</strong><br>
                        <p class="ms-3">{{ $requisition->drop_address }}</p>
                    </div>
                </div>

                @if($requisition->passengers->count() > 0)
                <hr>
                <h6 class="text-primary"><i class="fas fa-users"></i> Passengers</h6>
                <ul class="list-group list-group-flush">
                    @foreach($requisition->passengers as $passenger)
                    <li class="list-group-item">
                        <i class="fas fa-user-circle"></i> {{ $passenger->name }}
                    </li>
                    @endforeach
                </ul>
                @endif

                @if($requisition->flight_no)
                <hr>
                <h6 class="text-primary"><i class="fas fa-plane"></i> Flight Details</h6>
                <div class="mb-3">
                    <strong>Flight Number:</strong> {{ $requisition->flight_no }}<br>
                    @if($requisition->departure_time)
                    <strong>Departure:</strong> {{ $requisition->departure_time }}<br>
                    @endif
                    @if($requisition->arrival_time)
                    <strong>Arrival:</strong> {{ $requisition->arrival_time }}
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Budget Code Card -->
        @if($requisition->business_unit || $requisition->account || $requisition->contract)
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Budget Code</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($requisition->business_unit)
                    <div class="col-md-4 mb-2">
                        <strong>Business Unit:</strong><br>{{ $requisition->business_unit }}
                    </div>
                    @endif
                    @if($requisition->account)
                    <div class="col-md-4 mb-2">
                        <strong>Account:</strong><br>{{ $requisition->account }}
                    </div>
                    @endif
                    @if($requisition->contract)
                    <div class="col-md-4 mb-2">
                        <strong>Contract:</strong><br>{{ $requisition->contract }}
                    </div>
                    @endif
                    @if($requisition->department)
                    <div class="col-md-4 mb-2">
                        <strong>Department:</strong><br>{{ $requisition->department }}
                    </div>
                    @endif
                    @if($requisition->analysis_code)
                    <div class="col-md-4 mb-2">
                        <strong>Analysis Code:</strong><br>{{ $requisition->analysis_code }}
                    </div>
                    @endif
                    @if($requisition->project_id)
                    <div class="col-md-4 mb-2">
                        <strong>Project ID:</strong><br>{{ $requisition->project_id }}
                    </div>
                    @endif
                    @if($requisition->project_activity)
                    <div class="col-md-4 mb-2">
                        <strong>Project Activity:</strong><br>{{ $requisition->project_activity }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Status Management (Admin Only) -->
        @if(auth()->user()->isAdmin())
        <div class="card mb-3">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Admin Actions</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.requisitions.status', $requisition) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Update Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $requisition->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $requisition->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $requisition->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="completed" {{ $requisition->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assign Driver</label>
                        <input type="text" name="assigned_driver" class="form-control" 
                               value="{{ $requisition->assigned_driver }}" 
                               placeholder="Driver name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assign Vehicle</label>
                        <input type="text" name="assigned_vehicle" class="form-control" 
                               value="{{ $requisition->assigned_vehicle }}" 
                               placeholder="Vehicle number">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Update
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Assignment Details -->
        @if($requisition->assigned_driver || $requisition->assigned_vehicle)
        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Assignment Details</h5>
            </div>
            <div class="card-body">
                @if($requisition->assigned_driver)
                <div class="mb-2">
                    <strong><i class="fas fa-user"></i> Driver:</strong><br>
                    {{ $requisition->assigned_driver }}
                </div>
                @endif
                @if($requisition->assigned_vehicle)
                <div class="mb-2">
                    <strong><i class="fas fa-car"></i> Vehicle:</strong><br>
                    {{ $requisition->assigned_vehicle }}
                </div>
                @endif
                @if($requisition->assigned_at)
                <div class="mb-2">
                    <strong><i class="fas fa-clock"></i> Assigned:</strong><br>
                    {{ $requisition->assigned_at->format('d M Y, h:i A') }}
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Timeline Card -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Timeline</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-plus-circle text-success"></i> <strong>Created</strong><br>
                    <small class="text-muted ms-4">{{ $requisition->created_at->format('d M Y, h:i A') }}</small>
                </div>
                @if($requisition->updated_at != $requisition->created_at)
                <div class="mb-3">
                    <i class="fas fa-edit text-warning"></i> <strong>Last Updated</strong><br>
                    <small class="text-muted ms-4">{{ $requisition->updated_at->format('d M Y, h:i A') }}</small>
                </div>
                @endif
                @if($requisition->assigned_at)
                <div class="mb-3">
                    <i class="fas fa-check-circle text-success"></i> <strong>Assigned</strong><br>
                    <small class="text-muted ms-4">{{ $requisition->assigned_at->format('d M Y, h:i A') }}</small>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection