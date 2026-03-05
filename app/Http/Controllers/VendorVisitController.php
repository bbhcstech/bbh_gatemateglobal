<?php
namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\VendorVisit;
use App\Models\User;
use Illuminate\Http\Request;

class VendorVisitController extends Controller
{
    public function index()
    {
        $visits = VendorVisit::with(['vendor','resident'])->latest()->get();
        return view('admin.vendor_visits.index', compact('visits'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        $residents = User::where('role','resident')->get();
        return view('admin.vendor_visits.create', compact('vendors','residents'));
    }

  public function store(Request $request)
{
    // Create new vendor if selected
    if($request->vendor_id === 'new') {
        $request->validate([
            'new_vendor_name' => 'required|string|max:255',
            'new_vendor_service' => 'required|string|max:255',
            'new_vendor_mobile' => 'required|string|max:15',
        ]);

        $vendor = Vendor::create([
            'name' => $request->new_vendor_name,
            'service_type' => $request->new_vendor_service,
            'mobile' => $request->new_vendor_mobile,
        ]);

        $vendor_id = $vendor->id; // ✅ Use id here
    } else {
        $vendor_id = $request->vendor_id;
    }

    // Validate rest
    $request->validate([
        'resident_id' => 'required|exists:users,id',
        'visit_date' => 'required|date',
        'time' => 'required',
    ]);

    // Insert into vendor_visits
    VendorVisit::create([
        'vendor_id' => $vendor_id,
        'resident_id' => $request->resident_id,
        'visit_date' => $request->visit_date,
        'time' => $request->time,
        'status' => 'Scheduled', // ✅ default status
    ]);

    return redirect()->route('vendor-visits.index')->with('success', 'Vendor Visit added successfully.');
}



    public function edit(VendorVisit $vendorVisit)
    {
        $vendors = Vendor::all();
        $residents = User::where('role','resident')->get();
        return view('admin.vendor_visits.edit', compact('vendorVisit','vendors','residents'));
    }

   public function update(Request $request, VendorVisit $vendorVisit)
{
    $request->validate([
        'vendor_id'   => 'required|exists:vendors,vendor_id', // ✅ use vendor_id
        'resident_id' => 'required|exists:users,id',
        'visit_date'  => 'required|date',
        'time'        => 'required',
        'status'      => 'required|in:Scheduled,In,Out,Cancelled',
    ]);

    $vendorVisit->update([
        'vendor_id'   => $request->vendor_id,
        'resident_id' => $request->resident_id,
        'visit_date'  => $request->visit_date,
        'time'        => $request->time,
        'status'      => $request->status,
    ]);

    return redirect()->route('vendor-visits.index')->with('success','Vendor visit updated.');
}



    public function destroy(VendorVisit $vendorVisit)
    {
        $vendorVisit->delete();
        return back()->with('success','Vendor visit deleted.');
    }
}
