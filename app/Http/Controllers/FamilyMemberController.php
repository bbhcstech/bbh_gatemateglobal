<?php
namespace App\Http\Controllers;

use App\Models\FamilyMember;
use App\Models\Relation;
use App\Models\Resident;
use Illuminate\Http\Request;
use Auth;

class FamilyMemberController extends Controller
{
public function index()
{
    if (auth()->user()->role === 'admin') {

        $familyMembers = FamilyMember::with(['resident','relation'])
            ->latest()
            ->get();
    } else {

        $resident = Resident::where('user_id', Auth::id())->first();

        if (!$resident) {
            $familyMembers = collect();
        } else {
            $familyMembers = FamilyMember::with('relation')
                ->where('resident_id', $resident->id)
                ->latest()
                ->get();
        }
    }

    return view('admin.family_members.index', compact('familyMembers'));
}

    public function create()
    {
        $relations = Relation::where('status', 1)->orderBy('name')->get();
       $residents = auth()->user()->role === 'admin'
        ? Resident::orderBy('name')->get()
        : collect();

    return view('admin.family_members.create', compact('residents','relations'));
    }
    
    
    
public function store(Request $request)
{
    if (auth()->user()->role === 'admin') {

        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'name'        => 'required|string|max:255',
            'relation_id' => 'required|exists:relations,id',
            'mobile'      => ['nullable','regex:/^[6-9]\d{9}$/'],
        ]);

        $residentId = $request->resident_id;
    } 
    else {

        $resident = Resident::where('user_id', Auth::id())->firstOrFail();
        $residentId = $resident->id;

        $request->validate([
            'name'        => 'required|string|max:255',
            'relation_id' => 'required|exists:relations,id',
            'mobile'      => ['nullable','regex:/^[6-9]\d{9}$/'],
        ]);
    }

    FamilyMember::create([
        'resident_id' => $residentId,
        'name'        => $request->name,
        'relation_id' => $request->relation_id, // ✅ FIXED
        'mobile'      => $request->mobile,
    ]);

    return redirect()->route('family-members.index')
        ->with('success','Family member added successfully');
}



    public function edit(FamilyMember $familyMember)
    {
         $relations = Relation::where('status', 1)->orderBy('name')->get();
        $residents = auth()->user()->role === 'admin'
        ? Resident::orderBy('name')->get()
        : collect();
        return view('admin.family_members.create', compact('familyMember','residents','relations'));
    }

    public function update(Request $request, FamilyMember $familyMember)
{
    // ADMIN
    if (auth()->user()->role === 'admin') {

        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'name'        => 'required|string|max:255',
            'relation_id' => 'required|exists:relations,id',
            'mobile'      => ['nullable','regex:/^[6-9]\d{9}$/'],
        ]);

        $residentId = $request->resident_id;
    }
    // RESIDENT
    else {

        $resident = Resident::where('user_id', Auth::id())->firstOrFail();
        $residentId = $resident->id;

        $request->validate([
            'name'        => 'required|string|max:255',
            'relation_id' => 'required|exists:relations,id',
            'mobile'      => ['nullable','regex:/^[6-9]\d{9}$/'],
        ]);
    }

    // ✅ UPDATE SAFE FIELDS ONLY
    $familyMember->update([
        'resident_id' => $residentId,
        'name'        => $request->name,
        'relation_id' => $request->relation_id,
        'mobile'      => $request->mobile,
    ]);

    return redirect()->route('family-members.index')
        ->with('success', 'Family member updated successfully');
}


    public function destroy(FamilyMember $familyMember)
    {
        $familyMember->delete();
        return back()->with('success', 'Family member deleted');
    }
}
