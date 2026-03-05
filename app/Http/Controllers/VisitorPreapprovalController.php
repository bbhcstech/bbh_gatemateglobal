<?php

namespace App\Http\Controllers;
use App\Models\VisitorPreapproval; 
use App\Models\Visitor;
use App\Models\Resident;
use App\Models\Notification;
use Illuminate\Http\Request;

class VisitorPreapprovalController extends Controller
{
    public function index()
    {
        $approvals = VisitorPreapproval::with('visitor','resident')->latest()->get();
        return view('admin.visitors.preapproval.index', compact('approvals'));
    }

    public function create()
    {
        $visitors = Visitor::all();
        return view('admin.visitors.preapproval.create', compact('visitors'));
    }

  

public function store(Request $request)
{
    
  //  print_r($request);die;
    $request->validate([
        'name' => 'required',
    
    'phone' => ['required','digits:10','regex:/^[6-9]\d{9}$/'],

        // 'visitor_id' => 'required|exists:visitors,id',
       
        'visit_date' => 'required|date',
        'expected_time' => 'required',
         'image' => 'nullable|image',
        'purpose' => 'required'
    ]);
    
   
    // ✅ Profile Picture Upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time().'_visitor.'.$image->extension();
        $image->move(public_path('uploads/visitors'), $imageName);
        $userimage = 'uploads/visitors/'.$imageName;
    }

    $preapproval = VisitorPreapproval::create([
        'resident_id'   => auth()->id(),
        'name'    => $request->name,
        'phone'    => $request->phone,
        'purpose'    => $request->purpose,
        'image'    => $userimage,
        // 'visitor_id'    => $request->visitor_id,
        'visit_date'    => $request->visit_date,
        'expected_time' => $request->expected_time,
        'status'        => 'pending',
        'created_by'    =>auth()->id()
    ]);

    // Fetch visitor details for message
    //$visitor = Visitor::find($request->visitor_id);
    
    // Get resident name
    $residentName = auth()->user()->name;

    // Format date and time nicely
    $visitDate = date('d M Y', strtotime($request->visit_date));
    $visitTime = date('h:i A', strtotime($request->expected_time));

   // CREATE SECURITY NOTIFICATION
    Notification::create([
        'resident_id'  =>  null,   // SECURITY notification
        'reference_id' => $preapproval->id,   // IMPORTANT LINE ADDED
        'type'        => 'visitor',
        'title'        => 'New Visitor Pre-Approval',
        'message'      => "Visitor {$request->name} will come to visit {$residentName} on {$visitDate} at {$visitTime}. Pre-approval created, waiting for approval to visit {$residentName}.",
        'is_read'      => 0,
        'audience'=>'security'
    ]);

    return redirect()->route('visitor-preapproval.index')
        ->with('success','Visitor pre-approval requested and security notified');
}


    public function approve($id)
    {
        $approval = VisitorPreapproval::findOrFail($id);
        $approval->update(['status'=>'approved']);

        return back()->with('success','Visitor approved');
    }
    
    public function edit($id)
{
    $approval = VisitorPreapproval::findOrFail($id);

    $residents = Resident::all();

    return view('admin.visitors.preapproval.edit', compact('approval', 'residents'));
}

public function destroy($id)
{
    $preapproval = VisitorPreapproval::findOrFail($id);

    // Delete Image if exists
    if ($preapproval->image && file_exists(public_path($preapproval->image))) {
        unlink(public_path($preapproval->image));
    }

    $preapproval->delete();

    // Notification after delete
    Notification::create([
        'resident_id' => auth()->id(),
        'title' => 'Visitor Pre-Approval Deleted',
        'message' => 'Pre-approval record for visitor ' . $preapproval->name . ' has been deleted.',
        'is_read' => 0,
        'audience'=>'security'
    ]);

    return redirect()->route('visitor-preapproval.index')
        ->with('success', 'Visitor pre-approval deleted successfully');
}

public function update(Request $request, $id)
{
    $preapproval = VisitorPreapproval::findOrFail($id);

    $request->validate([
        'name' => 'required',
            'phone' => ['required','digits:10','regex:/^[6-9]\d{9}$/'],
        'visit_date' => 'required|date',
        'expected_time' => 'required',
        'image' => 'nullable|image',
        'purpose' => 'required'
    ]);

    $userimage = $preapproval->image; // keep old image by default

    // Handle Image Upload
    if ($request->hasFile('image')) {

        // Delete old image if exists
        if ($preapproval->image && file_exists(public_path($preapproval->image))) {
            unlink(public_path($preapproval->image));
        }

        $image = $request->file('image');
        $imageName = time().'_visitor.'.$image->extension();
        $image->move(public_path('uploads/visitors'), $imageName);

        $userimage = 'uploads/visitors/'.$imageName;
    }

    $preapproval->update([
        'name' => $request->name,
        'phone' => $request->phone,
        'purpose' => $request->purpose,
        'image' => $userimage,
        'visit_date' => $request->visit_date,
        'expected_time' => $request->expected_time
    ]);
    
    // Get resident name
    $residentName = auth()->user()->name;

    // Format date and time nicely
    $visitDate = date('d M Y', strtotime($request->visit_date));
    $visitTime = date('h:i A', strtotime($request->expected_time));

    // CREATE UPDATE NOTIFICATION
  
Notification::create([
    'resident_id'  =>  null,   // SECURITY notification
    'reference_id' => $preapproval->id,
    'title'        => 'Visitor Pre-Approval Updated',
    'message'      => 'Pre-approval updated for visitor: ' . $request->name . ' on ' . $visitDate . ' at ' . $visitTime,
    'is_read'      => 0,
    'audience'=>'security'
]);

    return redirect()->route('visitor-preapproval.index')
        ->with('success', 'Visitor pre-approval updated successfully');
}
public function getResident($id)
{
    $visitor = VisitorPreapproval::find($id);

    if (!$visitor) {
        return response()->json(['error' => 'Visitor not found']);
    }

    return response()->json([
        'resident_id' => $visitor->resident_id
    ]);
}



}
