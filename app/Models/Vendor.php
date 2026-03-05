<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $primaryKey = 'vendor_id';
    protected $fillable = ['name', 'service_type', 'mobile'];

    public function visits()
    {
        return $this->hasMany(VendorVisit::class, 'vendor_id');
    }
}
