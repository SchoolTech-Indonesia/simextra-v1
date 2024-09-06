<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
            'profile_photo' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
            ], 422); 
        }

        $user = Auth::user();

        // Store the uploaded file
        $path = $request->file('profile_photo')->store('profile_photos', 'public');

        // Delete the old profile photo if it exists
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Update the user's profile photo path
        $user->profile_photo_path = $path;
        $user->save();

        // Return a JSON response with the URL of the new profile photo
        return response()->json([
            'success' => 'Profile photo uploaded successfully.',
            'photo_url' => Storage::url($path)
        ]);
    }

    public function updateProfile(Request $request)
    {
        // Validate the request data (you can adjust the rules as needed)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'sometimes|nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
            ], 422);
        }

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return response()->json([
            'success' => 'Profile updated successfully.'
        ]);
    }
}
