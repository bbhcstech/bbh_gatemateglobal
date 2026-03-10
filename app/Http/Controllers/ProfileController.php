<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;
use App\Models\ProfilePicture;
use App\Models\FamilyMember;
use App\Models\Pet;
use App\Models\Vehicle;
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
            // Load user with all relationships including family members, pets, and vehicles
            $user = User::with([
                'profilePicture',
                'document',
                'familyMembers',
                'pets',
                'vehicles'
            ])->findOrFail(auth()->id());

            // Debug info - you can remove this in production
            if ($user->profilePicture) {
                \Log::info('Profile picture loaded for user ' . $user->id . ': ' . $user->profilePicture->file_path);
            }

            return view('profile.edit', compact('user'));
        }

        abort(403, 'Unauthorized access');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $user = $request->user();
            $user->fill($request->validated());

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            // PROFILE PICTURE UPLOAD
            if ($request->file('profile_pic') && $request->file('profile_pic')->isValid()) {

                $image = $request->file('profile_pic');
                $imageName = time() . '_' . uniqid() . '_profile.' . $image->extension();
                $image->move(public_path('uploads/profile'), $imageName);
                $path = 'uploads/profile/' . $imageName;

                $profile = ProfilePicture::create([
                    'user_id' => $user->id,
                    'file_path' => $path,
                    'name' => $imageName,
                    'activity_status' => 1,
                    'deleted_status' => 0,
                    'created_by' => auth()->id(),
                    'created_on' => now(),
                ]);

                $user->profile_pic_id = $profile->profile_pic_id;
            }

            // DOCUMENT UPLOAD (keep as is)
            if ($request->file('documents') && $request->file('documents')->isValid()) {
                $doc = $request->file('documents');
                $docName = time() . '_document.' . $doc->extension();
                $doc->move(public_path('uploads/documents'), $docName);

                $document = Document::create([
                    'name' => $docName,
                    'user_id' => $user->id,
                    'file_path' => 'uploads/documents/' . $docName,
                    'activity_status' => 1,
                    'deleted_status' => 0,
                    'created_by' => auth()->id(),
                    'created_on' => now(),
                ]);

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
     * Update profile picture separately (for the camera icon upload)
     */
    public function updatePicture(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120' // Increased to 5MB
        ]);

        DB::beginTransaction();

        try {
            $user = auth()->user();

            // Ensure upload directory exists
            $uploadPath = public_path('uploads/profile');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            if ($request->file('profile_pic') && $request->file('profile_pic')->isValid()) {

                $image = $request->file('profile_pic');
                $imageName = time() . '_' . uniqid() . '_profile.' . $image->extension();
                $image->move($uploadPath, $imageName);
                $path = 'uploads/profile/' . $imageName;

                // Create new record in profile_pictures table
                $profile = ProfilePicture::create([
                    'user_id' => $user->id,
                    'file_path' => $path,
                    'name' => $imageName,
                    'activity_status' => 1,
                    'deleted_status' => 0,
                    'created_by' => auth()->id(),
                    'created_on' => now(),
                ]);

                // Update user's profile_pic_id to point to the new record
                $user->profile_pic_id = $profile->profile_pic_id;
                $user->save();

                // IMPORTANT: Refresh the user model with relationships
                $user->load('profilePicture');
            }

            DB::commit();

            return Redirect::route('profile.edit')->with('status', 'profile-picture-updated');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Profile picture upload failed: ' . $e->getMessage());
            return Redirect::route('profile.edit')->with('error', 'Failed to update profile picture. Please try again.');
        }
    }

    /**
     * Update notification preferences
     */
    public function updateNotifications(Request $request): RedirectResponse
    {
        $request->validate([
            'email_notifications' => 'sometimes|boolean',
            'sms_notifications' => 'sometimes|boolean',
            'whatsapp_notifications' => 'sometimes|boolean',
        ]);

        $user = auth()->user();

        $user->email_notifications = $request->boolean('email_notifications');
        $user->sms_notifications = $request->boolean('sms_notifications');
        $user->whatsapp_notifications = $request->boolean('whatsapp_notifications');
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'notifications-updated');
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
