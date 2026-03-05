<?php
namespace App\Http\Controllers;
use App\Models\Notification;

use Illuminate\Http\Request;
use App\Models\CabPreapproval;
use App\Models\CabLog;
use Illuminate\Support\Facades\Auth;

class CabEntryController extends Controller
{
    public function index()
    {
        $expected = CabPreapproval::whereIn('status', ['expected', 'inside','completed'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.cab.entry', compact('expected'));
    }

    // // ENTRY
    // public function entry($id)
    // {
    //     $cab = CabPreapproval::findOrFail($id);

    //     if ($cab->status === 'inside') {
    //         return back()->with('info', 'Cab already inside');
    //     }

    //     CabLog::create([
    //         'cab_preapproval_id' => $cab->id,
    //         'resident_id'        => $cab->resident_id,
    //         'vehicle_number'     => $cab->vehicle_number,
    //         'guard_name'         => Auth::user()->name,
    //         'entry_time'         => now(),
    //     ]);

    //     $cab->update(['status' => 'inside']);

    //     return back()->with('success', 'Cab ENTRY marked');
    // }

    // // EXIT
    // public function exit($id)
    // {
    //     $cab = CabPreapproval::findOrFail($id);

    //     $log = CabLog::where('cab_preapproval_id', $cab->id)
    //         ->whereNull('exit_time')
    //         ->latest()
    //         ->first();

    //     if (!$log) {
    //         return back()->with('error', 'Active cab entry not found');
    //     }

    //     $log->update([
    //         'exit_time' => now(),
    //     ]);

    //     $cab->update(['status' => 'completed']);

    //     return back()->with('success', 'Cab EXIT marked');
    // }
    
    public function entry($id)
{
    $cab = CabPreapproval::findOrFail($id);

    if ($cab->status === 'inside') {
        return back()->with('info', 'Cab already inside');
    }

    CabLog::create([
        'cab_preapproval_id' => $cab->id,
        'resident_id'        => $cab->resident_id,
        'vehicle_number'     => $cab->vehicle_number,
        'guard_name'         => Auth::user()->name,
        'entry_time'         => now(),
    ]);

    $cab->update(['status' => 'inside']);
$cab->save();
    // ✅ SEND NOTIFICATION TO RESIDENT
    Notification::create([
        'resident_id'  => $cab->resident_id,
        'reference_id' => $cab->id,
        'type'         => 'cab',
        'title'        => 'Cab Arrived',
        'message'      => "Your cab ({$cab->company_name}) has entered the gate.",
        'is_read'      => 0,
        'audience'     => 'resident', // if using audience column
    ]);

    return back()->with('success', 'Cab ENTRY marked');
}
public function exit($id)
{
    $cab = CabPreapproval::findOrFail($id);

    $log = CabLog::where('cab_preapproval_id', $cab->id)
        ->whereNull('exit_time')
        ->latest()
        ->first();

    if (!$log) {
        return back()->with('error', 'Active cab entry not found');
    }

    $log->update([
        'exit_time' => now(),
    ]);

    $cab->update(['status' => 'completed']);
   $cab->save();
    // ✅ SEND EXIT NOTIFICATION
    Notification::create([
        'resident_id'  => $cab->resident_id,
        'reference_id' => $cab->id,
        'type'         => 'cab',
        'title'        => 'Cab Exited',
        'message'      => "Your cab ({$cab->company_name}) has exited the gate.",
        'is_read'      => 0,
        'audience'     => 'resident',
    ]);

    return back()->with('success', 'Cab EXIT marked');
}

}
