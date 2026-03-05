<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;
use App\Models\ProfilePicture;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
  public function edit(Request $request): View
{
   if (in_array(
    strtolower(optional(auth()->user()->roleMaster)->role_name),
    ['admin', 'resident', 'security']
)) {
        // return view('profile.edit', [
        //     'user' => $request->user(),
        // ]);
        
        $user = User::with(['profilePicture', 'document'])
                    ->findOrFail(auth()->id());

        return view('profile.edit', compact('user'));
    }

    abort(403, 'Unauthorized access');
}


    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //   $user = $request->user();

    // // ✅ Update normal fields
    // $user->fill($request->validated());

    // // ✅ Reset email verification if email changed
    // if ($user->isDirty('email')) {
    //     $user->email_verified_at = null;
    // }

    // // ✅ Profile Picture Upload
    // if ($request->hasFile('profile_pic')) {
    //     $image = $request->file('profile_pic');
    //     $imageName = time().'_profile.'.$image->extension();
    //     $image->move(public_path('uploads/profile'), $imageName);
    //     $user->profile_pic = 'uploads/profile/'.$imageName;
    // }

    // // ✅ Documents Upload
    // if ($request->hasFile('documents')) {
    //     $doc = $request->file('documents');
    //     $docName = time().'_document.'.$doc->extension();
    //     $doc->move(public_path('uploads/documents'), $docName);
    //     $user->documents = 'uploads/documents/'.$docName;
    // }

    // $user->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }
    
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    DB::beginTransaction();

    try {
        $user = $request->user();

        // ✅ Update normal fields
        $user->fill($request->validated());

        // ✅ Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        /*
        |--------------------------------------------------------------------------
        | PROFILE PICTURE
        |--------------------------------------------------------------------------
        */
        // PROFILE PICTURE
        if ($request->file('profile_pic') && $request->file('profile_pic')->isValid()) {
        
            $image = $request->file('profile_pic');
            $imageName = time().'_profile.'.$image->extension();
            $image->move(public_path('uploads/profile'), $imageName);
        
            $profile = ProfilePicture::create([
                'user_id' => $user->id,
                'file_path' => 'uploads/profile/'.$imageName,
                'activity_status' => 1,
                'deleted_status' => 0,
                'created_by' => auth()->id(),
                'created_on' => now(),
            ]);
        
            $user->profile_pic_id = $profile->profile_pic_id;
        }

        /*
        |--------------------------------------------------------------------------
        | DOCUMENT UPLOAD
        |--------------------------------------------------------------------------
        */
        if ($request->file('documents') && $request->file('documents')->isValid()) {

            $doc = $request->file('documents');
            $docName = time().'_document.'.$doc->extension();
            $doc->move(public_path('uploads/documents'), $docName);

            $document = Document::create([
                'name' => $docName,
                'user_id' => $user->id,
                'file_path' => 'uploads/documents/'.$docName,
                'activity_status' => 1,
                'deleted_status' => 0,
                'created_by' => auth()->id(),
                'created_on' => now(),
            ]);

            // ✅ store only ID in users table
            $user->documents_id = $document->documents_id;
        }

        $user->save();

        DB::commit();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');

    } catch (\Exception $e) {

        DB::rollBack();
        throw $e;
    }
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
