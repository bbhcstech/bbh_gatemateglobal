<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ProfilePicture;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Load user with all relationships
        $user = Auth::user()->load([
            'profilePicture',
            'document',
            'familyMembers',
            'pets',
            'vehicles',
            'flat' // Load flat relationship
        ]);

        // If flat exists, load its relationships separately
        if ($user->flat) {
            // Load floor with tower through a separate query
            $user->flat->load('floor.tower');
        }

        // For debugging - you can remove this in production
        \Log::info('Profile loaded for user: ' . $user->id);

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information dynamically.
     * This handles ALL profile fields via AJAX or normal form
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $user = $request->user();

            // Fill all validated data
            $user->fill($request->validated());

            // Handle email verification reset
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            DB::commit();

            // If AJAX request, return JSON response
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile updated successfully!',
                    'user' => $user
                ]);
            }

            return Redirect::route('profile.edit')
                ->with('status', 'profile-updated')
                ->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Profile update failed: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update profile. Please try again.'
                ], 500);
            }

            return Redirect::route('profile.edit')
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }

    /**
     * Update profile picture (AJAX supported)
     */
    public function updatePicture(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();

            // Ensure upload directory exists
            $uploadPath = public_path('uploads/profile');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Upload image
            $image = $request->file('profile_pic');
            $imageName = time() . '_' . uniqid() . '_profile.' . $image->extension();
            $image->move($uploadPath, $imageName);
            $path = 'uploads/profile/' . $imageName;

            // Update or create profile picture record
            $profile = ProfilePicture::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'file_path' => $path,
                    'name' => $imageName,
                    'activity_status' => 1,
                    'deleted_status' => 0,
                    'modified_by' => auth()->id(),
                    'modified_on' => now(),
                ]
            );

            // Update user's profile_pic_id
            $user->profile_pic_id = $profile->profile_pic_id;
            $user->save();

            DB::commit();

            // For AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile picture updated!',
                    'image_url' => asset($path)
                ]);
            }

            return Redirect::route('profile.edit')
                ->with('status', 'profile-picture-updated');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Profile picture upload failed: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update profile picture.'
                ], 500);
            }

            return Redirect::route('profile.edit')
                ->with('error', 'Failed to update profile picture. Please try again.');
        }
    }

    /**
     * Update field dynamically (for inline editing)
     */
    public function updateField(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'nullable|string|max:500'
        ]);

        try {
            $user = Auth::user();
            $field = $request->field;
            $value = $request->value;

            // Check if field exists in fillable
            if (!in_array($field, $user->getFillable())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Field cannot be updated.'
                ], 400);
            }

            $user->$field = $value;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Field updated!',
                'field' => $field,
                'value' => $value
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed: ' . $e->getMessage()
            ], 500);
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

        $user = Auth::user();

        $user->email_notifications = $request->boolean('email_notifications');
        $user->sms_notifications = $request->boolean('sms_notifications');
        $user->whatsapp_notifications = $request->boolean('whatsapp_notifications');
        $user->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification settings updated!'
            ]);
        }

        return Redirect::route('profile.edit')
            ->with('status', 'notifications-updated');
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
