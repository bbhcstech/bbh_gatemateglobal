<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Flat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the complaints.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = strtolower($user->roleMaster->role_name ?? '') === 'admin';
        $isResident = strtolower($user->roleMaster->role_name ?? '') === 'resident';

        $query = Complaint::with(['resident', 'resident.flat']);

        // Filter by user role - show only active complaints (not archived)
        if ($isResident) {
            $query->where('resident_id', $user->id);
        }

        // Exclude soft deleted complaints
        $query->whereNull('deleted_at');

        // Apply date range filter
        if ($request->filled('date_range')) {
            $dateRange = $request->date_range;
            if (strpos($dateRange, ' to ') !== false) {
                $dates = explode(' to ', $dateRange);
                $startDate = $dates[0];
                $endDate = $dates[1];
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($dateRange === 'Today') {
                $query->whereDate('created_at', today());
            } elseif ($dateRange === 'Last 7 Days') {
                $query->whereDate('created_at', '>=', now()->subDays(6));
            } elseif ($dateRange === 'Last 30 Days') {
                $query->whereDate('created_at', '>=', now()->subDays(29));
            } elseif ($dateRange === 'This Month') {
                $query->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
            } elseif ($dateRange === 'Last Month') {
                $query->whereMonth('created_at', now()->subMonth()->month)
                      ->whereYear('created_at', now()->subMonth()->year);
            }
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Apply type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $complaints = $query->latest()->get();

        return view('admin.complaints.index', compact('complaints'));
    }

    /**
     * Show all residents' complaints (for residents to see other complaints)
     * Like pets.all-residents in pet management
     */
    public function allResidents(Request $request)
    {
        $user = Auth::user();
        $isResident = strtolower($user->roleMaster->role_name ?? '') === 'resident';

        // Only residents can access this
        if (!$isResident) {
            abort(403, 'Unauthorized access.');
        }

        $query = Complaint::with(['resident', 'resident.flat'])
            ->whereNull('deleted_at'); // Exclude archived

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_range')) {
            $dateRange = $request->date_range;
            if (strpos($dateRange, ' to ') !== false) {
                $dates = explode(' to ', $dateRange);
                $startDate = $dates[0];
                $endDate = $dates[1];
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        $complaints = $query->latest()->get();

        $totalComplaints = $complaints->count();
        $pendingCount = $complaints->where('status', 'pending')->count();
        $inProgressCount = $complaints->where('status', 'in progress')->count();
        $resolvedCount = $complaints->where('status', 'resolved')->count();

        return view('admin.complaints.all-residents', compact('complaints', 'totalComplaints', 'pendingCount', 'inProgressCount', 'resolvedCount'));
    }

    /**
     * Show the form for creating a new complaint.
     */
    public function create()
    {
        $user = Auth::user();
        $isAdmin = strtolower($user->roleMaster->role_name ?? '') === 'admin';
        $isResident = strtolower($user->roleMaster->role_name ?? '') === 'resident';

        if (!$isAdmin && !$isResident) {
            abort(403, 'Unauthorized action.');
        }

        $flats = [];
        if ($isAdmin) {
            $flats = Flat::where('status', 'occupied')->get();
            $residents = User::whereHas('roleMaster', function($query) {
                $query->whereRaw('LOWER(role_name) = ?', ['resident']);
            })->get();
        }

        return view('admin.complaints.create', compact('flats', 'residents'));
    }

    /**
     * Store a newly created complaint in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $isAdmin = strtolower($user->roleMaster->role_name ?? '') === 'admin';
        $isResident = strtolower($user->roleMaster->role_name ?? '') === 'resident';

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:maintenance,noise,security,cleanliness,amenities,other',
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ];

        if ($isAdmin) {
            $rules['resident_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'priority' => $request->priority,
            'status' => 'pending',
            'resident_id' => $isAdmin ? $request->resident_id : $user->id,
        ];

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('complaints', 'public');
            $data['attachment'] = $path;
        }

        Complaint::create($data);

        return redirect()->route('complaints.index')
            ->with('success', 'Complaint raised successfully.');
    }

    /**
     * Display the specified complaint.
     */
    public function show($id)
    {
        $user = Auth::user();
        $isAdmin = strtolower($user->roleMaster->role_name ?? '') === 'admin';
        $isResident = strtolower($user->roleMaster->role_name ?? '') === 'resident';

        $complaint = Complaint::with(['resident', 'resident.flat'])->findOrFail($id);

        // Check authorization
        if (!$isAdmin && $complaint->resident_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified complaint.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $isAdmin = strtolower($user->roleMaster->role_name ?? '') === 'admin';
        $isResident = strtolower($user->roleMaster->role_name ?? '') === 'resident';

        $complaint = Complaint::findOrFail($id);

        // Check authorization
        if (!$isAdmin && $complaint->resident_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // Residents can only edit pending complaints
        if ($isResident && $complaint->status !== 'pending') {
            return redirect()->route('complaints.index')
                ->with('error', 'Cannot edit complaint that is already in progress or resolved.');
        }

        $flats = [];
        if ($isAdmin) {
            $flats = Flat::where('status', 'occupied')->get();
            $residents = User::whereHas('roleMaster', function($query) {
                $query->whereRaw('LOWER(role_name) = ?', ['resident']);
            })->get();
        }

        return view('admin.complaints.edit', compact('complaint', 'flats', 'residents'));
    }

    /**
     * Update the specified complaint in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $isAdmin = strtolower($user->roleMaster->role_name ?? '') === 'admin';
        $isResident = strtolower($user->roleMaster->role_name ?? '') === 'resident';

        $complaint = Complaint::findOrFail($id);

        // Check authorization
        if (!$isAdmin && $complaint->resident_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // Residents can only update pending complaints
        if ($isResident && $complaint->status !== 'pending') {
            return redirect()->route('complaints.index')
                ->with('error', 'Cannot update complaint that is already in progress or resolved.');
        }

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:maintenance,noise,security,cleanliness,amenities,other',
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ];

        if ($isAdmin) {
            $rules['resident_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'priority' => $request->priority,
        ];

        if ($isAdmin) {
            $data['resident_id'] = $request->resident_id;
        }

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($complaint->attachment) {
                Storage::disk('public')->delete($complaint->attachment);
            }
            $path = $request->file('attachment')->store('complaints', 'public');
            $data['attachment'] = $path;
        }

        $complaint->update($data);

        return redirect()->route('complaints.index')
            ->with('success', 'Complaint updated successfully.');
    }

    /**
     * Update complaint status (Admin only)
     */
    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        $isAdmin = strtolower($user->roleMaster->role_name ?? '') === 'admin';

        if (!$isAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,in progress,resolved'
        ]);

        $complaint = Complaint::findOrFail($id);
        $oldStatus = $complaint->status;
        $complaint->status = $request->status;
        $complaint->save();

        // Get updated counts
        $totalComplaints = Complaint::whereNull('deleted_at')->count();
        $pendingCount = Complaint::whereNull('deleted_at')->where('status', 'pending')->count();
        $inProgressCount = Complaint::whereNull('deleted_at')->where('status', 'in progress')->count();
        $resolvedCount = Complaint::whereNull('deleted_at')->where('status', 'resolved')->count();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'counts' => [
                'total' => $totalComplaints,
                'pending' => $pendingCount,
                'in_progress' => $inProgressCount,
                'resolved' => $resolvedCount
            ]
        ]);
    }

    /**
     * Confirm resolution (Resident only)
     */
    public function confirmResolution(Request $request, $id)
    {
        $user = Auth::user();
        $isResident = strtolower($user->roleMaster->role_name ?? '') === 'resident';

        $complaint = Complaint::findOrFail($id);

        // Check authorization
        if (!$isResident || $complaint->resident_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        // Check if complaint is resolved
        if ($complaint->status !== 'resolved') {
            return response()->json([
                'success' => false,
                'message' => 'Complaint must be resolved before confirmation.'
            ], 400);
        }

        // Check if already confirmed
        if ($complaint->confirmed_by_resident) {
            return response()->json([
                'success' => false,
                'message' => 'Complaint already confirmed.'
            ], 400);
        }

        $complaint->confirmed_by_resident = true;
        $complaint->confirmed_at = now();
        $complaint->save();

        return response()->json([
            'success' => true,
            'message' => 'Resolution confirmed. Thank you for your feedback!'
        ]);
    }

    /**
     * Remove the specified complaint from storage (soft delete / archive)
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $isAdmin = strtolower($user->roleMaster->role_name ?? '') === 'admin';

        if (!$isAdmin) {
            return redirect()->route('complaints.index')
                ->with('error', 'Only administrators can archive complaints.');
        }

        $complaint = Complaint::findOrFail($id);
        $complaint->delete(); // Soft delete

        return redirect()->route('complaints.index')
            ->with('success', 'Complaint archived successfully.');
    }

    /**
     * Bulk delete complaints (Admin only)
     */
    public function bulkDelete(Request $request)
    {
        $user = Auth::user();
        $isAdmin = strtolower($user->roleMaster->role_name ?? '') === 'admin';

        if (!$isAdmin) {
            return redirect()->route('complaints.index')
                ->with('error', 'Only administrators can perform bulk actions.');
        }

        $request->validate([
            'ids' => 'required|string'
        ]);

        $ids = explode(',', $request->ids);
        Complaint::whereIn('id', $ids)->delete();

        return redirect()->route('complaints.index')
            ->with('success', count($ids) . ' complaints archived successfully.');
    }

    /**
     * Bulk update status (Admin only)
     */
    public function bulkStatusUpdate(Request $request)
    {
        $user = Auth::user();
        $isAdmin = strtolower($user->roleMaster->role_name ?? '') === 'admin';

        if (!$isAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $request->validate([
            'ids' => 'required|string',
            'status' => 'required|in:pending,in progress,resolved'
        ]);

        $ids = explode(',', $request->ids);
        Complaint::whereIn('id', $ids)->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully for selected complaints.'
        ]);
    }

    /**
     * Display archived complaints (Admin only)
     */
    public function archived()
    {
        $user = Auth::user();
        $isAdmin = strtolower($user->roleMaster->role_name ?? '') === 'admin';

        if (!$isAdmin) {
            abort(403, 'Unauthorized access.');
        }

        $complaints = Complaint::onlyTrashed()
            ->with(['resident', 'resident.flat'])
            ->latest()
            ->get();

        return view('admin.complaints.archived', compact('complaints'));
    }
}
