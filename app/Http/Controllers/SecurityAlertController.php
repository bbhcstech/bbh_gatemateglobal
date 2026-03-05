<?php

namespace App\Http\Controllers;

use App\Models\SecurityAlert;
use Illuminate\Http\Request;

class SecurityAlertController extends Controller
{
    public function index()
    {
        $alerts = SecurityAlert::latest()->get();

        return view('admin.security.alerts', compact('alerts'));
    }

    public function store(Request $request)
    {
        SecurityAlert::create([
            'resident_id' => auth()->id(),
            'alert_type'  => $request->alert_type,
            'message'     => $request->message,
            'created_at'  => now(),
            'status'      => 'Open'
        ]);

        return back()->with('success', 'Alert Created');
    }

    public function resolve($id)
    {
        $alert = SecurityAlert::findOrFail($id);

        $alert->status = 'Resolved';
        $alert->save();

        return back()->with('success', 'Alert Resolved');
    }
}
