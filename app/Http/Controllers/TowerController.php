<?php

namespace App\Http\Controllers;


use App\Models\Tower;
use App\Models\Floor;
use App\Models\Flat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TowerController extends Controller
{
    public function create()
    {
       $towers = Tower::with('floors.flats.parkingLots')->latest()->get();


    return view('admin.towers.create_dynamic', compact('towers'));
    }

//     public function storeDynamic(Request $request)
// {
//     // 1️⃣ Validation
//     $request->validate([
//         'tower_name' => [
//             'required',
//             Rule::unique('towers', 'name')
//         ],
//         'floors.*.floor_no' => 'required|numeric',
//         'floors.*.flats.*' => 'required'
//     ]);

//     // 2️⃣ Create tower
//     $tower = Tower::create([
//         'name' => $request->tower_name,
//     ]);

//     foreach ($request->floors as $floorData) {

//         // 🚫 Stop duplicate floor in same tower
//         if (Floor::where('tower_id', $tower->id)
//             ->where('floor_no', $floorData['floor_no'])
//             ->exists()) {
//             continue;
//         }

//         $floor = Floor::create([
//             'tower_id' => $tower->id,
//             'floor_no' => $floorData['floor_no'],
//         ]);

//         foreach ($floorData['flats'] as $flatNo) {

//             // 🚫 Stop duplicate flat in same floor
//             if (Flat::where('floor_id', $floor->id)
//                 ->where('flat_no', $flatNo)
//                 ->exists()) {
//                 continue;
//             }

//             Flat::create([
//                 'floor_id' => $floor->id,
//                 'flat_no' => $flatNo,
//             ]);
//         }
//     }

//     return back()->with('success', 'Tower structure saved successfully');
// }


public function storeDynamic(Request $request)
{
    $request->validate([
        'tower_name' => [
            'required',
            Rule::unique('towers', 'name')
        ],
        'floors.*.floor_no' => 'required|numeric',
        'floors.*.flats.*' => 'required'
    ]);

    $tower = Tower::create([
        'name' => $request->tower_name,
    ]);

    foreach ($request->floors as $floorData) {

        if (Floor::where('tower_id', $tower->id)
            ->where('floor_no', $floorData['floor_no'])
            ->exists()) {
            continue;
        }

        $floor = Floor::create([
            'tower_id' => $tower->id,
            'floor_no' => $floorData['floor_no'],
        ]);

        foreach ($floorData['flats'] as $flatNo) {

            if (Flat::where('floor_id', $floor->id)
                ->where('flat_no', $flatNo)
                ->exists()) {
                continue;
            }

            // ✅ SAVE FLAT IN VARIABLE
            $flat = Flat::create([
                'floor_id' => $floor->id,
                'flat_no' => $flatNo,
            ]);

            // ---- STORE PARKING IF EXISTS ----
            if (isset($floorData['parking'])) {

                foreach ($floorData['parking'] as $pIndex => $parkingNo) {

                    \App\Models\ParkingLot::create([
                        'tower_id' => $tower->id,
                        'floor_id' => $floor->id,
                        'flat_id' => $flat->id,   // NOW VALID
                        'parking_no' => $parkingNo,
                        'type' => $floorData['parking_type'][$pIndex] ?? 'Car'
                    ]);

                }
            }
        }
    }

    return back()->with('success', 'Tower structure saved successfully');
}

    
    /* Edit page */
public function edit(Tower $tower)
{
    $tower->load('floors.flats.parkingLots');

    return view('admin.towers.edit', compact('tower'));
}


/* Update tower */
public function update(Request $request, Tower $tower)
{
    $request->validate([
        'tower_name' => 'required|string|max:255',
        'floors.*.floor_no' => 'required',
        'floors.*.flats.*' => 'required',
    ]);

    $tower->update([
        'name' => $request->tower_name,
    ]);

    // Remove old structure including parking
    foreach ($tower->floors as $oldFloor) {
        foreach ($oldFloor->flats as $oldFlat) {
            $oldFlat->parkingLots()->delete();
        }
        $oldFloor->flats()->delete();
    }

    $tower->floors()->delete();

    foreach ($request->floors as $floorData) {

        $floor = Floor::create([
            'tower_id' => $tower->id,
            'floor_no' => $floorData['floor_no'],
        ]);

        foreach ($floorData['flats'] as $flatIndex => $flatNo) {

            $flat = Flat::create([
                'floor_id' => $floor->id,
                'flat_no' => $flatNo,
            ]);

            if (isset($floorData['parking'])) {

                foreach ($floorData['parking'] as $pIndex => $parkingNo) {

                    \App\Models\ParkingLot::create([
                        'tower_id' => $tower->id,
                        'floor_id' => $floor->id,
                        'flat_id' => $flat->id,
                        'parking_no' => $parkingNo,
                        'type' => $floorData['parking_type'][$pIndex] ?? 'Car'
                    ]);
                }
            }
        }
    }

    return redirect()->route('towers.create')
        ->with('success', 'Tower with parking updated successfully');
}



/* Delete tower */
public function destroy(Tower $tower)
{
    if ($tower->floors()->exists()) {
        return back()->with('error', 'Tower cannot be deleted once structure is created');
    }

    $tower->delete();

    return back()->with('success', 'Tower deleted');
}

}


