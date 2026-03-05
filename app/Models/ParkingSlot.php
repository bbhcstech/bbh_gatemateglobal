<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParkingSlot extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'parking_slots';

    protected $fillable = [
        'tower_id',
        'floor_id',
        'flat_id',
        'parking_no',
        'type'
    ];

    protected $casts = [
        'type' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the tower that owns the parking slot
     */
    public function tower()
    {
        return $this->belongsTo(Tower::class);
    }

    /**
     * Get the floor that owns the parking slot
     */
    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    /**
     * Get the flat that owns the parking slot
     */
    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    /**
     * Get the vehicle assigned to this parking slot
     */
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'parking_slot_id');
    }

    /**
     * Scope a query to only include car slots
     */
    public function scopeCarSlots($query)
    {
        return $query->where('type', 'Car');
    }

    /**
     * Scope a query to only include bike slots
     */
    public function scopeBikeSlots($query)
    {
        return $query->where('type', 'Bike');
    }

    /**
     * Scope a query to only include available slots
     */
    public function scopeAvailable($query)
    {
        return $query->whereDoesntHave('vehicle');
    }

    /**
     * Get the full slot name with tower and floor
     */
    public function getFullSlotAttribute()
    {
        $towerName = $this->tower?->name ?? 'N/A';
        $floorName = $this->floor?->name ?? 'N/A';
        return "{$this->parking_no} - {$this->type} (Tower: {$towerName}, Floor: {$floorName})";
    }
}
