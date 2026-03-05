<?php
namespace App\Models;
   use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class VisitorPreapproval extends Model
{
    protected $fillable = [
        'resident_id',
        'name',
        'phone',
        'image',
        'purpose',
        'visitor_id',
        'visit_date',
        'expected_time',
        'qr_code',
        'status'
    ];

    public function visitor() {
        return $this->belongsTo(Visitor::class);
    }

 

public function resident()
{
    return $this->belongsTo(User::class, 'resident_id');
}

}
