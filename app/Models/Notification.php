<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Notification extends Model
{
      protected $primaryKey = 'notification_id';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $casts = [
        'is_read' => 'integer',
    ];
    public $timestamps = true; 
    protected $fillable = [
        'resident_id',
        'reference_id',
        'type',
        'title',
        'message',
        'is_read',
        'audience'
    ];
}

