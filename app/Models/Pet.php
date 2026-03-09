<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use SoftDeletes;

    protected $table = 'pets';

    protected $fillable = [
        'resident_id',
        'flat_id',
        'pet_type',
        'pet_name',
        'pet_age',
        'pet_color',
        'pet_breed',
        'pet_gender',
        'vaccination_status',
        'vaccination_expiry_date',
        'collar_microchip_no',
        'is_dangerous',
        'image',
        'activity_status',
        'deleted_status',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    protected $casts = [
        'vaccination_expiry_date' => 'date',
        'is_dangerous' => 'boolean',
        'activity_status' => 'boolean',
        'deleted_status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the resident that owns the pet
     */
    public function resident()
    {
        return $this->belongsTo(User::class, 'resident_id');
    }

    /**
     * Get the flat where the pet lives
     */
    public function flat()
    {
        return $this->belongsTo(Flat::class, 'flat_id');
    }

    /**
     * Get vaccination status class for styling
     */
    public function getVaccinationStatusClass()
    {
        if ($this->vaccination_status != 'yes' || !$this->vaccination_expiry_date) {
            return 'expired';
        }

        if ($this->vaccination_expiry_date->isPast()) {
            return 'expired';
        }

        if ($this->vaccination_expiry_date->diffInDays(now()) <= 30) {
            return 'expiring';
        }

        return 'vaccinated';
    }

    /**
     * Get vaccination status text
     */
    public function getVaccinationStatusText()
    {
        if ($this->vaccination_status != 'yes' || !$this->vaccination_expiry_date) {
            return 'Not Vaccinated';
        }

        if ($this->vaccination_expiry_date->isPast()) {
            return 'Expired';
        }

        if ($this->vaccination_expiry_date->diffInDays(now()) <= 30) {
            return 'Expiring Soon';
        }

        return 'Vaccinated';
    }
}
