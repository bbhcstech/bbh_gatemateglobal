<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SecurityGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SecurityGuardController extends Controller
{
    public function index()
    {
        $guards = SecurityGuard::latest()->get();
        return view('admin.security_guards.index', compact('guards'));
    }

    public function create()
    {
        return view('admin.security_guards.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'nullable|email|unique:security_guards,email',
            'phone'      => 'nullable|string|max:20',
            'shift'      => 'required',
        ]);

        $username = strtolower($request->first_name) . rand(1000, 9999);
        $tempPassword = Str::random(8);

        SecurityGuard::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'shift'      => $request->shift,
            'is_active'  => $request->has('is_active'),
            'username'   => $username,
            'password'   => Hash::make($tempPassword),
        ]);

        return redirect()
            ->route('security-guards.index')
            ->with('success', 'Security Guard added successfully.');
    }

    public function edit($id)
    {
        $guard = SecurityGuard::findOrFail($id);
        return view('admin.security_guards.edit', compact('guard'));
    }

    public function update(Request $request, $id)
    {
        $guard = SecurityGuard::findOrFail($id);

        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'nullable|email|unique:security_guards,email,' . $guard->id,
            'phone'      => 'nullable',
            'shift'      => 'required',
        ]);

        $guard->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'shift'      => $request->shift,
            'is_active'  => $request->has('is_active'),
        ]);

        return redirect()
            ->route('security-guards.index')
            ->with('success', 'Security Guard updated successfully');
    }
    
      /* =========================
       TOGGLE ACTIVE / INACTIVE
    ==========================*/
    public function toggle($id)
    {
        $guard = SecurityGuard::findOrFail($id);
        $guard->is_active = !$guard->is_active;
        $guard->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    /* =========================
       RESET PASSWORD
    ==========================*/
    public function resetPassword($id)
    {
        $guard = SecurityGuard::findOrFail($id);
        $newPassword = Str::random(8);

        $guard->update([
            'password' => Hash::make($newPassword),
        ]);

        // Optional: send email / SMS here

        return redirect()->back()
            ->with('success', "Password reset successfully. New password: {$newPassword}");
    }
    
    public function show($id)
{
    $guard = SecurityGuard::findOrFail($id);
    return view('admin.security_guards.show', compact('guard'));
}

}


