<?php
// app/Models/Floor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $table = 'floors';
    protected $primaryKey = 'floor_id';

    protected $fillable = [
        'tower_id',
        'floor_number',
        'floor_name',
        'status'
    ];

    /**
     * Relationship with Tower
     */
    public function tower()
    {
        return $this->belongsTo(Tower::class, 'tower_id', 'tower_id');
    }

    /**
     * Relationship with Flats
     */
    public function flats()
    {
        return $this->hasMany(Flat::class, 'floor_id', 'floor_id');
    }
}
