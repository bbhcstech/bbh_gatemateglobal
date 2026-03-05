<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'resident_id',
        'type',
        'name',
        'age',
        'color',
        'image'
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
    
    public function petType()
{
    return $this->belongsTo(PetsName::class, 'pet_name_id');
}

}
