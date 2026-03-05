<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\Resident;
use App\Models\Notification;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::with('resident')->latest()->get();
        
        
        return view('admin.visitors.index', compact('visitors'));
    }

    public function create()
    {
        $residents = Resident::all();
        return view('admin.visitors.create', compact('residents'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'resident_id' => 'required|exists:residents,id',
        'expected_arrival' => 'required|date',
        'vehicle_number' => 'nullable',
        'image' => 'nullable|image',
        'purpose' => 'required',
        'notes' => 'nullable',
    ]);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('visitors', 'public');
    }

    $visitor = Visitor::create($data);

    // ---------------- SEND NOTIFICATION TO RESIDENT ----------------

    Notification::create([
        'resident_id' => $request->resident_id,

        'title' => 'New Visitor Added',

        'message' =>
            'Security added visitor "' . $visitor->name .
            '" for you. Expected at ' .
            $visitor->expected_arrival,

        'is_read' => 0,

        'created_at' => now()
    ]);

    // ---------------------------------------------------------------

    return redirect()->route('visitors.index')
        ->with('success', 'Visitor added successfully');
}


    public function edit(Visitor $visitor)
    {
        $residents = Resident::all();
        return view('admin.visitors.edit', compact('visitor', 'residents'));
    }

    public function update(Request $request, Visitor $visitor)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'resident_id' => 'required|exists:residents,id',
            'expected_arrival' => 'required|date',
            'vehicle_number' => 'nullable',
            'image' => 'nullable|image',
            'purpose' => 'required',
            'notes' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            if ($visitor->image) {
                Storage::disk('public')->delete($visitor->image);
            }
            $data['image'] = $request->file('image')->store('visitors', 'public');
        }

        $visitor->update($data);

        return redirect()->route('visitors.index')->with('success', 'Visitor updated successfully');
    }

    public function destroy(Visitor $visitor)
    {
        if ($visitor->image) {
            Storage::disk('public')->delete($visitor->image);
        }

        $visitor->delete();

        return redirect()->route('visitors.index')->with('success', 'Visitor deleted successfully');
    }
}
