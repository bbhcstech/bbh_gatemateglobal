<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Patrol;
use App\Models\SecurityGuard;
use App\Models\Zone;
use Illuminate\Http\Request;

class PatrolController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date;

        $patrols = Patrol::with(['securityGuard', 'zone'])

            ->when($date, fn($q) =>
                $q->whereDate('start_time', $date)
            )
            ->latest()
            ->get();

        return view('admin.patrols.index', compact('patrols', 'date'));
    }

    public function create()
    {
        return view('admin.patrols.create', [
            'guards' => SecurityGuard::all(),
            'zones'  => Zone::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'security_guard_id' => 'required',
            'zone_id' => 'required',
            'start_time' => 'required',
            'checkpoints' => 'required',
            'status' => 'required',
        ]);

        Patrol::create($request->all());

        return redirect()->route('patrols.index')
            ->with('success', 'Patrol log added successfully');
    }
    
    public function show($id)
    {
        $patrol = Patrol::with(['securityGuard', 'zone'])->findOrFail($id);
        return view('admin.patrols.show', compact('patrol'));
    }

    public function edit($id)
    {
        $patrol = Patrol::findOrFail($id);
        $guards = SecurityGuard::active()->get();
        $zones  = Zone::all();

        return view('admin.patrols.edit', compact('patrol','guards','zones'));
    }

    public function update(Request $request, $id)
    {
        $patrol = Patrol::findOrFail($id);

        $patrol->update($request->all());

        return redirect()->route('patrols.index')
            ->with('success','Patrol updated successfully');
    }

    public function destroy($id)
    {
        Patrol::findOrFail($id)->delete();

        return redirect()->route('patrols.index')
            ->with('success','Patrol deleted successfully');
    }
    
    public function changeStatus(Request $request, Patrol $patrol)
        {
            $request->validate([
                'status' => 'required|in:Scheduled,In Progress,Completed,Cancelled',
            ]);
        
            $patrol->update(['status' => $request->status]);
        
            return response()->json(['success' => true]);
        }

}
