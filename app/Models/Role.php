<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
        protected $table = 'role_master';
         protected $primaryKey = 'role_id'; // ✅ VERY IMPORTANT
      protected $fillable = ['role_name', 'role_description'];

    
}