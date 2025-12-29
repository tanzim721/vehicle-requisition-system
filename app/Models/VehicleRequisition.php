<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleRequisition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'staff_name',
        'designation',
        'mobile',
        'purpose',
        'starting_date',
        'starting_time',
        'ending_date',
        'ending_time',
        'flight_no',
        'departure_time',
        'arrival_time',
        'business_unit',
        'account',
        'contract',
        'department',
        'analysis_code',
        'project_id',
        'project_activity',
        'pickup_address',
        'drop_address',
        'requisition_type',
        'status',
        'assigned_driver',
        'assigned_vehicle',
        'assigned_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'starting_date' => 'date',
        'ending_date' => 'date',
        'assigned_at' => 'datetime',
    ];

    /**
     * Get the user that owns the requisition
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get passengers for this requisition
     */
    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    /**
     * Scope for pending requisitions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved requisitions
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'completed' => 'info',
            default => 'secondary',
        };
    }
}