<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
    // Default photo URL
    private $defaultPhotoUrl = 'https://freesvg.org/img/abstract-user-flat-4.png';

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user = Auth::user();
        $imageName = time().'.'.$request->profile_photo->extension();

        // Store the new profile photo in public storage
        $request->profile_photo->move(public_path('storage/profile_photos'), $imageName);

        // Delete the old photo if it exists and is not the default
        if ($user->profile_photo_path && $user->profile_photo_path !== $this->defaultPhotoUrl) {
            Storage::disk('public')->delete(str_replace('storage/', '', $user->profile_photo_path));
        }

        // Update the user's profile photo path
        $user->profile_photo_path = 'storage/profile_photos/' . $imageName;
        $user->save();
    
        return redirect('/user/profile')->with('success', 'Foto Profil Berhasil ditambahkan');
    }

    public function deletePhoto(Request $request)
    {
        $user = Auth::user();
    
        if ($user->profile_photo_path && $user->profile_photo_path !== $this->defaultPhotoUrl) {
            // Delete the current photo from storage if it's not the default
            
            Storage::disk('public')->delete(str_replace('storage/', '', $user->profile_photo_path));
        }
        
        // Set the profile photo to the default URL
        $user->profile_photo_path = $this->defaultPhotoUrl;
        $user->save();
    
        return response()->json(['success' => 'Profile photo deleted and default photo set.']);
    }

    // Assign the default profile photo upon user registration or first login
    public static function assignDefaultPhoto(User $user)
    {
        if (empty($user->profile_photo_path)) {
            $user->profile_photo_path = 'https://freesvg.org/img/abstract-user-flat-4.png';
            $user->save();
        }
    }
    public function edit()
{
    $user = Auth::user();
    return view('profile.edit', compact('user'));
}

public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,'.Auth::id(),
    ]);

    $user = Auth::user();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully!');
}


public function updatePassword(Request $request)
{
    $request->validate([
        'new_password' => 'required|min:8|confirmed',
    ]);

    $user = auth()->user();

    // Check if the new password is the same as the current password
    if (Hash::check($request->new_password, $user->password)) {
        return redirect()->back()->withErrors(['new_password' => 'New password cannot be the same as the current password.']);
    }

    // Update the user's password
    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->back()->with('success', 'Password updated successfully.');
}
}
