<?php

namespace App\Http\Controllers;
use App\Models\PetsName;
use App\Models\Pet;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
   public function index()
{
    if (auth()->user()->role === 'admin') {

        $pets = Pet::with(['resident', 'petType'])
            ->latest()
            ->get();
    } 
    else {

        // Correct resident fetch
        $resident = User::where('id', Auth::id())->first();

        if (!$resident) {
            $pets = collect();
        } else {
            $pets = Pet::with(['resident', 'petType'])
                ->where('resident_id', $resident->id)
                ->latest()
                ->get();
        }
    }

    return view('admin.pets.index', compact('pets'));
}



    public function create()
    {
        $petsNames =PetsName::all();
        $residents = Resident::all();
        return view('admin.pets.create', compact('residents','petsNames'));
    }

    public function store(Request $request)
{
    $request->validate([
       
        'name'        => 'required|string|max:100',
        'age'         => 'nullable|integer|min:0',
        'color'       => 'nullable|string|max:50',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // 📌 Resolve resident_id safely
    $residentId = auth()->user()->role === 'admin'
        ? $request->resident_id
        : User::where('id', Auth::id())->value('id');

    $imagePath = null;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('uploads/pets'), $filename);
        $imagePath = 'uploads/pets/'.$filename;
    }

    Pet::create([
        'resident_id' => $residentId,
        // 'pet_name_id' => $request->pet_name_id,
        'type'       => $request->type,
        'name'        => $request->name,
        'age'         => $request->age,
        'color'       => $request->color,
        'image'       => $imagePath,
    ]);

    return redirect()->route('pets.index')
        ->with('success', 'Pet added successfully');
}

    
    public function edit(Pet $pet)
{
    $petsNames = PetsName::where('status', 'active')->get(); // IMPORTANT ()
    $residents = Resident::all();

    return view('admin.pets.edit', compact('pet','residents','petsNames'));
}

        
        public function destroy(Pet $pet)
        {
            $pet->delete();
        
            return redirect()->route('pets.index')
                ->with('success','Pet deleted successfully');
        }
        
   public function update(Request $request, Pet $pet)
{
    // $request->validate([
    //     'pet_name_id' => 'required|exists:pets_name,id',
    //     'name'        => 'required|string|max:100',
    //     'age'         => 'nullable|integer|min:0',
    //     'color'       => 'nullable|string|max:50',
    //     'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    // ]);

    // Handle Image Upload
    $imagePath = $pet->image;

    if ($request->hasFile('image')) {

        // Delete old image if exists
        if ($pet->image && file_exists(public_path($pet->image))) {
            unlink(public_path($pet->image));
        }

        $image = $request->file('image');
        $filename = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('uploads/pets'), $filename);

        $imagePath = 'uploads/pets/'.$filename;
    }

    $pet->update([
        
        'name'        => $request->name,
        'type'       => $request->type,
        'age'         => $request->age,
        'color'       => $request->color,
        'image'       => $imagePath,
    ]);

    return redirect()->route('pets.index')
        ->with('success', 'Pet updated successfully');
}


}
