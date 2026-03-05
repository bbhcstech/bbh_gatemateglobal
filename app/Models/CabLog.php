<?php
namespace App\Models;
   use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CabLog extends Model
{
    protected $fillable = [
        'cab_preapproval_id',
        'resident_id',
        'vehicle_number',
        'guard_name',
        'entry_time',
        'exit_time'
    ];
    
    
    public function preapproval()
    {
        return $this->belongsTo(CabPreapproval::class);
    }
}
