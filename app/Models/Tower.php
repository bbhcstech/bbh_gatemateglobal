<?php
// app/Models/Tower.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tower extends Model
{
    protected $table = 'towers';
    protected $primaryKey = 'tower_id';

    protected $fillable = [
        'tower_name',
        'tower_code',
        'total_floors',
        'status',
        'address'
    ];

    /**
     * Relationship with Floors
     */
    public function floors()
    {
        return $this->hasMany(Floor::class, 'tower_id', 'tower_id');
    }

    /**
     * Relationship with Flats (through floors)
     */
    public function flats()
    {
        return $this->hasManyThrough(
            Flat::class,
            Floor::class,
            'tower_id', // Foreign key on floors table
            'floor_id', // Foreign key on flats table
            'tower_id', // Local key on towers table
            'floor_id'  // Local key on floors table
        );
    }
}
