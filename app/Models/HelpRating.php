<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpRating extends Model
{
    protected $table = 'help_ratings';
    protected $primaryKey = 'rating_id';

    protected $fillable = ['help_id','resident_id','rating','feedback'];
}
