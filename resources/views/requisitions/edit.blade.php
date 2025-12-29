@extends('layouts.app')

@section('title', 'Edit Vehicle Requisition')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Vehicle Requisition #{{ $requisition->id }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('requisitions.update', $requisition) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary">Staff Information</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Staff Name <span class="text-danger">*</span></label>
                                <input type="text" name="staff_name" class="form-control" value="{{ old('staff_name', $requisition->staff_name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Designation <span class="text-danger">*</span></label>
                                <input type="text" name="designation" class="form-control" value="{{ old('designation', $requisition->designation) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mobile <span class="text-danger">*</span></label>
                                <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $requisition->mobile) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Purpose of Trip/Field Visit <span class="text-danger">*</span></label>
                                <textarea name="purpose" class="form-control" rows="3" required>{{ old('purpose', $requisition->purpose) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary">Requisition Type</h5>
                            
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="requisition_type" id="official" value="official" 
                                           {{ old('requisition_type', $requisition->requisition_type) == 'official' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="official">Official</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="requisition_type" id="personal" value="personal" 
                                           {{ old('requisition_type', $requisition->requisition_type) == 'personal' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="personal">Personal</label>
                                </div>
                            </div>

                            <h5 class="text-primary mt-4">Duration of Vehicle Use</h5>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Starting Date <span class="text-danger">*</span></label>
                                    <input type="date" name="starting_date" class="form-control" 
                                           value="{{ old('starting_date', $requisition->starting_date->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Starting Time <span class="text-danger">*</span></label>
                                    <input type="time" name="starting_time" class="form-control" 
                                           value="{{ old('starting_time', $requisition->starting_time) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Ending Date <span class="text-danger">*</span></label>
                                    <input type="date" name="ending_date" class="form-control" 
                                           value="{{ old('ending_date', $requisition->ending_date->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Ending Time <span class="text-danger">*</span></label>
                                    <input type="time" name="ending_time" class="form-control" 
                                           value="{{ old('ending_time', $requisition->ending_time) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary">Passenger Information</h5>
                            
                            <div id="passengers-container">
                                @foreach($requisition->passengers as $index => $passenger)
                                <div class="mb-2">
                                    <label class="form-label">Passenger {{ $index + 1 }}</label>
                                    <input type="text" name="passengers[]" class="form-control" 
                                           value="{{ old('passengers.' . $index, $passenger->name) }}" 
                                           placeholder="Name of passenger {{ $index + 1 }}">
                                </div>
                                @endforeach
                                
                                @if($requisition->passengers->count() == 0)
                                <div class="mb-2">
                                    <label class="form-label">Passenger 1</label>
                                    <input type="text" name="passengers[]" class="form-control" placeholder="Name of passenger 1">
                                </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-passenger">
                                <i class="fas fa-plus"></i> Add More Passengers
                            </button>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary">Flight Details (Optional)</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Flight No.</label>
                                <input type="text" name="flight_no" class="form-control" 
                                       value="{{ old('flight_no', $requisition->flight_no) }}">
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Departure Time</label>
                                    <input type="time" name="departure_time" class="form-control" 
                                           value="{{ old('departure_time', $requisition->departure_time) }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Arrival Time</label>
                                    <input type="time" name="arrival_time" class="form-control" 
                                           value="{{ old('arrival_time', $requisition->arrival_time) }}">
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
                                <input type="text" name="pickup_address" class="form-control" 
                                       value="{{ old('pickup_address', $requisition->pickup_address) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address of Drop <span class="text-danger">*</span></label>
                                <input type="text" name="drop_address" class="form-control" 
                                       value="{{ old('drop_address', $requisition->drop_address) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary">Budget Code</h5>
                            
                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="form-label">Business Unit</label>
                                    <input type="text" name="business_unit" class="form-control" 
                                           value="{{ old('business_unit', $requisition->business_unit) }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Account</label>
                                    <input type="text" name="account" class="form-control" 
                                           value="{{ old('account', $requisition->account) }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="form-label">Contract</label>
                                    <input type="text" name="contract" class="form-control" 
                                           value="{{ old('contract', $requisition->contract) }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Department</label>
                                    <input type="text" name="department" class="form-control" 
                                           value="{{ old('department', $requisition->department) }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <label class="form-label">Analysis Code</label>
                                    <input type="text" name="analysis_code" class="form-control" 
                                           value="{{ old('analysis_code', $requisition->analysis_code) }}">
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Project ID</label>
                                    <input type="text" name="project_id" class="form-control" 
                                           value="{{ old('project_id', $requisition->project_id) }}">
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Project Activity</label>
                                    <input type="text" name="project_activity" class="form-control" 
                                           value="{{ old('project_activity', $requisition->project_activity) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="text-end">
                        <a href="{{ route('requisitions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update Requisition
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
    
    div.querySelector('.remove-passenger').addEventListener('click', function() {
        div.remove();
    });
});
</script>
@endpush