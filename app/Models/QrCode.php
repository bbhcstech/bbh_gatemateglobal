<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class QrCode extends Model
{
use HasFactory;


protected $fillable = [
'user_id','name','category','type','payload','format','size','error_correction',
'foreground','background','eye','logo_path','file_path','slug'
];


protected $casts = [
'payload' => 'array',
'size' => 'integer',
];


protected static function booted()
{
static::creating(function ($model) {
if (!$model->slug) {
$model->slug = Str::ulid();
}
});
}


public function getPublicUrlAttribute(): ?string
{
return $this->file_path ? asset('storage/'.ltrim($this->file_path, '/')) : null;
}
}