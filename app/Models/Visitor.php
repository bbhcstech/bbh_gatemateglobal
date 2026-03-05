<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'type',
        'resident_id',
        'expected_arrival',
        'vehicle_number',
        'image',
        'purpose',
        'notes',
        'status'
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
