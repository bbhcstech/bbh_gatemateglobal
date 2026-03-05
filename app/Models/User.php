<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Profilepicture;
use App\Models\Document;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'role',
        'role_id',
        'tower_id',
        'floor_id',
        'flat_id',
        'parking_id',
        'documents',
        'documents_id',
        'profile_pic_id',
        'whatsapp_no',
        'profile_pic',
        'is_active',
        'otp_verified',
        'approval_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function hasRole($role)
    {
        return $this->role === $role;
    }
    
    
    public function isAdmin()
{
    return $this->role === 'admin';
}

public function isSecurity()
{
    return $this->role === 'security';
}
public function resident()
{
    return $this->hasOne(Resident::class);
}

public function tower()
{
    return $this->belongsTo(Tower::class);
}

public function floor()
{
    return $this->belongsTo(Floor::class);
}

public function flat()
{
    return $this->belongsTo(Flat::class);
}
public function parking()
{
    return $this->belongsTo(ParkingLot::class, 'parking_id');
}
public function roleMaster()
{
    return $this->belongsTo(Role::class, 'role_id', 'role_id');
}



public function profilePicture()
{
    return $this->belongsTo(Profilepicture::class, 'profile_pic_id', 'profile_pic_id');
}

public function document()
{
    return $this->belongsTo(Document::class, 'documents_id', 'documents_id');
}

public function getRoleNameAttribute()
{
    return strtolower(optional($this->roleMaster)->role_name);
}
}
