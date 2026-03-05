<?php
namespace App\Models;
   use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CabPreapproval extends Model
{
   protected $fillable = [
    'resident_id','reference_id','tower_name','floor','flat_no','company_name',
    'vehicle_number','type','status',
    'expected_time','days_of_week',
    'validity_months','time_from','time_to',
    'entries_per_day'
];

    public function resident()
    {
        return $this->belongsTo(User::class,'resident_id');
    }
    
     public function logs()
    {
        return $this->hasMany(CabLog::class);
    }
}
