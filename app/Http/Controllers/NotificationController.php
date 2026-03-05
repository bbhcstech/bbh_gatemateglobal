<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\VisitorPreapproval;
use App\Models\CabPreapproval;
class NotificationController extends Controller
{
  public function index(Request $request)
{
    $user = auth()->user();

    $query = Notification::query();

    // 🔹 Filter by type
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($user->role === 'security') {

        // ✅ SECURITY sees ALL notifications
        $notifications = $query
        ->where('audience', 'security')

            ->orderBy('is_read')
            ->orderByDesc('created_at')
            ->get();

    } else {

        // ✅ RESIDENT sees only his notifications
        $notifications = $query
            ->where('resident_id', $user->id)
            ->where('audience', 'resident')

            ->orderBy('is_read')
            ->orderByDesc('created_at')
            ->get();
    }

    return view('admin.security.notifications', compact('notifications'));
}






// public function markRead($id)
// {
//     $note = Notification::findOrFail($id);

//     $note->is_read = true;
//     $note->save();

//     if ($note->reference_id) {

//         $preapproval = VisitorPreapproval::find($note->reference_id);

//         if ($preapproval && $preapproval->status == 'pending') {

//             $preapproval->status = 'approved';
//             $preapproval->save();

//             Notification::create([
//                 'resident_id' => $preapproval->resident_id,
//                 'reference_id' => $preapproval->id,
//                 'title'       => 'Visitor Approved',
//                 'message'     => "Your visitor {$preapproval->name} has been approved by security.",
//                 'is_read'     => 0
//             ]);
//         }
//     }

//     return back()->with('success', 'Visitor approved and resident notified');
// }

public function markRead($id)
{
    // ✅ update directly
    Notification::where('notification_id', $id)
        ->update(['is_read' => 1]);

    $note = Notification::where('notification_id', $id)->first();

    if (!$note) {
        return back();
    }

    // ================= VISITOR =================
    if ($note->type === 'visitor' && $note->reference_id) {

        $preapproval = VisitorPreapproval::find($note->reference_id);

        if ($preapproval && $preapproval->status === 'pending') {

            $preapproval->update(['status' => 'approved']);
            $preapproval->save();

            Notification::create([
                'resident_id'  => $preapproval->resident_id,
                'reference_id' => $preapproval->id,
                'type'         => 'visitor',
                'title'        => 'Visitor Approved',
                'message'      => "Your visitor {$preapproval->name} has been approved by security.",
                'is_read'      => 0,
                'audience'=>'resident',
            ]);
        }
    }

    // ================= CAB =================
    if ($note->type === 'cab' && $note->reference_id) {

        $cab = CabPreapproval::find($note->reference_id);

        if ($cab && $cab->status === 'pending') {
            
            $cab->update(['status' => 'approved']);
            $cab->save();
            Notification::create([
                'resident_id'  => $cab->resident_id,
                'reference_id' => $cab->id,
                'type'         => 'cab',
                'title'        => 'Cab Approved',
                'message'      => "Your cab ({$cab->company_name}) is approved for Flat {$cab->flat_no}.",
                'is_read'      => 0,
                'audience'=>'resident',
            ]);
        }
    }

    return back()->with('success', 'Notification marked as read');
}




}
