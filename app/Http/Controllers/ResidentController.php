<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Resident;
use App\Models\Tower;
use App\Models\Floor;
use App\Models\Flat;
use App\Models\ParkingLot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResidentController extends Controller
{
    public function index()
{
    if (auth()->user()->role == 'admin') {

        // Admin can see all residents
        $residents = Resident::latest()->get();

    } else {

        // Resident can see only his own data
        $residents = Resident::where('user_id', auth()->id())->get();
    }

    return view('admin.residents.index', compact('residents'));
}


    public function create()
    {
        $towers = Tower::all();
        return view('admin.residents.create', compact('towers'));
    }

public function store(Request $request)
{
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'tower_id' => 'required|exists:towers,id',
        'floor_id' => 'required|exists:floors,id',
        'flat_id'  => 'required|exists:flats,id',
        'phone'    => 'required|digits:10',
        'email'    => 'required|email|unique:users,email',
        'type'     => 'required|in:owner,tenant',
    ]);

    /* ---------------- CREATE USER ---------------- */
    $user = User::create([
        'name'         => $data['name'],
        'email'        => $data['email'],
        'role'         => 'resident',
        'password'     => Hash::make('Password@123'), // default password
        'otp_verified' => 1,
    ]);

    /* ---------------- CREATE RESIDENT ---------------- */
    Resident::create([
        'user_id'  => $user->id,   // 🔑 LINK USER
        'name'     => $data['name'],
        'tower_id' => $data['tower_id'],
        'floor_id' => $data['floor_id'],
        'flat_id'  => $data['flat_id'],
        'phone'    => $data['phone'],
        'email'    => $data['email'],
        'type'     => $data['type'],
    ]);

    return redirect()->route('residents.index')
        ->with('success', 'Resident & Login account created successfully');
}


    // public function show(Resident $resident)
    // {
    //     return view('admin.residents.show', compact('resident'));
    // }


        public function show($id)
        {
            $resident = Resident::with('familyMembers.relation')->find($id);

            return view('resident.profile', compact('resident'));
        }

    public function edit(Resident $resident)
    {
         $towers = Tower::all();
        return view('admin.residents.edit', compact('resident','towers'));
    }

  public function update(Request $request, Resident $resident)
{
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'tower_id' => 'required|exists:towers,id',
        'floor_id' => 'required|exists:floors,id',
        'flat_id'  => 'required|exists:flats,id',
        'phone'    => 'required|digits:10',
        'email'    => 'nullable|email',
        'type'     => 'required|in:owner,tenant',
    ]);

    $resident->update($data);

    // Optional: sync name/email to user
    if ($resident->user) {
        $resident->user->update([
            'name'  => $data['name'],
            'email' => $data['email'] ?? $resident->user->email,
        ]);
    }

    return redirect()->route('residents.index')
        ->with('success', 'Resident updated successfully');
}


    public function destroy(Resident $resident)
    {
        $resident->delete();

        return redirect()->route('residents.index')
            ->with('success', 'Resident deleted successfully');
    }

    public function getFloors($towerId)
    {
        return Floor::where('tower_id', $towerId)
            ->select('id', 'floor_no')
            ->orderBy('floor_no')
            ->get();
    }

    public function getFlats($floorId)
    {
        return Flat::where('floor_id', $floorId)
            ->select('id', 'flat_no')
            ->orderBy('flat_no')
            ->get();
    }

     public function getParking($flat_id)
    {
        $parking = ParkingLot::where('flat_id', $flat_id)->get();

        return response()->json($parking);
    }
}
