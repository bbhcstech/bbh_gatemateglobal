<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = ['tower_id', 'floor_no'];

    public function tower()
    {
        return $this->belongsTo(Tower::class);
    }

    public function flats()
    {
        return $this->hasMany(Flat::class);
    }
}
