<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Resident;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        // Fix: Show vehicles based on user role
        if (auth()->user()->role === 'admin') {
            // Admin sees all active vehicles (not soft deleted)
            $vehicles = Vehicle::with(['resident.flat', 'parkingSlot'])
                ->whereNull('deleted_at')
                ->latest()
                ->get();

            // Calculate stats correctly
            $totalVehicles = Vehicle::whereNull('deleted_at')->count();
            $activeCount = Vehicle::whereNull('deleted_at')->where('status', 'active')->count();
            $inactiveCount = Vehicle::whereNull('deleted_at')->where('status', 'inactive')->count();

            // Fix: Count only vehicles with parking slots that are active
            $parkingAssigned = Vehicle::whereNull('deleted_at')
                ->where('status', 'active')
                ->whereNotNull('parking_slot_id')
                ->count();
        } else {
            // Resident sees only their active vehicles
            $vehicles = Vehicle::with(['resident.flat', 'parkingSlot'])
                ->where('user_id', auth()->id())
                ->whereNull('deleted_at')
                ->latest()
                ->get();

            // Calculate stats for resident
            $totalVehicles = Vehicle::where('user_id', auth()->id())->whereNull('deleted_at')->count();
            $activeCount = Vehicle::where('user_id', auth()->id())->whereNull('deleted_at')->where('status', 'active')->count();
            $inactiveCount = Vehicle::where('user_id', auth()->id())->whereNull('deleted_at')->where('status', 'inactive')->count();
            $parkingAssigned = Vehicle::where('user_id', auth()->id())->whereNull('deleted_at')
                ->where('status', 'active')
                ->whereNotNull('parking_slot_id')
                ->count();
        }

        return view('admin.vehicles.index', compact('vehicles', 'totalVehicles', 'activeCount', 'inactiveCount', 'parkingAssigned'));
    }

public function toggleStatus(Request $request, $id)
{
    try {
        // Get the logged-in user (resident)
        $user = auth()->user();

        // Find the vehicle and ensure it belongs to the logged-in user
        $vehicle = Vehicle::where('id', $id)
                         ->where('user_id', $user->id) // Use user_id instead of resident_id
                         ->whereNull('deleted_at')
                         ->first();

        // Check if vehicle exists and belongs to user
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found or you do not have permission to update this vehicle'
            ], 404);
        }

        // Validate status
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        // Toggle the status
        $newStatus = $request->status;
        $vehicle->status = $newStatus;
        $vehicle->save();

        // Calculate updated counts for the resident
        $totalVehicles = Vehicle::where('user_id', $user->id)->whereNull('deleted_at')->count();
        $activeCount = Vehicle::where('user_id', $user->id)->whereNull('deleted_at')->where('status', 'active')->count();
        $inactiveCount = Vehicle::where('user_id', $user->id)->whereNull('deleted_at')->where('status', 'inactive')->count();
        $parkingAssigned = Vehicle::where('user_id', $user->id)->whereNull('deleted_at')
            ->where('status', 'active')
            ->whereNotNull('parking_slot_id')
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle status updated successfully',
            'new_status' => $newStatus,
            'counts' => [
                'total' => $totalVehicles,
                'active' => $activeCount,
                'inactive' => $inactiveCount,
                'parking_assigned' => $parkingAssigned
            ]
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed: ' . implode(', ', $e->errors())
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}



    public function create()
    {
        // Get all residents for dropdown
        $residents = Resident::with('flat')->orderBy('name')->get();

        // Get all parking slots from master table
        $parkingSlots = ParkingSlot::all();

        return view('admin.vehicles.create', compact('residents', 'parkingSlots'));
    }

    public function store(Request $request)
    {
        // Updated validation to match new database structure
        $request->validate([
            'vehicle_number' => 'required|string|max:20|unique:vehicles,vehicle_number',
            'sticker_number' => 'nullable|string|max:255',
            'vehicle_type'   => 'required|string|max:255',
            'make'           => 'nullable|string|max:255',
            'model'          => 'nullable|string|max:255',
            'color'          => 'required|string|max:50',
            'resident_id'    => 'required|exists:residents,id',
            'parking_slot_id' => 'nullable|exists:parking_slots,id',
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

        // Get resident to get user_id
        $resident = Resident::find($request->resident_id);

        // Create vehicle with proper fields
        Vehicle::create([
            'vehicle_number' => strtoupper(str_replace(' ', '', $request->vehicle_number)),
            'user_id' => $resident->user_id ?? auth()->id(),
            'sticker_number' => $request->sticker_number,
            'vehicle_type'   => $request->vehicle_type,
            'make'           => $request->make,
            'model'          => $request->model,
            'color'          => $request->color,
            'parking_slot_id' => $request->parking_slot_id,
            'resident_id'    => $request->resident_id,
            'vehicle_image'  => $imagePath,
            'status'         => $request->has('is_approved') ? 'active' : 'inactive', // Using active/inactive
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
        $parkingSlots = ParkingSlot::all();

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
            'status'         => 'nullable|in:active,inactive,pending,approved,rejected,blacklisted',
        ]);

        // Handle image upload
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
        $status = $request->status ?? ($request->has('is_approved') ? 'active' : $vehicle->status);

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
            'status'         => $status,
            'modified_by'    => auth()->id(),
            'modified_on'    => now(),
        ]);

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle updated successfully');
    }

    /**
     * Soft delete vehicle (archive)
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        // Check permission
        if (auth()->user()->role !== 'admin' && $vehicle->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $vehicle->delete();
        $vehicle->update([
            'deleted_by' => auth()->id(),
        ]);

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle archived successfully');
    }

    /**
     * Display archived (soft deleted) vehicles
     */
    public function archived()
{
    if (auth()->user()->role === 'admin') {
        // Admin sees all archived vehicles
        $vehicles = Vehicle::onlyTrashed()
            ->with(['resident.flat', 'parkingSlot'])
            ->latest('deleted_at')
            ->paginate(10); // Add pagination

        // Stats for archived view
        $totalArchived = Vehicle::onlyTrashed()->count();
        $twoWheelers = Vehicle::onlyTrashed()
            ->whereIn('vehicle_type', ['Motor Bike', 'Bicycle'])
            ->count();
        $fourWheelers = Vehicle::onlyTrashed()
            ->whereIn('vehicle_type', ['Car', 'SUV'])
            ->count();
        $monthlyArchived = Vehicle::onlyTrashed()
            ->where('deleted_at', '>=', now()->startOfMonth())
            ->count();
    } else {
        // Residents see only their archived vehicles
        $vehicles = Vehicle::onlyTrashed()
            ->with(['resident.flat', 'parkingSlot'])
            ->where('user_id', auth()->id())
            ->latest('deleted_at')
            ->paginate(10);

        // Stats for resident archived view
        $totalArchived = Vehicle::onlyTrashed()
            ->where('user_id', auth()->id())
            ->count();
        $twoWheelers = Vehicle::onlyTrashed()
            ->where('user_id', auth()->id())
            ->whereIn('vehicle_type', ['Motor Bike', 'Bicycle'])
            ->count();
        $fourWheelers = Vehicle::onlyTrashed()
            ->where('user_id', auth()->id())
            ->whereIn('vehicle_type', ['Car', 'SUV'])
            ->count();
        $monthlyArchived = Vehicle::onlyTrashed()
            ->where('user_id', auth()->id())
            ->where('deleted_at', '>=', now()->startOfMonth())
            ->count();
    }

    return view('admin.vehicles.archived', compact(
        'vehicles',
        'totalArchived',
        'twoWheelers',
        'fourWheelers',
        'monthlyArchived'
    ));
}

    /**
     * Restore soft deleted vehicle
     */
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

            // Update restored by
            $vehicle->update([
                'deleted_by' => null,
                'modified_by' => auth()->id(),
                'modified_on' => now(),
            ]);

            return redirect()->route('vehicles.archived')
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

    public function show(Vehicle $vehicle)
    {
        // Check permission
        if (auth()->user()->role !== 'admin' && $vehicle->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.vehicles.show', compact('vehicle'));
    }


    /**
     * Show archived vehicle details
     */
    public function archivedShow($id)
    {
        try {
            $vehicle = Vehicle::onlyTrashed()
                ->with(['resident.flat'])
                ->findOrFail($id);

            return view('admin.vehicles.archived-show', compact('vehicle'));
        } catch (\Exception $e) {
            return redirect()->route('vehicles.archived')
                ->with('error', 'Vehicle not found in archive.');
        }
    }

    /**
 * Show all residents' vehicles (for residents to view)
 */
public function allResidents()
{
    $user = auth()->user();
    $userRole = strtolower($user->roleMaster->role_name ?? '');

    // Only residents can access this page
    if ($userRole !== 'resident') {
        return redirect()->route('vehicles.index')
            ->with('error', 'Unauthorized access');
    }

    // Get all active vehicles with resident and flat info
    $vehicles = Vehicle::with(['resident', 'resident.flat', 'parkingSlot'])
        ->whereNull('deleted_at')
        ->latest()
        ->get();

    return view('admin.vehicles.all-residents', compact('vehicles'));
}



}
