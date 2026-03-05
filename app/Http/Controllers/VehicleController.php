<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Resident;
use App\Models\ParkingSlot; // ✅ Added for parking slots
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        // Fix: Show vehicles based on user role
        if (auth()->user()->role === 'admin') {
            // Admin sees all vehicles
            $vehicles = Vehicle::with('resident')->latest()->get();
        } else {
            // Resident sees only their vehicles
            $vehicles = Vehicle::with('resident')->where('user_id', auth()->id())->latest()->get();
        }

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        // Get all residents for dropdown
        $residents = Resident::with('flat')->orderBy('name')->get();

        // ✅ Get all parking slots from master table
        $parkingSlots = ParkingSlot::all();

        return view('admin.vehicles.create', compact('residents', 'parkingSlots'));
    }

    public function store(Request $request)
    {
        // ✅ Updated validation to match new database structure
        $request->validate([
            'vehicle_number' => 'required|string|max:20|unique:vehicles,vehicle_number',
            'sticker_number' => 'nullable|string|max:255',
            'vehicle_type'   => 'required|string|max:255',
            'make'           => 'nullable|string|max:255',
            'model'          => 'nullable|string|max:255',
            'color'          => 'required|string|max:50',
            'resident_id'    => 'required|exists:residents,id',
            'parking_slot_id' => 'nullable|exists:parking_slots,id', // ✅ Updated field name
            'vehicle_image'  => 'nullable|image|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('vehicle_image')) {
            $image = $request->file('vehicle_image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/vehicles'), $filename);
            $imagePath = 'uploads/vehicles/' . $filename;
        }

        // Get resident to get user_id and owner_name
        $resident = Resident::find($request->resident_id);

        // ✅ Create vehicle with proper fields
        Vehicle::create([
            'vehicle_number' => strtoupper(str_replace(' ', '', $request->vehicle_number)),
            'user_id' => $resident->user_id ?? auth()->id(),
            'sticker_number' => $request->sticker_number,
            'vehicle_type'   => $request->vehicle_type,
            'make'           => $request->make,
            'model'          => $request->model,
            'color'          => $request->color,
            'parking_slot_id' => $request->parking_slot_id, // ✅ Updated field
            'resident_id'    => $request->resident_id,
            'vehicle_image'  => $imagePath,
            'status'         => $request->has('is_approved') ? 'approved' : 'pending', // ✅ Using status enum
            'activity_status' => 1,
            'created_by'     => auth()->id(),
        ]);

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle added successfully');
    }

    public function edit(Vehicle $vehicle)
    {
        // Check permission
        if (auth()->user()->role !== 'admin' && $vehicle->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $residents = Resident::with('flat')->orderBy('name')->get();
        $parkingSlots = ParkingSlot::all(); // ✅ Add parking slots for edit page

        return view('admin.vehicles.edit', compact('vehicle', 'residents', 'parkingSlots'));
    }

    public function update(Request $request, Vehicle $vehicle)
{
    // Check permission
    if (auth()->user()->role !== 'admin' && $vehicle->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    // Validate request
    $request->validate([
        'vehicle_number' => 'required|string|max:20|unique:vehicles,vehicle_number,' . $vehicle->id,
        'sticker_number' => 'nullable|string|max:255',
        'vehicle_type'   => 'required|string|max:255',
        'make'           => 'nullable|string|max:255',
        'model'          => 'nullable|string|max:255',
        'color'          => 'required|string|max:50',
        'resident_id'    => 'required|exists:residents,id',
        'parking_slot_id' => 'nullable|exists:parking_slots,id',
        'vehicle_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'status'         => 'nullable|in:pending,approved,rejected,inactive,blacklisted', // Add this
    ]);

    // Handle image upload (same as before)
    $imagePath = $vehicle->vehicle_image;
    if ($request->hasFile('vehicle_image')) {
        // Delete old image
        if ($vehicle->vehicle_image && file_exists(public_path($vehicle->vehicle_image))) {
            unlink(public_path($vehicle->vehicle_image));
        }

        // Upload new image
        $image = $request->file('vehicle_image');
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._]/', '', $image->getClientOriginalName());
        $image->move(public_path('uploads/vehicles'), $filename);
        $imagePath = 'uploads/vehicles/' . $filename;
    }

    // Get resident for user_id
    $resident = Resident::find($request->resident_id);

    if (!$resident) {
        return back()->withErrors(['resident_id' => 'Selected resident not found'])->withInput();
    }

    // Determine status
    $status = $request->status ?? ($request->has('is_approved') ? 'approved' : $vehicle->status);

    // Update vehicle with proper fields
    $vehicle->update([
        'vehicle_number' => strtoupper(str_replace(' ', '', $request->vehicle_number)),
        'user_id' => $resident->user_id,
        'sticker_number' => $request->sticker_number,
        'vehicle_type'   => $request->vehicle_type,
        'make'           => $request->make,
        'model'          => $request->model,
        'color'          => $request->color,
        'parking_slot_id' => $request->parking_slot_id,
        'resident_id'    => $request->resident_id,
        'vehicle_image'  => $imagePath,
        'status'         => $status, // Save the selected status
        'modified_by'    => auth()->id(),
        'modified_on'    => now(),
    ]);

    return redirect()->route('vehicles.index')
        ->with('success', 'Vehicle updated successfully');
}
    /**
 * Display archived (soft deleted) vehicles
 */
public function archived()
{
    if (auth()->user()->role === 'admin') {
        // Admin sees all archived vehicles
        $vehicles = Vehicle::onlyTrashed()
            ->with(['resident', 'parkingSlot'])
            ->latest('deleted_at')
            ->get();
    } else {
        // Residents see only their archived vehicles
        $vehicles = Vehicle::onlyTrashed()
            ->with(['resident', 'parkingSlot'])
            ->where('user_id', auth()->id())
            ->latest('deleted_at')
            ->get();
    }

    // Get counts for stats
    $totalVehicles = Vehicle::withTrashed()->count();
    $approvedCount = Vehicle::withTrashed()->where('status', 'approved')->count();
    $pendingCount = Vehicle::withTrashed()->where('status', 'pending')->count();
    $parkingAssigned = Vehicle::withTrashed()->whereNotNull('parking_slot_id')->count();

    return view('admin.vehicles.index', compact('vehicles', 'totalVehicles', 'approvedCount', 'pendingCount', 'parkingAssigned'));
}

/**
 * Restore soft deleted vehicle
 */
public function restore($id)
{
    $vehicle = Vehicle::onlyTrashed()->findOrFail($id);

    // Check permission
    if (auth()->user()->role !== 'admin' && $vehicle->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $vehicle->restore();
    $vehicle->update([
        'deleted_by' => null,
        'modified_by' => auth()->id(),
        'modified_on' => now(),
    ]);

    return redirect()->route('vehicles.index')
        ->with('success', 'Vehicle restored successfully');
}

/**
 * Force delete permanently (Admin only)
 */
public function forceDelete($id)
{
    // Only admin can force delete
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    $vehicle = Vehicle::onlyTrashed()->findOrFail($id);

    // Delete image if exists
    if ($vehicle->vehicle_image && file_exists(public_path($vehicle->vehicle_image))) {
        unlink(public_path($vehicle->vehicle_image));
    }

    $vehicle->forceDelete();

    return redirect()->route('vehicles.archived')
        ->with('success', 'Vehicle permanently deleted');
}
}
