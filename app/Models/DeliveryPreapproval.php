<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\DeliveryLog;
use App\Models\DeliveryCompany;

class DeliveryPreapproval extends Model
{
    protected $table = 'delivery_preapprovals';

    protected $fillable = [
        'resident_id',
        'reference_id',
        'tower_name',
        'floor',
        'flat_no',
        'delivery_company_id',
        'delivery_company_name',
        'delivery_person_name',
        'mobile',
        'type',
        'status',
        'expected_time',
        'days_of_week',
        'validity_months',
        'time_from',
        'time_to',
        'entries_per_day',
        'surprise_delivery'
    ];

    protected $casts = [
        'surprise_delivery' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Resident relation
    public function resident()
    {
        return $this->belongsTo(User::class, 'resident_id');
    }

    // Delivery logs relation
    public function logs()
    {
        return $this->hasMany(DeliveryLog::class, 'delivery_preapproval_id');
    }

    // Delivery company relation
    public function company()
    {
        return $this->belongsTo(DeliveryCompany::class, 'delivery_company_id');
    }
}
