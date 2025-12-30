@extends('layouts.app')

@section('title', 'Create Vehicle Requisition')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-file-alt"></i> Vehicle Requisition Form</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('requisitions.store') }}" method="POST">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary">Staff Information</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Staff Name <span class="text-danger">*</span></label>
                                <input type="text" name="staff_name" class="form-control" value="{{ old('staff_name', auth()->user()->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Designation <span class="text-danger">*</span></label>
                                <input type="text" name="designation" class="form-control" value="{{ old('designation', auth()->user()->designation) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mobile <span class="text-danger">*</span></label>
                                <input type="text" name="mobile" class="form-control" value="{{ old('mobile', auth()->user()->mobile) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Purpose of Trip/Field Visit <span class="text-danger">*</span></label>
                                <textarea name="purpose" class="form-control" rows="3" required>{{ old('purpose') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary">Requisition Type</h5>
                            
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="requisition_type" id="official" value="official" {{ old('requisition_type', 'official') == 'official' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="official">Official</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="requisition_type" id="personal" value="personal" {{ old('requisition_type') == 'personal' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="personal">Personal</label>
                                </div>
                            </div>

                            <h5 class="text-primary mt-4">Duration of Vehicle Use</h5>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Starting Date <span class="text-danger">*</span></label>
                                    <input type="date" name="starting_date" class="form-control" value="{{ old('starting_date') }}" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Starting Time <span class="text-danger">*</span></label>
                                    <input type="time" name="starting_time" class="form-control" value="{{ old('starting_time', '10:00') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Ending Date <span class="text-danger">*</span></label>
                                    <input type="date" name="ending_date" class="form-control" value="{{ old('ending_date') }}" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Ending Time <span class="text-danger">*</span></label>
                                    <input type="time" name="ending_time" class="form-control" value="{{ old('ending_time', '13:00') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary">Passenger Information</h5>
                            <small class="text-muted">Please mention the Name and No. of Passenger</small>
                            
                            <div id="passengers-container">
                                <div class="mb-2">
                                    <label class="form-label">Passenger 1</label>
                                    <input type="text" name="passengers[]" class="form-control" value="{{ old('passengers.0') }}" placeholder="Name of passenger 1">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Passenger 2</label>
                                    <input type="text" name="passengers[]" class="form-control" value="{{ old('passengers.1') }}" placeholder="Name of passenger 2">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Passenger 3</label>
                                    <input type="text" name="passengers[]" class="form-control" value="{{ old('passengers.2') }}" placeholder="Name of passenger 3">
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-passenger">
                                <i class="fas fa-plus"></i> Add More Passengers
                            </button>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary">Flight Details (Optional)</h5>
                            <small class="text-muted">For pick-up/drop from/to Airport</small>
                            
                            <div class="mb-3">
                                <label class="form-label">Flight No.</label>
                                <input type="text" name="flight_no" class="form-control" value="{{ old('flight_no') }}">
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Departure Time</label>
                                    <input type="time" name="departure_time" class="form-control" value="{{ old('departure_time') }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Arrival Time</label>
                                    <input type="time" name="arrival_time" class="form-control" value="{{ old('arrival_time') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary">Addresses</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Address of Pick-up Place <span class="text-danger">*</span></label>
                                <input type="text" name="pickup_address" class="form-control" value="{{ old('pickup_address', 'Oxfam in Bangladesh office') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address of Drop <span class="text-danger">*</span></label>
                                <input type="text" name="drop_address" class="form-control" value="{{ old('drop_address') }}" required placeholder="e.g., Secretariat, Abdul Gani Rd, Dhaka 1000">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary">Budget Code</h5>
                            
                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="form-label">Business Unit</label>
                                    <input type="text" name="business_unit" class="form-control" value="{{ old('business_unit') }}" placeholder="e.g., GL140">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Account</label>
                                    <input type="text" name="account" class="form-control" value="{{ old('account') }}" placeholder="e.g., 45502">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="form-label">Contract</label>
                                    <input type="text" name="contract" class="form-control" value="{{ old('contract') }}" placeholder="e.g., R11745">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Department</label>
                                    <input type="text" name="department" class="form-control" value="{{ old('department') }}" placeholder="Optional">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <label class="form-label">Analysis Code</label>
                                    <input type="text" name="analysis_code" class="form-control" value="{{ old('analysis_code') }}" placeholder="e.g., C0847">
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Project ID</label>
                                    <input type="text" name="project_id" class="form-control" value="{{ old('project_id') }}" placeholder="e.g., BGDD02">
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Project Activity</label>
                                    <input type="text" name="project_activity" class="form-control" value="{{ old('project_activity') }}" placeholder="e.g., AAA">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="text-end">
                        <a href="{{ route('requisitions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Submit Requisition
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('add-passenger').addEventListener('click', function() {
    const container = document.getElementById('passengers-container');
    const count = container.querySelectorAll('input').length + 1;
    
    const div = document.createElement('div');
    div.className = 'mb-2';
    div.innerHTML = `
        <label class="form-label">Passenger ${count}</label>
        <div class="input-group">
            <input type="text" name="passengers[]" class="form-control" placeholder="Name of passenger ${count}">
            <button type="button" class="btn btn-outline-danger btn-sm remove-passenger">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    container.appendChild(div);
    
    // Add event listener to remove button
    div.querySelector('.remove-passenger').addEventListener('click', function() {
        div.remove();
    });
});
</script>
@endpush