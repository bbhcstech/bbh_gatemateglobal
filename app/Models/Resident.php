<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tower_id',
        'floor_id',
        'flat_id',
        'flat_no',
        'floor',
        'phone',
        'email',
        'type',
    ];

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }
    
     public function flat()
    {
        return $this->belongsTo(Flat::class);
    }
    
    // Resident.php
    public function tower() {
        return $this->belongsTo(Tower::class);
    }
    public function floor() {
        return $this->belongsTo(Floor::class);
    }
    // app/Models/Resident.php
        public function vehicles()
        {
            return $this->hasMany(Vehicle::class);
        }

public function user()
{
    return $this->belongsTo(User::class);
}

}
