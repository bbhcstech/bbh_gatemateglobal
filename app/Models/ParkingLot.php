<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingLot extends Model
{

    // use HasFactory, SoftDeletes;

    // protected $table = 'parking_slots';

    protected $fillable = [
        'tower_id',
        'floor_id',
        'flat_id',
        'parking_no',
        'type'
    ];

    public function tower()
    {
        return $this->belongsTo(Tower::class);
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }
}
