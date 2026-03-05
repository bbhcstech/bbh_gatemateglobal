<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'direction',
        'is_active',
    ];

    // Future relation (Patrols)
    public function patrols()
    {
        return $this->hasMany(Patrol::class);
    }
}
