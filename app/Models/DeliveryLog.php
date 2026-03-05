<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class DeliveryLog extends Model
{
    protected $fillable = [
        'delivery_preapproval_id',
        'resident_id',
        'delivery_company_name',
        'guard_name',
        'entry_time',
        'exit_time',
    ];
}
