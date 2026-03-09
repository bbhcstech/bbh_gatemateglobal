<?php
namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class Relation extends Model
{
    protected $table = 'relations';

    protected $fillable = ['name', 'status'];

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'relation_id', 'id');
    }
}
