<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\FamilyMember;
use App\Models\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamilyMemberController extends Controller
{
    /**
     * Display family members based on role
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $searchResidentId = $request->get('resident_id');
        $searchTerm = $request->get('search');

        // Get all residents for search dropdown with family members count
        $residents = Resident::withCount('familyMembers')
            ->select('id', 'name', 'flat_no', 'phone', 'email', 'type', 'created_at', 'updated_at')
            ->orderBy('name')
            ->get();

        // Initialize variables
        $selectedResident = null;
        $familyMembers = collect();
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
        if ($user->role === 'resident') {
            // Get the resident profile linked to this user
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident) {
                return view('admin.family-members.index', [
                    'error' => 'No resident profile found for your account.',
                    'residents' => $residents,
                    'familyMembers' => collect(),
                    'selectedResident' => null,
                    'searchResidentId' => $searchResidentId,
                    'searchTerm' => $searchTerm,
                    'isOwnFamily' => false
                ]);
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
        else if ($user->role === 'security') {
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

            $isOwnFamily = false;
        }

        return view('admin.family-members.index', compact(
            'residents',
            'familyMembers',
            'selectedResident',
            'searchResidentId',
            'searchTerm',
            'isOwnFamily'
        ));
    }

    /**
     * Show form to create family member
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        // Security cannot create
        if ($user->role === 'security') {
            abort(403, 'Security cannot add family members.');
        }

        $residentId = $request->get('resident_id');
        $relations = Relation::where('status', 1)->orderBy('name')->get();

        // For residents, force their own resident_id
        if ($user->role === 'resident') {
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident) {
                return redirect()->route('family-members.index')
                    ->with('error', 'No resident profile found.');
            }

            $residentId = $resident->id;
            $selectedResident = $resident;

            return view('admin.family-members.create', compact('relations', 'selectedResident', 'residentId'));
        }
        // For admin, use provided resident_id
        else if ($user->role === 'admin' && $residentId) {
            $selectedResident = Resident::find($residentId);

            if (!$selectedResident) {
                return redirect()->route('family-members.index')
                    ->with('error', 'Resident not found.');
            }

            return view('admin.family-members.create', compact('relations', 'selectedResident', 'residentId'));
        }
        // Admin without resident_id - show resident selection
        else if ($user->role === 'admin') {
            $residents = Resident::withCount('familyMembers')
                ->orderBy('name')
                ->get();
            return view('admin.family-members.select-resident', compact('residents'));
        }

        abort(400, 'Invalid request');
    }

    /**
     * Store a new family member
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Security cannot store
        if ($user->role === 'security') {
            abort(403);
        }

        $validated = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'name' => 'required|string|max:255',
            'relation_id' => 'required|exists:relations,id',
            'mobile' => 'nullable|string|max:20',
        ], [
            'resident_id.required' => 'Please select a resident.',
            'name.required' => 'Member name is required.',
            'relation_id.required' => 'Please select a relationship.',
        ]);

        // For residents, verify they're only adding to their own family
        if ($user->role === 'resident') {
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident || $resident->id != $request->resident_id) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'You can only add members to your own family.');
            }
        }

        // Check for duplicate
        $exists = FamilyMember::where('resident_id', $request->resident_id)
            ->where('name', $request->name)
            ->where('relation_id', $request->relation_id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This family member already exists.');
        }

        try {
            DB::beginTransaction();

            // Add audit trail fields
            $validated['created_by'] = $user->id;
            $validated['updated_by'] = $user->id;

            $familyMember = FamilyMember::create($validated);

            DB::commit();

            // Optional: Send notification if checked
            if ($request->has('send_notification')) {
                // Send notification logic here
            }

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
     * Show edit form
     */
    public function edit(FamilyMember $familyMember)
    {
        $user = auth()->user();

        // Security cannot edit
        if ($user->role === 'security') {
            abort(403);
        }

        // Residents can only edit their own family members
        if ($user->role === 'resident') {
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident || $resident->id != $familyMember->resident_id) {
                abort(403, 'You can only edit your own family members.');
            }
        }

        $relations = Relation::where('status', 1)->orderBy('name')->get();

        return view('admin.family-members.edit', compact('familyMember', 'relations'));
    }

    /**
     * Update family member
     */
    public function update(Request $request, FamilyMember $familyMember)
    {
        $user = auth()->user();

        // Security cannot update
        if ($user->role === 'security') {
            abort(403);
        }

        // Residents can only update their own family members
        if ($user->role === 'resident') {
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident || $resident->id != $familyMember->resident_id) {
                abort(403);
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'relation_id' => 'required|exists:relations,id',
            'mobile' => 'nullable|string|max:20',
        ]);

        try {
            DB::beginTransaction();

            // Add audit trail
            $validated['updated_by'] = $user->id;

            $familyMember->update($validated);

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
     * Delete family member
     */
    public function destroy(FamilyMember $familyMember)
    {
        $user = auth()->user();

        // Security cannot delete
        if ($user->role === 'security') {
            abort(403);
        }

        // Residents can only delete their own family members
        if ($user->role === 'resident') {
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident || $resident->id != $familyMember->resident_id) {
                abort(403);
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

            // OR hard delete if you prefer:
            // $familyMember->delete();

            DB::commit();

            return redirect()->route('family-members.index', ['resident_id' => $residentId])
                ->with('success', 'Family member "' . $memberName . '" deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to delete family member. Please try again.');
        }
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
            ->orderBy('created_at')
            ->get();

        return response()->json($familyMembers);
    }
}
