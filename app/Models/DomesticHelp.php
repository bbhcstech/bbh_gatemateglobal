<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomesticHelp extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'phone',
        'service',
        'vehicle_number',
        'image',
        'documents',
        'notes'
    ];

   
    public function resident()
    {
        return $this->belongsTo(User::class,'resident_id');
    }

    public function attendance()
    {
        return $this->hasMany(HelpAttendance::class,'help_id');
    }

    public function payments()
    {
        return $this->hasMany(HelpPayment::class,'help_id');
    }

    public function ratings()
    {
        return $this->hasMany(HelpRating::class,'help_id');
    }
}
