<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = [
        'name',
        'booking_fee',
        'location',
        'capacity',
        'description',
        'rules',
        'is_active',
        'image'
    ];
}
