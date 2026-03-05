<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicles';

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Fields
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'resident_id',
        'user_id',
        'vehicle_number',
        'vehicle_type',
        'make',
        'model',
        'color',
        'parking_slot_id',
        'sticker_number',
        // 'insurance_expiry',
        // 'pollution_expiry',
        'status',
        'vehicle_image',
        'activity_status',
        'deleted_status',
        'created_by',
        'modified_by',
        'deleted_by',
        'created_at',
        'updated_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        // 'insurance_expiry' => 'date',
        // 'pollution_expiry' => 'date',
        'activity_status' => 'boolean',
        'deleted_status' => 'boolean',
        'created_on' => 'datetime',
        'modified_on' => 'datetime',
        'deleted_on' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Status Constants (Clean Code)
    |--------------------------------------------------------------------------
    */

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BLACKLISTED = 'blacklisted';

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parkingSlot()
    {
        return $this->belongsTo(ParkingSlot::class, 'parking_slot_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors (Auto Format Vehicle Number)
    |--------------------------------------------------------------------------
    */

    public function setVehicleNumberAttribute($value)
    {
        $this->attributes['vehicle_number'] = strtoupper(str_replace(' ', '', $value));
    }
}
