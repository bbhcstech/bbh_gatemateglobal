<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use App\Models\Tower;
use App\Models\Floor;
use App\Models\Flat;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        
        $towers = Tower::all();
        return view('auth.login', compact('towers'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Step 1: Authenticate credentials
        $request->authenticate();

        $user = Auth::user();

       if ($user->approval_status === 'pending') {
    Auth::logout();

    return back()->withErrors([
        'mobile' => 'Your account is pending awaiting for admin approval.',
    ]);
}

if ($user->approval_status === 'rejected') {

    Auth::logout();

    // Delete user record permanently
    $user->delete();

    return back()->withErrors([
        'mobile' => 'You are not a registered user, Please Signup with correct document details',
    ]);
}


// if ($user->approval_status === 'rejected') {
//     Auth::logout();

//     return back()->withErrors([
//         'mobile' => 'Your account has been rejected by admin.',
//     ]);
// }


        // Step 3: Regenerate session ONLY for approved users
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        Session::forget('auth_id');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
