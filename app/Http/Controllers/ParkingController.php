<?php 
namespace App\Http\Controllers;

use App\Models\ParkingLot;
use App\Models\Tower;
use App\Models\Floor;
use App\Models\Flat;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function index()
    {
        $towers = Tower::all();
        $parkings = ParkingLot::with('tower','floor','flat')->get();

        return view('admin.parking.index', compact('towers','parkings'));
    }

    public function getFloors($tower_id)
    {
        return Floor::where('tower_id', $tower_id)->get();
    }

    public function getFlats($floor_id)
    {
        return Flat::where('floor_id', $floor_id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'tower_id' => 'required',
            'floor_id' => 'required',
            'flat_id' => 'required',
            'parking_no' => 'required',
            'type' => 'required'
        ]);

        ParkingLot::create($request->all());

        return back()->with('success','Parking Added Successfully');
    }

    public function destroy($id)
    {
        ParkingLot::find($id)->delete();

        return back()->with('success','Parking Deleted');
    }
}
