<?php

namespace App\Http\Controllers;

use App\Models\HelpAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HelpAttendanceController extends Controller
{
    public function index()
    {
        $attendance = DB::table('help_attendance')->latest()->get();
        return view('admin.help.attendance.index', compact('attendance'));
    }
    
    
     public function create()
    {
        return view('admin.help.attendance.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'help_id' => 'required',
            'date' => 'required|date',
            'entry_time' => 'required',
            'exit_time' => 'nullable'
        ]);

        DB::table('help_attendance')->insert([
            'help_id' => $request->help_id,
            'date' => $request->date,
            'entry_time' => $request->entry_time,
            'exit_time' => $request->exit_time,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('help.attendance.index')
            ->with('success', 'Attendance added successfully');
    }
}
