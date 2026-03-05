<?php

namespace App\Http\Controllers;

use App\Models\DomesticHelp;
use Illuminate\Http\Request;

class DomesticHelpController extends Controller
{
    public function index()
    {
        $helpers = DomesticHelp::where('user_id', auth()->id())->latest()->get();
        return view('admin.domestic_helps.index', compact('helpers'));
    }

    public function create()
    {
        return view('admin.domestic_helps.create');
    }

    public function store(Request $request)
    {
       // echo auth()->id();die;
        $request->validate([
            'type' => 'required',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'document' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

    $data['user_id'] = auth()->id();

    // ✅ Photo upload
  
    
     $imagePath1 = null;

    if ($request->hasFile('photo')) {
        $image = $request->file('photo');

        $filename = time().'_'.$image->getClientOriginalName();

        // ✅ Move directly to public folder
        $image->move(public_path('uploads/domestic_helps/photos'), $filename);

        $imagePath1 = 'uploads/domestic_helps/photos/'.$filename;
    }

    // ✅ Document upload
   
    
     $imagePath = null;

    if ($request->hasFile('document')) {
        $image = $request->file('document');

        $filename = time().'_'.$image->getClientOriginalName();

        // ✅ Move directly to public folder
        $image->move(public_path('uploads/domestic_helps/documents'), $filename);

        $imagePath = 'uploads/domestic_helps/documents/'.$filename;
    }

        DomesticHelp::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'name' => $request->name,
            'phone' => $request->phone,
            'service' => $request->service,
            'vehicle_number' => $request->vehicle_number,
            'notes' => $request->notes,
            'image' => $imagePath1,
            'documents' => $imagePath
        ]);

        return redirect()->route('domestic-helps.index')
            ->with('success', 'Added successfully');
    }

    public function edit(DomesticHelp $domestic_help)
    {
        return view('admin.domestic_helps.edit', compact('domestic_help'));
    }

    public function update(Request $request, DomesticHelp $domestic_help)
    {
        $domestic_help->update($request->all());

        return redirect()->route('domestic-helps.index')
            ->with('success', 'Updated successfully');
    }

    public function destroy(DomesticHelp $domestic_help)
    {
        $domestic_help->delete();

        return back()->with('success', 'Deleted successfully');
    }
}
