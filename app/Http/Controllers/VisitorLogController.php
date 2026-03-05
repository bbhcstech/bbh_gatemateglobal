<?php

namespace App\Http\Controllers;
use App\Models\VisitorLog;

use Illuminate\Http\Request;

class VisitorLogController extends Controller
{
       public function entry(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|exists:visitor_preapprovals,id',
            'resident_id' => 'required|exists:users,id',
        ]);
    
        // ✅ CHECK IF VISITOR IS ALREADY INSIDE
        $alreadyInside = VisitorLog::where('visitor_id', $request->visitor_id)
            ->whereNull('exit_time')
            ->exists();
    
        if ($alreadyInside) {
            return back()->with('error', 'Visitor already inside');
        }
    
        // ✅ CREATE NEW ENTRY
        VisitorLog::create([
            'visitor_id' => $request->visitor_id,
            'resident_id' => $request->resident_id,
            'entry_time' => now(),
            'exit_time' => null,
            'verified_by' => auth()->user()->name ?? 'Security',
        ]);
    
        return redirect()->route('visitor.logs.index')
            ->with('success', 'Visitor entry marked');
    }


    public function exit($id)
    {
        $log = VisitorLog::findOrFail($id);
        $log->update(['exit_time'=>now()]);

        return back()->with('success','Visitor exit logged');
    }
    
      public function index()
    {
        $logs = VisitorLog::with(['visitor','resident'])
            ->latest()
            ->get();

        return view('admin.visitor_logs.index', compact('logs'));
    }
    
       public function visitorDetails($id)
    {
        $log = VisitorLog::where('visitor_id', $id)
            ->latest()
            ->first();
    
        if (!$log) {
            return response()->json([
                'entry_time' => null,
                'exit_time' => null,
                'verified_by' => null,
            ]);
        }
    
        return response()->json([
            'entry_time' => $log->entry_time,
            'exit_time' => $log->exit_time,
            'verified_by' => $log->verified_by,
        ]);
    }


}
