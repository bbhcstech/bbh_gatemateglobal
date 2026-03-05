<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpAttendance extends Model
{
    protected $table = 'help_attendance';
    protected $primaryKey = 'attendance_id';

    protected $fillable = ['help_id','date','entry_time','exit_time','marked_by'];

    public function help()
    {
        return $this->belongsTo(DomesticHelp::class,'help_id');
    }
}
