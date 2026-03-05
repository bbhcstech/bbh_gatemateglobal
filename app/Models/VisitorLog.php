<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\VisitorPreapproval;

class VisitorLog extends Model
{
    protected $fillable = [
        'visitor_id',
        'resident_id',
        'entry_time',
        'exit_time',
        'verified_by'
    ];

    public function visitor()
    {
        return $this->belongsTo(VisitorPreapproval::class);
    }

    // ✅ THIS METHOD MUST EXIST
    public function resident()
    {
        return $this->belongsTo(User::class, 'resident_id');
    }
}
