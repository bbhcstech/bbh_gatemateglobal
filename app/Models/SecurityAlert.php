<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityAlert extends Model
{
    protected $primaryKey = 'alert_id';

    protected $fillable = [
        'resident_id',
        'alert_type',
        'message',
        'created_at',
        'status'
    ];
}
