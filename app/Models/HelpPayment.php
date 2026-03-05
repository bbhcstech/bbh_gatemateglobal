<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpPayment extends Model
{
    protected $table = 'help_payments';
    protected $primaryKey = 'payment_id';

    protected $fillable = ['help_id','name','amount','month','payment_mode','mobile','notes','paid_on'];
}
