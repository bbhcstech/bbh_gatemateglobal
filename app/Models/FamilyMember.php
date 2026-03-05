<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $primaryKey = 'member_id';

    protected $fillable = [
        'resident_id',
        'name',
        'relation_id',

        'mobile',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
 public function relation()
    {
        return $this->belongsTo(Relation::class, 'relation_id');
    }
}
