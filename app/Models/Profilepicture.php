<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePicture extends Model
{
    protected $table = 'profile_picture';
    protected $primaryKey = 'profile_pic_id';
    public $timestamps = false; // you are using custom audit fields

    protected $fillable = [
        'user_id',
        'file_path',
        'activity_status',
        'deleted_status',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'deleted_by',
        'deleted_on'
    ];

    // 🔥 relation back to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}