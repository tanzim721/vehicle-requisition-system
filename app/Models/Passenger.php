<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vehicle_requisition_id',
        'name',
        'order',
    ];

    /**
     * Get the vehicle requisition that owns the passenger
     */
    public function vehicleRequisition()
    {
        return $this->belongsTo(VehicleRequisition::class);
    }
}