<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use App\Models\Flat;
use App\Models\PetsName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function index()
    {
        // Fix: Show pets based on user role
        if (auth()->user()->role === 'admin') {
            // Admin sees all active pets (not soft deleted)
            $pets = Pet::with(['resident', 'resident.flat'])
                ->whereNull('deleted_at')
                ->latest()
                ->get();

            // Calculate stats correctly
            $totalPets = Pet::whereNull('deleted_at')->count();
            $activeCount = Pet::whereNull('deleted_at')->where('activity_status', 1)->count();
            $inactiveCount = Pet::whereNull('deleted_at')->where('activity_status', 0)->count();

            // Fix: Count vaccinated pets
            $vaccinatedCount = Pet::whereNull('deleted_at')
                ->where('vaccination_status', 'yes')
                ->count();
        } else {
            // Resident sees only their active pets
            $pets = Pet::with(['resident', 'resident.flat'])
                ->where('resident_id', auth()->id())
                ->whereNull('deleted_at')
                ->latest()
                ->get();

            // Calculate stats for resident
            $totalPets = Pet::where('resident_id', auth()->id())->whereNull('deleted_at')->count();
            $activeCount = Pet::where('resident_id', auth()->id())->whereNull('deleted_at')->where('activity_status', 1)->count();
            $inactiveCount = Pet::where('resident_id', auth()->id())->whereNull('deleted_at')->where('activity_status', 0)->count();
            $vaccinatedCount = Pet::where('resident_id', auth()->id())->whereNull('deleted_at')
                ->where('vaccination_status', 'yes')
                ->count();
        }

        return view('admin.pets.index', compact('pets', 'totalPets', 'activeCount', 'inactiveCount', 'vaccinatedCount'));
    }

    public function toggleStatus(Request $request, $id)
    {
        try {
            // Get the logged-in user (resident)
            $user = auth()->user();

            // Find the pet and ensure it belongs to the logged-in user
            $pet = Pet::where('id', $id)
                     ->where('resident_id', $user->id)
                     ->whereNull('deleted_at')
                     ->first();

            // Check if pet exists and belongs to user
            if (!$pet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pet not found or you do not have permission to update this pet'
                ], 404);
            }

            // Validate status
            $request->validate([
                'activity_status' => 'required|in:0,1'
            ]);

            // Toggle the status
            $newStatus = $request->activity_status;
            $pet->activity_status = $newStatus;
            $pet->save();

            // Calculate updated counts for the resident
            $totalPets = Pet::where('resident_id', $user->id)->whereNull('deleted_at')->count();
            $activeCount = Pet::where('resident_id', $user->id)->whereNull('deleted_at')->where('activity_status', 1)->count();
            $inactiveCount = Pet::where('resident_id', $user->id)->whereNull('deleted_at')->where('activity_status', 0)->count();
            $vaccinatedCount = Pet::where('resident_id', $user->id)->whereNull('deleted_at')
                ->where('vaccination_status', 'yes')
                ->count();

            return response()->json([
                'success' => true,
                'message' => 'Pet status updated successfully',
                'new_status' => $newStatus,
                'counts' => [
                    'total' => $totalPets,
                    'active' => $activeCount,
                    'inactive' => $inactiveCount,
                    'vaccinated' => $vaccinatedCount
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

   public function profile($id)
{
    // Find the resident (User with role 'resident')
    $resident = User::with('flat')->findOrFail($id);

    // Get their pets if needed
    $pets = Pet::where('resident_id', $id)
               ->whereNull('deleted_at')
               ->get();

    // Use consistent view path - either:
    return view('admin.resident.profile', compact('resident', 'pets'));
    // OR
    // return view('resident.profile', compact('resident', 'pets'));
}

    public function create()
    {
        // Get all residents for dropdown
        $residents = User::whereHas('roleMaster', function($query) {
            $query->where('role_name', 'resident');
        })->with('flat')->orderBy('name')->get();

        // Get pet names from master table
        $petsNames = PetsName::where('status', 'active')->get();

        return view('admin.pets.create', compact('residents', 'petsNames'));
    }

    public function store(Request $request)
    {
        // Updated validation to match new database structure
        $request->validate([
            'pet_type' => 'required|string|max:255',
            'pet_name' => 'required|string|max:255|unique:pets,pet_name',
            'pet_breed' => 'nullable|string|max:255',
            'pet_age' => 'nullable|integer|min:0',
            'pet_color' => 'nullable|string|max:50',
            'pet_gender' => 'nullable|in:male,female',
            'resident_id' => 'required|exists:users,id',
            'collar_microchip_no' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/pets'), $filename);
            $imagePath = 'uploads/pets/' . $filename;
        }

        // Get resident to get flat_id
        $resident = User::find($request->resident_id);

        // Create pet with proper fields
        Pet::create([
            'pet_name' => $request->pet_name,
            'resident_id' => $request->resident_id,
            'flat_id' => $resident->flat_id,
            'pet_type' => $request->pet_type,
            'pet_breed' => $request->pet_breed,
            'pet_age' => $request->pet_age,
            'pet_color' => $request->pet_color,
            'pet_gender' => $request->pet_gender,
            'collar_microchip_no' => $request->collar_microchip_no,
            'image' => $imagePath,
            'activity_status' => 1,
            'vaccination_status' => 'no',
            'is_dangerous' => 0,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('pets.index')
            ->with('success', 'Pet added successfully');
    }

    public function edit(Pet $pet)
    {
        // Check permission
        if (auth()->user()->role !== 'admin' && $pet->resident_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $residents = User::whereHas('roleMaster', function($query) {
            $query->where('role_name', 'resident');
        })->with('flat')->orderBy('name')->get();

        $petsNames = PetsName::where('status', 'active')->get();

        return view('admin.pets.edit', compact('pet', 'residents', 'petsNames'));
    }

    public function update(Request $request, Pet $pet)
    {
        // Check permission
        if (auth()->user()->role !== 'admin' && $pet->resident_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate request
        $request->validate([
            'pet_type' => 'required|string|max:255',
            'pet_name' => 'required|string|max:255|unique:pets,pet_name,' . $pet->id,
            'pet_breed' => 'nullable|string|max:255',
            'pet_age' => 'nullable|integer|min:0',
            'pet_color' => 'nullable|string|max:50',
            'pet_gender' => 'nullable|in:male,female',
            'resident_id' => 'required|exists:users,id',
            'collar_microchip_no' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'activity_status' => 'nullable|in:0,1',
            'vaccination_status' => 'nullable|in:yes,no',
            'is_dangerous' => 'nullable|boolean',
        ]);

        // Handle image upload
        $imagePath = $pet->image;
        if ($request->hasFile('image')) {
            // Delete old image
            if ($pet->image && file_exists(public_path($pet->image))) {
                unlink(public_path($pet->image));
            }

            // Upload new image
            $image = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._]/', '', $image->getClientOriginalName());
            $image->move(public_path('uploads/pets'), $filename);
            $imagePath = 'uploads/pets/' . $filename;
        }

        // Get resident for flat_id
        $resident = User::find($request->resident_id);

        if (!$resident) {
            return back()->withErrors(['resident_id' => 'Selected resident not found'])->withInput();
        }

        // Update pet with proper fields
        $pet->update([
            'pet_name' => $request->pet_name,
            'resident_id' => $request->resident_id,
            'flat_id' => $resident->flat_id,
            'pet_type' => $request->pet_type,
            'pet_breed' => $request->pet_breed,
            'pet_age' => $request->pet_age,
            'pet_color' => $request->pet_color,
            'pet_gender' => $request->pet_gender,
            'collar_microchip_no' => $request->collar_microchip_no,
            'image' => $imagePath,
            'activity_status' => $request->activity_status ?? $pet->activity_status,
            'vaccination_status' => $request->vaccination_status ?? $pet->vaccination_status,
            'vaccination_expiry_date' => $request->vaccination_expiry_date,
            'is_dangerous' => $request->has('is_dangerous') ? 1 : 0,
            'modified_by' => auth()->id(),
        ]);

        return redirect()->route('pets.index')
            ->with('success', 'Pet updated successfully');
    }

    /**
     * Soft delete pet (archive)
     */
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);

        // Check permission
        if (auth()->user()->role !== 'admin' && $pet->resident_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $pet->delete();
        $pet->update([
            'deleted_by' => auth()->id(),
        ]);

        return redirect()->route('pets.index')
            ->with('success', 'Pet archived successfully');
    }

    /**
     * Display archived (soft deleted) pets
     */
    public function archived()
    {
        if (auth()->user()->role === 'admin') {
            // Admin sees all archived pets
            $pets = Pet::onlyTrashed()
                ->with(['resident', 'resident.flat'])
                ->latest('deleted_at')
                ->paginate(10);

            // Stats for archived view
            $totalArchived = Pet::onlyTrashed()->count();
            $vaccinatedArchived = Pet::onlyTrashed()
                ->where('vaccination_status', 'yes')
                ->count();
            $dangerousArchived = Pet::onlyTrashed()
                ->where('is_dangerous', true)
                ->count();
            $monthlyArchived = Pet::onlyTrashed()
                ->where('deleted_at', '>=', now()->startOfMonth())
                ->count();
        } else {
            // Residents see only their archived pets
            $pets = Pet::onlyTrashed()
                ->with(['resident', 'resident.flat'])
                ->where('resident_id', auth()->id())
                ->latest('deleted_at')
                ->paginate(10);

            // Stats for resident archived view
            $totalArchived = Pet::onlyTrashed()
                ->where('resident_id', auth()->id())
                ->count();
            $vaccinatedArchived = Pet::onlyTrashed()
                ->where('resident_id', auth()->id())
                ->where('vaccination_status', 'yes')
                ->count();
            $dangerousArchived = Pet::onlyTrashed()
                ->where('resident_id', auth()->id())
                ->where('is_dangerous', true)
                ->count();
            $monthlyArchived = Pet::onlyTrashed()
                ->where('resident_id', auth()->id())
                ->where('deleted_at', '>=', now()->startOfMonth())
                ->count();
        }

        return view('admin.pets.archived', compact(
            'pets',
            'totalArchived',
            'vaccinatedArchived',
            'dangerousArchived',
            'monthlyArchived'
        ));
    }

    /**
     * Restore soft deleted pet
     */
    public function restore($id)
    {
        $pet = Pet::onlyTrashed()->findOrFail($id);

        // Check permission
        if (auth()->user()->role !== 'admin' && $pet->resident_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $pet->restore();

        // Update restored info
        $pet->update([
            'deleted_by' => null,
            'modified_by' => auth()->id(),
        ]);

        return redirect()->route('pets.archived')
            ->with('success', 'Pet restored successfully');
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

        $pet = Pet::onlyTrashed()->findOrFail($id);

        // Delete image if exists
        if ($pet->image && file_exists(public_path($pet->image))) {
            unlink(public_path($pet->image));
        }

        $pet->forceDelete();

        return redirect()->route('pets.archived')
            ->with('success', 'Pet permanently deleted');
    }

    public function show(Pet $pet)
    {
        // Check permission
        if (auth()->user()->role !== 'admin' && $pet->resident_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.pets.show', compact('pet'));
    }

    /**
     * Show archived pet details
     */
    public function archivedShow($id)
    {
        try {
            $pet = Pet::onlyTrashed()
                ->with(['resident', 'resident.flat'])
                ->findOrFail($id);

            return view('admin.pets.archived-show', compact('pet'));
        } catch (\Exception $e) {
            return redirect()->route('pets.archived')
                ->with('error', 'Pet not found in archive.');
        }
    }

    /**
     * Bulk delete (soft delete) pets
     */
    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->ids);

        if (auth()->user()->role === 'admin') {
            // Admin can delete any pets
            Pet::whereIn('id', $ids)->delete();

            // Update deleted_by for each pet
            foreach ($ids as $id) {
                Pet::withTrashed()->where('id', $id)->update(['deleted_by' => auth()->id()]);
            }

            return redirect()->back()->with('success', 'Selected pets archived successfully');
        } else {
            // Resident can only delete their own pets
            Pet::whereIn('id', $ids)
                ->where('resident_id', auth()->id())
                ->delete();

            // Update deleted_by for each pet
            foreach ($ids as $id) {
                Pet::withTrashed()->where('id', $id)->where('resident_id', auth()->id())
                    ->update(['deleted_by' => auth()->id()]);
            }

            return redirect()->back()->with('success', 'Your selected pets archived successfully');
        }
    }


    /**
 * Toggle dangerous status - Admin only
 */
public function toggleDangerous($id)
{
    $userRole = strtolower(auth()->user()->roleMaster->role_name ?? '');

    if ($userRole !== 'admin') {
        return redirect()->back()->with('error', 'Only admin can toggle dangerous status');
    }

    $pet = Pet::findOrFail($id);
    $pet->is_dangerous = !$pet->is_dangerous;
    $pet->save();

    $status = $pet->is_dangerous ? 'marked as dangerous' : 'removed from dangerous list';
    return redirect()->back()->with('success', "Pet {$status} successfully");
}

/**
 * Show all residents' pets (for residents to view)
 */
public function allResidents()
{
    $user = auth()->user();
    $userRole = strtolower($user->roleMaster->role_name ?? '');

    // Only residents can access this page
    if ($userRole !== 'resident') {
        return redirect()->route('pets.index')
            ->with('error', 'Unauthorized access');
    }

    // Get all active pets with resident and flat info
    $pets = Pet::with(['resident', 'flat'])
        ->whereNull('deleted_at')
        ->latest()
        ->get();

    return view('admin.pets.all-residents', compact('pets'));
}

    /**
     * Bulk restore pets
     */
    public function bulkRestore(Request $request)
    {
        $ids = explode(',', $request->ids);

        if (auth()->user()->role === 'admin') {
            // Admin can restore any pets
            Pet::onlyTrashed()->whereIn('id', $ids)->restore();

            // Clear deleted_by for restored pets
            foreach ($ids as $id) {
                Pet::where('id', $id)->update(['deleted_by' => null]);
            }

            return redirect()->back()->with('success', 'Selected pets restored successfully');
        } else {
            // Resident can only restore their own pets
            Pet::onlyTrashed()
                ->whereIn('id', $ids)
                ->where('resident_id', auth()->id())
                ->restore();

            // Clear deleted_by for restored pets
            foreach ($ids as $id) {
                Pet::where('id', $id)->where('resident_id', auth()->id())
                    ->update(['deleted_by' => null]);
            }

            return redirect()->back()->with('success', 'Your selected pets restored successfully');
        }
    }
}
