<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user = Auth::user();
    
        $imageName = time().'.'.$request->profile_photo->extension();
        $request->profile_photo->move(public_path('storage/profile_photos'), $imageName);
    
        // Delete the old photo if it exists
        if ($user->profile_photo_path && !filter_var($user->profile_photo_path, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
    
        // Update the user's profile photo path
        $user->profile_photo_path = 'storage/profile_photos/'.$imageName;
        $user->save();
    
        return redirect('/user/profile')->with('success', 'Foto Profil Berhasil ditambahkan');
    }

    public function deletePhoto(Request $request)
    {
        $user = Auth::user();
    
        if ($user->profile_photo_path && !filter_var($user->profile_photo_path, FILTER_VALIDATE_URL)) {
            // Delete the current photo from storage if it's not a URL
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        
        // Set a default profile photo using an external URL
        $defaultPhotoUrl = 'https://freesvg.org/img/abstract-user-flat-4.png';
        
        // Update the user's profile photo to the default photo URL
        $user->profile_photo_path = $defaultPhotoUrl;
        $user->save();
    
        return response()->json(['success' => 'Profile photo deleted and default photo set.']);
    }
}
