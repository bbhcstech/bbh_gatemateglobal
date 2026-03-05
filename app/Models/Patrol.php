<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patrol extends Model
{
    protected $fillable = [
        'security_guard_id',
        'zone_id',
        'start_time',
        'end_time',
        'checkpoints',
        'status',
        'notes'
    ];

    public function securityGuard()
    {
        return $this->belongsTo(SecurityGuard::class, 'security_guard_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
    

}


