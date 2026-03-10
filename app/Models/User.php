<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Profilepicture;
use App\Models\Document;
use App\Models\FamilyMember;
use App\Models\Pet;
use App\Models\Vehicle;

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
        'approval_status',
        'bio',
        'occupation',
        'flat_number',
        'email_notifications',
        'sms_notifications',
        'whatsapp_notifications',
        'resident_id'
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
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'whatsapp_notifications' => 'boolean',
        ];
    }

    // Role check methods
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

    public function isResident()
    {
        return $this->role === 'resident';
    }

    // ============= EXISTING RELATIONSHIPS =============

    public function resident()
    {
        return $this->hasOne(Resident::class, 'user_id');
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

    // ============= NEW RELATIONSHIPS TO ADD =============

    /**
     * Get the family members for the user.
     */
    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'resident_id');
    }

    /**
     * Get the pets for the user.
     */
    public function pets()
    {
        return $this->hasMany(Pet::class, 'resident_id');
    }

    /**
     * Get the vehicles for the user.
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'user_id');
    }

    // ============= HELPER METHODS FOR SAFE COUNTING =============

    /**
     * Get family members count safely
     */
    public function getFamilyMembersCountAttribute()
    {
        return $this->familyMembers ? $this->familyMembers->count() : 0;
    }

    /**
     * Get pets count safely
     */
    public function getPetsCountAttribute()
    {
        return $this->pets ? $this->pets->count() : 0;
    }

    /**
     * Get vehicles count safely
     */
    public function getVehiclesCountAttribute()
    {
        return $this->vehicles ? $this->vehicles->count() : 0;
    }

    /**
     * Check if user has any document
     */
    public function getHasDocumentAttribute()
    {
        return $this->document !== null;
    }

    /**
     * ============= FIXED PROFILE PICTURE METHODS =============
     */

    /**
     * Get the profile picture URL with fallback to default
     * This is the main method you should use in views
     */
    public function getProfilePictureUrlAttribute()
    {
        // Check if profile picture relationship exists and has file_path
        if ($this->profilePicture && !empty($this->profilePicture->file_path)) {
            $fullPath = public_path($this->profilePicture->file_path);

            // Check if file actually exists on server
            if (file_exists($fullPath)) {
                return asset($this->profilePicture->file_path);
            }

            // Log missing file for debugging
            \Log::warning('Profile picture file missing: ' . $this->profilePicture->file_path . ' for user: ' . $this->id);
        }

        // Return default avatar if no profile picture or file missing
        return asset('admin/assets/img/default-avatar.png');
    }

    /**
     * Alias method for backward compatibility
     */
    public function getProfilePicAttribute()
    {
        return $this->profile_picture_url;
    }

    /**
     * Get raw profile picture path (for debugging)
     */
    public function getProfilePicturePathAttribute()
    {
        if ($this->profilePicture && !empty($this->profilePicture->file_path)) {
            return $this->profilePicture->file_path;
        }
        return null;
    }
}
