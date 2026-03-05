<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Tower;
use App\Models\Floor;
use App\Models\Flat;
use App\Models\Role;
use App\Models\Document;
use App\Models\ProfilePicture;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
          $towers = Tower::all();
          $roles = Role::where('is_deleted', 0)
             ->whereNotIn('role_id', [1, 2]) // ✅ exclude superadmin
             ->orderBy('role_name')
             ->get();
        return view('auth.register', compact('towers','roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
 public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'mobile' => ['required', 'numeric', 'digits:10', 'unique:users,mobile'],
        'role' => ['required'],

        'tower_id' => ['required', 'exists:towers,id'],
        'floor_id' => ['required', 'exists:floors,id'],
        'flat_id'  => ['required', 'exists:flats,id'],
        'parking_id' => ['nullable', 'exists:parking_lots,id'],

        'documents' => ['nullable','file','mimes:jpg,jpeg,png,webp,pdf','max:5120'],
        'profile_pic' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],

        'password' => ['required','confirmed', Rules\Password::defaults()],
    ]);

    DB::beginTransaction();

    try {

        // ✅ 1. Create user first
        $user = User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
            'tower_id' => $request->tower_id,
            'floor_id' => $request->floor_id,
            'flat_id'  => $request->flat_id,
            'parking_id' => $request->parking_id,
            'approval_status' => 'pending',
        ]);

        $documentId = null;
        $profilePicId = null;

        // ✅ 2. Upload document
        if ($request->hasFile('documents')) {

            $file = $request->file('documents');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/documents'), $filename);

            $doc = \App\Models\Document::create([
                'name' => $filename,
                'user_id' => $user->id,
                'file_path' => 'uploads/documents/'.$filename,
                'created_by' => auth()->id(),
            ]);

            $documentId = $doc->documents_id;
        }

        // ✅ 3. Upload profile picture
        if ($request->hasFile('profile_pic')) {

            $file = $request->file('profile_pic');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $filename);

            $pic = \App\Models\ProfilePicture::create([
                'name' => $filename,
                'user_id' => $user->id,
                'file_path' => 'uploads/profile/'.$filename,
                'created_by' => auth()->id(),
            ]);

            $profilePicId = $pic->profile_pic_id;
        }

        // ✅ 4. Update user with FK IDs
        $user->update([
            'documents_id' => $documentId,
            'profile_pic_id' => $profilePicId,
        ]);

        DB::commit();

        // Optional: notify admin about new registration (email or notification) 
        return redirect()->route('login')->with('success', 'Registration successful! Your account is pending verification by admin.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}

}
