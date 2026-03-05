<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::latest()->get();
        return view('admin.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'booking_fee' => 'required|numeric',
            'location' => 'required',
            'capacity' => 'required|integer',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('storage/amenities'), $imageName);
            $data['image'] = 'amenities/'.$imageName;
        }


        Amenity::create($data);

        return redirect()->route('amenities.index')
            ->with('success', 'Amenity added successfully');
    }
    
    public function show(Amenity $amenity)
    {
        return view('admin.amenities.show', compact('amenity'));
    }
    
    // Show the edit form for a specific amenity
    public function edit($id)
    {
        // Find the amenity or throw 404
        $amenity = Amenity::findOrFail($id);

        // Return the edit view with the amenity data
        return view('admin.amenities.edit', compact('amenity'));
    }

    // Update function (optional but usually paired with edit)
    public function update(Request $request, $id)
    {
        $amenity = Amenity::findOrFail($id);

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update data
        $amenity->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('amenities.index')->with('success', 'Amenity updated successfully!');
    }
    
    public function destroy($id)
    {
        // Find the amenity or fail
        $amenity = Amenity::findOrFail($id);
    
        // Delete the record
        $amenity->delete();
    
        // Redirect back with success message
        return redirect()->route('amenities.index')
                         ->with('success', 'Amenity deleted successfully!');
    }

}
