<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DeliveryPreapproval;
use App\Models\DeliveryLog;
use App\Models\Notification;

class DeliveryEntryController extends Controller
{
    public function index()
    {
        $expected = DeliveryPreapproval::whereIn(
                'status',
                ['expected', 'inside', 'completed']
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.delivery.entry', compact('expected'));
    }

    // ✅ ENTRY
    public function entry($id)
    {
        $delivery = DeliveryPreapproval::findOrFail($id);

        if ($delivery->status === 'inside') {
            return back()->with('info', 'Delivery already inside');
        }

        DeliveryLog::create([
            'delivery_preapproval_id' => $delivery->id,
            'resident_id'             => $delivery->resident_id,
            'delivery_company_name'   => $delivery->delivery_company_name,
            'guard_name'              => Auth::user()->name,
            'entry_time'              => now(),
        ]);

        $delivery->status = 'inside';
        $delivery->save();

        // 🔔 NOTIFY RESIDENT
        Notification::create([
            'resident_id'  => $delivery->resident_id,
            'reference_id' => $delivery->id,
            'type'         => 'delivery',
            'title'        => 'Delivery Arrived',
            'message'      => "Your delivery from {$delivery->delivery_company_name} has arrived.",
            'is_read'      => 0,
            'audience'     => 'resident',
        ]);

        return back()->with('success', 'Delivery ENTRY marked');
    }

    // ✅ EXIT
    public function exit($id)
    {
        $delivery = DeliveryPreapproval::findOrFail($id);

        $log = DeliveryLog::where('delivery_preapproval_id', $delivery->id)
            ->whereNull('exit_time')
            ->latest()
            ->first();

        if (!$log) {
            return back()->with('error', 'Active delivery entry not found');
        }

        $log->update([
            'exit_time' => now(),
        ]);

        $delivery->status = 'completed';
        $delivery->save();

        // 🔔 NOTIFY RESIDENT
        Notification::create([
            'resident_id'  => $delivery->resident_id,
            'reference_id' => $delivery->id,
            'type'         => 'delivery',
            'title'        => 'Delivery Completed',
            'message'      => "Your delivery from {$delivery->delivery_company_name} has exited the gate.",
            'is_read'      => 0,
            'audience'     => 'resident',
        ]);

        return back()->with('success', 'Delivery EXIT marked');
    }
}
