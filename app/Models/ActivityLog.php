<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $primaryKey = 'activity_id';

    protected $fillable = [
        'type',
        'reference_id',
        'resident_id',
        'description',
        'time'
    ];
}
