<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ADD THIS IMPORT

class FamilyMember extends Model
{
    use HasFactory, SoftDeletes; // ADD SoftDeletes HERE

    protected $primaryKey = 'member_id';

    protected $fillable = [
        'resident_id',
        'name',
        'relation_id',
        'mobile',
        // Add these for audit trail
        'activity_status',
        'deleted_status',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    // Casts for proper data types
    protected $casts = [
        'activity_status' => 'boolean',
        'deleted_status' => 'boolean',
        'deleted_at' => 'datetime', // This will work with SoftDeletes
    ];

    // Relationships
    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function relation()
    {
        return $this->belongsTo(Relation::class, 'relation_id');
    }

    // Optional: Audit trail relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Optional: Scope for active records
    public function scopeActive($query)
    {
        return $query->where('activity_status', 1)
                     ->where('deleted_status', 0);
    }

    // OPTIONAL: If you want to automatically set deleted_by when soft deleting
    protected static function booted()
    {
        static::deleting(function ($familyMember) {
            if (auth()->check()) {
                $familyMember->deleted_by = auth()->id();
                $familyMember->deleted_status = 1;
                $familyMember->save();
            }
        });

        static::restoring(function ($familyMember) {
            $familyMember->deleted_by = null;
            $familyMember->deleted_status = 0;
        });
    }
}
