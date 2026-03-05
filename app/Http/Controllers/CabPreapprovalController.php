<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CabPreapproval;
use App\Models\CabCompany;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Notification;

class CabPreapprovalController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if ($user->role === 'resident') {

        $cabs = CabPreapproval::where('resident_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
         // echo'<pre>'; print_r($cabs);die;

    } elseif ($user->role === 'security') {

        $cabs = CabPreapproval::whereIn('status', ['expected', 'inside'])
            ->orderBy('created_at', 'desc')
            ->get();

    } else {

        $cabs = CabPreapproval::orderBy('created_at', 'desc')->get();
    }

    // DEBUG (temporarily)
    // dd($cabs->toArray());

    return view('admin.cab.index', compact('cabs'));
}

    public function create()
    {
        $companies = CabCompany::where('is_active',1)->get();
        return view('admin.cab.create',compact('companies'));
    }


    
 
public function store(Request $request)
{
    $request->validate([
        'type' => 'required|in:one_time,frequent',
        'company_name' => 'required|string|max:100',
        'days_of_week' => 'required_if:type,frequent',
        'validity_months' => 'required_if:type,frequent|integer|in:1,3,6',
        'time_from' => 'required_if:type,frequent',
        'time_to' => 'required_if:type,frequent',
        'entries_per_day' => 'required_if:type,frequent|integer|in:1,2',
        'vehicle_number' => 'nullable|string|max:10',
        'expected_time' => 'required_if:type,one_time',
    ]);

    $user = Auth::user();

    $data = [
        'resident_id'    => $user->id,
        'flat_no'        => optional($user->flat)->flat_no,
        'type'           => $request->type,
        'company_name'   => $request->company_name,
        'vehicle_number' => $request->vehicle_number,
        'status'         => 'expected',
    ];

    // ONE TIME
    if ($request->type === 'one_time') {
        $data['expected_time'] = (int) $request->expected_time;
    }

    // FREQUENT
    if ($request->type === 'frequent') {
        $from = Carbon::parse($request->time_from);
        $to   = Carbon::parse($request->time_to);

        $data['expected_time']   = $from->diffInMinutes($to);
        $data['days_of_week']    = $request->days_of_week;
        $data['validity_months'] = $request->validity_months;
        $data['time_from']       = $request->time_from;
        $data['time_to']         = $request->time_to;
        $data['entries_per_day'] = (int) $request->entries_per_day;
    }

    // ✅ CREATE CAB
    $cab = CabPreapproval::create($data);

    // ✅ INSERT NOTIFICATION
    Notification::create([
        'resident_id' => $user->id,
        'reference_id' => $cab->id,
        'type' => 'cab',
        'title' => 'Cab Pre-approved',
        'message' => 'Cab expected for Flat No. ' . $data['flat_no'],
        'is_read' => 0,
        'audience'=>'security',
        'created_at' => now(),
    ]);

    return redirect()->route('cab.index')
        ->with('success', 'Cab entry added successfully');
}


}
