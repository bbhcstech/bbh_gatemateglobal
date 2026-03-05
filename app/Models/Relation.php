<?php
namespace App\Models;
   use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
   protected $fillable = [
    'name','status'
];
public function familyMembers()
{
    return $this->hasMany(FamilyMember::class);
}

}