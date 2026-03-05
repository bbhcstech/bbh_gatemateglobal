<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Tower extends Model
{
    protected $fillable = ['name', 'total_floors'];

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }
}
