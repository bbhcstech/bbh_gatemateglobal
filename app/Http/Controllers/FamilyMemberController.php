<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\FamilyMember;
use App\Models\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FamilyMemberController extends Controller
{
    /**
     * Display family members based on role
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        $searchResidentId = $request->get('resident_id');
        $searchTerm = $request->get('search');

        // Get all residents for search dropdown with family members count
        $residents = Resident::withCount('familyMembers')
            ->select('id', 'name', 'flat_no', 'phone', 'email', 'type', 'created_at', 'updated_at')
            ->orderBy('name')
            ->get();

        // CRITICAL FIX: Always initialize these variables at the top
        $selectedResident = null;
        $familyMembers = collect(); // ALWAYS initialize as empty collection
        $isOwnFamily = false;

        // Handle search by term (ID, Name, Flat, Phone)
        if ($searchTerm) {
            $searchedResident = Resident::where('id', $searchTerm)
                ->orWhere('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('flat_no', 'LIKE', "%{$searchTerm}%")
                ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                ->first();

            if ($searchedResident) {
                $searchResidentId = $searchedResident->id;
            }
        }

        // ROLE-BASED LOGIC: Which resident's family to show?
        if ($userRole === 'resident') {
            // Get the resident profile linked to this user
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident) {
                // Return with empty familyMembers collection
                return view('admin.family-members.index', compact(
                    'residents',
                    'familyMembers', // This is now defined as empty collection
                    'selectedResident',
                    'searchResidentId',
                    'searchTerm',
                    'isOwnFamily'
                ))->with('error', 'No resident profile found for your account.');
            }

            // If they searched for a specific resident
            if ($searchResidentId) {
                $selectedResident = Resident::with('familyMembers.relation')
                    ->find($searchResidentId);

                if ($selectedResident) {
                    $familyMembers = FamilyMember::with('relation')
                        ->where('resident_id', $searchResidentId)
                        ->orderBy('created_at')
                        ->get();

                    $isOwnFamily = ($searchResidentId == $resident->id);
                } else {
                    // Reset to empty if resident not found
                    $familyMembers = collect();
                }
            } else {
                // Default: show their own family
                $selectedResident = $resident;
                $familyMembers = FamilyMember::with('relation')
                    ->where('resident_id', $resident->id)
                    ->orderBy('created_at')
                    ->get();

                $isOwnFamily = true;
            }
        }
        else if ($userRole === 'security') {
            // Security can only view
            if ($searchResidentId) {
                $selectedResident = Resident::with('familyMembers.relation')
                    ->find($searchResidentId);

                if ($selectedResident) {
                    $familyMembers = FamilyMember::with('relation')
                        ->where('resident_id', $searchResidentId)
                        ->orderBy('created_at')
                        ->get();
                }
            }
            // If no search or resident not found, $familyMembers remains empty collection

            $isOwnFamily = false;
        }
        else { // Admin
            if ($searchResidentId) {
                $selectedResident = Resident::with('familyMembers.relation')
                    ->find($searchResidentId);

                if ($selectedResident) {
                    $familyMembers = FamilyMember::with('relation')
                        ->where('resident_id', $searchResidentId)
                        ->orderBy('created_at')
                        ->get();
                }
            }
            // If no search or resident not found, $familyMembers remains empty collection

            $isOwnFamily = false;
        }

        // ALWAYS return with all variables defined
        return view('admin.family-members.index', compact(
            'residents',
            'familyMembers', // This is ALWAYS defined now
            'selectedResident',
            'searchResidentId',
            'searchTerm',
            'isOwnFamily'
        ));
    }

    /**
     * Show all residents' family members (for admin and residents to view)
     */
    public function allResidents()
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        // Allow both admin and residents to access this page
        // Admin can see all, residents can see all (read-only)
        if (!in_array($userRole, ['admin', 'resident'])) {
            return redirect()->route('family-members.index')
                ->with('error', 'Unauthorized access');
        }

        // Get ALL family members from ALL residents with proper relationships
        $familyMembers = FamilyMember::with(['resident', 'relation'])
            ->whereNull('deleted_at')
            ->latest()
            ->get();

        // Pass the isAdmin flag to the view for any admin-specific UI elements
        $isAdmin = ($userRole === 'admin');

        return view('admin.family-members.all-residents', compact('familyMembers', 'isAdmin'));
    }

    /**
     * Show form to create family member
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        // Security cannot create
        if ($userRole === 'security') {
            return redirect()->route('family-members.index')
                ->with('error', 'Security cannot add family members.');
        }

        // Get all relations
        $relations = Relation::orderBy('name')->get();

        // For Admin
        if ($userRole === 'admin') {
            $residentId = $request->get('resident_id');

            if ($residentId) {
                // If resident_id is provided, go to create form with that resident
                $selectedResident = Resident::withCount('familyMembers')->find($residentId);

                if (!$selectedResident) {
                    return redirect()->route('family-members.index')
                        ->with('error', 'Resident not found.');
                }

                return view('admin.family-members.create', compact('relations', 'selectedResident'));
            } else {
                // If no resident_id, show resident selection page
                $residents = Resident::withCount('familyMembers')
                    ->orderBy('name')
                    ->get();

                return view('admin.family-members.select-resident', compact('residents'));
            }
        }

        // For Resident
        if ($userRole === 'resident') {
            // Find the resident record for this user
            $selectedResident = Resident::where('user_id', $user->id)->first();

            if (!$selectedResident) {
                return redirect()->route('family-members.index')
                    ->with('error', 'No resident profile found for your account. Please contact admin.');
            }

            return view('admin.family-members.create', compact('relations', 'selectedResident'));
        }

        // For any other role
        return redirect()->route('family-members.index')
            ->with('error', 'Unauthorized access.');
    }

    /**
     * Store a new family member
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        // Security cannot store
        if ($userRole === 'security') {
            return redirect()->route('family-members.index')
                ->with('error', 'Security cannot add family members.');
        }

        // Validate the request
        $validated = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'name' => 'required|string|max:255',
            'relation_name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'activity_status' => 'nullable|boolean',
        ], [
            'resident_id.required' => 'Please select a resident.',
            'name.required' => 'Member name is required.',
            'relation_name.required' => 'Please select or specify a relationship.',
        ]);

        // For residents, verify they're only adding to their own family
        if ($userRole === 'resident') {
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident || $resident->id != $request->resident_id) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'You can only add members to your own family.');
            }
        }

        // Find or create relation
        $relation = Relation::firstOrCreate(
            ['name' => $validated['relation_name']]
        );

        // Check for duplicate
        $exists = FamilyMember::where('resident_id', $request->resident_id)
            ->where('name', $request->name)
            ->where('relation_id', $relation->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This family member already exists.');
        }

        try {
            DB::beginTransaction();

            // Create family member
            $familyMember = FamilyMember::create([
                'resident_id' => $validated['resident_id'],
                'name' => $validated['name'],
                'relation_id' => $relation->id,
                'mobile' => $validated['mobile'] ?? null,
                'activity_status' => $request->has('activity_status') ? 1 : 1,
                'deleted_status' => 0,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            DB::commit();

            return redirect()->route('family-members.index', ['resident_id' => $request->resident_id])
                ->with('success', 'Family member "' . $request->name . '" added successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to add family member. Please try again.');
        }
    }

    /**
     * Display the specified family member
     */
    public function show(FamilyMember $familyMember)
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        // Load relationships
        $familyMember->load(['resident', 'relation', 'creator', 'updater']);

        // Check if user can view this member
        if ($userRole === 'resident') {
            $resident = Resident::where('user_id', $user->id)->first();
            if (!$resident || $resident->id != $familyMember->resident_id) {
                // Residents can view others' family members (read-only)
                $isOwnFamily = false;
            } else {
                $isOwnFamily = true;
            }
        } else {
            $isOwnFamily = ($userRole === 'admin');
        }

        return view('admin.family-members.show', compact('familyMember', 'isOwnFamily'));
    }

    /**
     * Show edit form
     */
    public function edit(FamilyMember $familyMember)
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        // Security cannot edit
        if ($userRole === 'security') {
            return redirect()->route('family-members.index')
                ->with('error', 'Security cannot edit family members.');
        }

        // Residents can only edit their own family members
        if ($userRole === 'resident') {
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident || $resident->id != $familyMember->resident_id) {
                return redirect()->route('family-members.index')
                    ->with('error', 'You can only edit your own family members.');
            }
        }

        $relations = Relation::orderBy('name')->get();

        return view('admin.family-members.edit', compact('familyMember', 'relations'));
    }

    /**
     * Update family member
     */
    public function update(Request $request, FamilyMember $familyMember)
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        // Security cannot update
        if ($userRole === 'security') {
            return redirect()->route('family-members.index')
                ->with('error', 'Security cannot update family members.');
        }

        // Residents can only update their own family members
        if ($userRole === 'resident') {
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident || $resident->id != $familyMember->resident_id) {
                return redirect()->route('family-members.index')
                    ->with('error', 'You can only update your own family members.');
            }
        }

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'relation_name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'activity_status' => 'nullable|boolean',
        ]);

        // Find or create relation
        $relation = Relation::firstOrCreate(
            ['name' => $validated['relation_name']]
        );

        try {
            DB::beginTransaction();

            // Update family member
            $familyMember->update([
                'name' => $validated['name'],
                'relation_id' => $relation->id,
                'mobile' => $validated['mobile'] ?? null,
                'activity_status' => $request->has('activity_status') ? 1 : 0,
                'updated_by' => $user->id,
            ]);

            DB::commit();

            return redirect()->route('family-members.index', ['resident_id' => $familyMember->resident_id])
                ->with('success', 'Family member updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update family member. Please try again.');
        }
    }

    /**
     * Soft delete family member (archive)
     */
    public function destroy(FamilyMember $familyMember)
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        // Security cannot delete
        if ($userRole === 'security') {
            return redirect()->route('family-members.index')
                ->with('error', 'Security cannot delete family members.');
        }

        // Residents can only delete their own family members
        if ($userRole === 'resident') {
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident || $resident->id != $familyMember->resident_id) {
                return redirect()->route('family-members.index')
                    ->with('error', 'You can only delete your own family members.');
            }
        }

        $residentId = $familyMember->resident_id;
        $memberName = $familyMember->name;

        try {
            DB::beginTransaction();

            // Soft delete with audit
            $familyMember->deleted_status = 1;
            $familyMember->deleted_by = $user->id;
            $familyMember->deleted_at = now();
            $familyMember->save();

            // Also perform the soft delete
            $familyMember->delete();

            DB::commit();

            return redirect()->route('family-members.index', ['resident_id' => $residentId])
                ->with('success', 'Family member "' . $memberName . '" archived successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to archive family member. Please try again.');
        }
    }

    /**
     * Restore soft deleted family member
     */
    public function restore($id)
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        // Find the trashed family member
        $familyMember = FamilyMember::withTrashed()->findOrFail($id);

        // Check permission
        if ($userRole === 'resident') {
            $resident = Resident::where('user_id', $user->id)->first();
            if (!$resident || $resident->id != $familyMember->resident_id) {
                return redirect()->route('family-members.archived')
                    ->with('error', 'You can only restore your own family members.');
            }
        }

        try {
            DB::beginTransaction();

            // Restore
            $familyMember->restore();

            // Update audit
            $familyMember->deleted_status = 0;
            $familyMember->deleted_by = null;
            $familyMember->deleted_at = null;
            $familyMember->updated_by = $user->id;
            $familyMember->save();

            DB::commit();

            return redirect()->route('family-members.archived')
                ->with('success', 'Family member restored successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to restore family member.');
        }
    }

    /**
     * Force delete permanently
     */
    public function forceDelete($id)
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        // Only admin can force delete
        if ($userRole !== 'admin') {
            return redirect()->route('family-members.archived')
                ->with('error', 'Only administrators can permanently delete family members.');
        }

        $familyMember = FamilyMember::withTrashed()->findOrFail($id);
        $memberName = $familyMember->name;

        try {
            DB::beginTransaction();
            $familyMember->forceDelete();
            DB::commit();

            return redirect()->route('family-members.archived')
                ->with('success', 'Family member "' . $memberName . '" permanently deleted.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to permanently delete family member.');
        }
    }

    /**
     * Display archived family members
     */
    public function archived()
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        // Initialize variables
        $familyMembers = collect();
        $totalArchived = 0;
        $activeArchived = 0;
        $withMobileArchived = 0;
        $monthlyArchived = 0;

        if ($userRole === 'admin') {
            // Admin sees all archived family members
            $familyMembers = FamilyMember::onlyTrashed()
                ->with(['resident', 'relation', 'deleter'])
                ->latest('deleted_at')
                ->paginate(15);

            $totalArchived = FamilyMember::onlyTrashed()->count();
            $activeArchived = FamilyMember::onlyTrashed()->where('activity_status', 1)->count();
            $withMobileArchived = FamilyMember::onlyTrashed()->whereNotNull('mobile')->count();
            $monthlyArchived = FamilyMember::onlyTrashed()
                ->where('deleted_at', '>=', now()->startOfMonth())
                ->count();
        }
        elseif ($userRole === 'resident') {
            // Residents see only their archived family members
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident) {
                return redirect()->route('family-members.index')
                    ->with('error', 'No resident profile found.');
            }

            $familyMembers = FamilyMember::onlyTrashed()
                ->with(['resident', 'relation', 'deleter'])
                ->where('resident_id', $resident->id)
                ->latest('deleted_at')
                ->paginate(15);

            $totalArchived = FamilyMember::onlyTrashed()
                ->where('resident_id', $resident->id)
                ->count();
            $activeArchived = FamilyMember::onlyTrashed()
                ->where('resident_id', $resident->id)
                ->where('activity_status', 1)
                ->count();
            $withMobileArchived = FamilyMember::onlyTrashed()
                ->where('resident_id', $resident->id)
                ->whereNotNull('mobile')
                ->count();
            $monthlyArchived = FamilyMember::onlyTrashed()
                ->where('resident_id', $resident->id)
                ->where('deleted_at', '>=', now()->startOfMonth())
                ->count();
        }
        else {
            return redirect()->route('family-members.index')
                ->with('error', 'Unauthorized access.');
        }

        return view('admin.family-members.archived', compact(
            'familyMembers',
            'totalArchived',
            'activeArchived',
            'withMobileArchived',
            'monthlyArchived'
        ));
    }

    /**
     * Bulk delete (soft delete) family members
     */
    public function bulkDelete(Request $request)
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        $ids = explode(',', $request->ids);

        if ($userRole === 'admin') {
            // Admin can delete any family members
            FamilyMember::whereIn('member_id', $ids)->delete();

            // Update deleted_by for each
            foreach ($ids as $id) {
                FamilyMember::withTrashed()->where('member_id', $id)->update([
                    'deleted_by' => $user->id,
                    'deleted_status' => 1
                ]);
            }

            return redirect()->back()->with('success', 'Selected family members archived successfully');
        }
        elseif ($userRole === 'resident') {
            // Resident can only delete their own family members
            $resident = Resident::where('user_id', $user->id)->first();

            if ($resident) {
                FamilyMember::whereIn('member_id', $ids)
                    ->where('resident_id', $resident->id)
                    ->delete();

                foreach ($ids as $id) {
                    FamilyMember::withTrashed()
                        ->where('member_id', $id)
                        ->where('resident_id', $resident->id)
                        ->update([
                            'deleted_by' => $user->id,
                            'deleted_status' => 1
                        ]);
                }
            }

            return redirect()->back()->with('success', 'Your selected family members archived successfully');
        }

        return redirect()->back()->with('error', 'Unauthorized action');
    }

    /**
     * Bulk restore family members
     */
    public function bulkRestore(Request $request)
    {
        $user = auth()->user();
        $userRole = strtolower($user->roleMaster->role_name ?? $user->role ?? '');

        $ids = explode(',', $request->ids);

        if ($userRole === 'admin') {
            // Admin can restore any
            FamilyMember::onlyTrashed()->whereIn('member_id', $ids)->restore();

            foreach ($ids as $id) {
                FamilyMember::where('member_id', $id)->update([
                    'deleted_by' => null,
                    'deleted_status' => 0,
                    'updated_by' => $user->id
                ]);
            }

            return redirect()->back()->with('success', 'Selected family members restored successfully');
        }
        elseif ($userRole === 'resident') {
            // Resident can only restore their own
            $resident = Resident::where('user_id', $user->id)->first();

            if ($resident) {
                FamilyMember::onlyTrashed()
                    ->whereIn('member_id', $ids)
                    ->where('resident_id', $resident->id)
                    ->restore();

                foreach ($ids as $id) {
                    FamilyMember::where('member_id', $id)
                        ->where('resident_id', $resident->id)
                        ->update([
                            'deleted_by' => null,
                            'deleted_status' => 0,
                            'updated_by' => $user->id
                        ]);
                }
            }

            return redirect()->back()->with('success', 'Your selected family members restored successfully');
        }

        return redirect()->back()->with('error', 'Unauthorized action');
    }

    /**
     * Bulk force delete permanently (Admin only)
     */
    public function bulkForceDelete(Request $request)
    {
        $userRole = strtolower(auth()->user()->roleMaster->role_name ?? auth()->user()->role ?? '');

        // Only admin can force delete
        if ($userRole !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        $ids = explode(',', $request->ids);

        FamilyMember::onlyTrashed()->whereIn('member_id', $ids)->forceDelete();

        return redirect()->back()->with('success', 'Selected family members permanently deleted');
    }

    /**
     * Search residents by ID or Name (AJAX)
     */
    public function searchResidents(Request $request)
    {
        $search = $request->get('q');

        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $residents = Resident::where('id', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%")
            ->orWhere('flat_no', 'LIKE', "%{$search}%")
            ->withCount('familyMembers')
            ->limit(20)
            ->get(['id', 'name', 'flat_no', 'phone', 'type']);

        return response()->json($residents);
    }

    /**
     * Get family members for a resident (AJAX)
     */
    public function getFamilyMembers($residentId)
    {
        $familyMembers = FamilyMember::with('relation')
            ->where('resident_id', $residentId)
            ->whereNull('deleted_at')
            ->orderBy('created_at')
            ->get();

        return response()->json($familyMembers);
    }
}
