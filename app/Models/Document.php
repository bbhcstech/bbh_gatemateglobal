<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'documents_id';
    public $timestamps = false; // using custom audit fields

    protected $fillable = [
        'name',
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

    /**
     * 🔗 Document belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}