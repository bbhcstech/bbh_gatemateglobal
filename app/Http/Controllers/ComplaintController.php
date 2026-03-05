<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    // List all complaints
    public function index()
{
    if (auth()->user()->role === 'admin') {
        // Admin can see all complaints
        $complaints = Complaint::with('resident')->latest()->get();
    } else {
        // Resident can see only their own complaints
        $resident = Resident::where('user_id', auth()->id())->first();

        if (!$resident) {
            $complaints = collect();   // empty if no resident profile
        } else {
            $complaints = Complaint::with('resident')
                ->where('resident_id', $resident->id)
                ->latest()
                ->get();
        }
    }

    return view('admin.complaints.index', compact('complaints'));
}


    // Show form to create complaint
    public function create()
    {
        $residents = Resident::orderBy('name')->get();
        return view('admin.complaints.create', compact('residents'));
    }

    // Store complaint
    public function store(Request $request)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'type'        => 'required|in:Helping,Maintenance,Security',
            'description' => 'required|string',
        ]);

        Complaint::create($request->all());

        return redirect()->route('complaints.index')
            ->with('success', 'Complaint raised successfully.');
    }

    // Edit complaint
    public function edit(Complaint $complaint)
    {
        $residents = Resident::orderBy('name')->get();
        return view('admin.complaints.create', compact('complaint', 'residents'));
    }

    // Update complaint
    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'type'        => 'required|in:Helping,Maintenance,Security',
            'description' => 'required|string',
            'status'      => 'required|in:Pending,In Progress,Resolved',
        ]);

        $complaint->update($request->all());

        return redirect()->route('complaints.index')
            ->with('success', 'Complaint updated successfully.');
    }

    // Delete complaint
    public function destroy(Complaint $complaint)
    {
        $complaint->delete();
        return redirect()->route('complaints.index')
            ->with('success', 'Complaint deleted successfully.');
    }
    
    // Admin-only: Update complaint status
    public function updateStatus(Request $request, Complaint $complaint)
    {
        // Ensure only admin can update status
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Validate status
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Resolved',
        ]);

        // Update status
        $complaint->status = $request->status;
        $complaint->save();

        return redirect()->route('complaints.index')->with('success', 'Complaint status updated successfully.');
    }
}
