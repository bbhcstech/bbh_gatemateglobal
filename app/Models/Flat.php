<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    protected $fillable = ['floor_id', 'flat_no', 'owner_name', 'status'];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function parkingLots()
    {
        return $this->hasMany(ParkingLot::class);
    }

}

