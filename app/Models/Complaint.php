<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'resident_id',
        'title',
        'description',
        'type',
        'priority',
        'status',
        'attachment',
        'confirmed_by_resident',
        'confirmed_at'
    ];

    protected $casts = [
        'confirmed_by_resident' => 'boolean',
        'confirmed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the resident who raised the complaint
     */
    public function resident()
    {
        return $this->belongsTo(User::class, 'resident_id');
    }

    /**
     * Scope a query to only include pending complaints
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include in progress complaints
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in progress');
    }

    /**
     * Scope a query to only include resolved complaints
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    /**
     * Check if complaint is resolved and confirmed
     */
    public function isFullyResolved()
    {
        return $this->status === 'resolved' && $this->confirmed_by_resident;
    }

    /**
     * Get the status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'status-pending',
            'in progress' => 'status-progress',
            'resolved' => 'status-resolved',
            default => 'status-pending'
        };
    }

    /**
     * Get the priority badge class
     */
    public function getPriorityBadgeClassAttribute()
    {
        return match($this->priority) {
            'high' => 'priority-high',
            'medium' => 'priority-medium',
            'low' => 'priority-low',
            default => 'priority-medium'
        };
    }
}
