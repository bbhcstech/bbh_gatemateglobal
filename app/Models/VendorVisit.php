<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorVisit extends Model
{
    protected $primaryKey = 'visit_id'; // if your table uses visit_id as PK
     protected $fillable = ['vendor_id', 'resident_id', 'visit_date', 'time', 'status'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id'); // specify FK explicitly
    }

    public function resident()
    {
        return $this->belongsTo(User::class, 'resident_id'); // if residents are users
    }
}
