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
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user = Auth::user();
    
        $imageName = time().'.'.$request->profile_photo->extension();
        $request->profile_photo->move(public_path('storage/profile_photos'), $imageName);
    
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
    
        $user->profile_photo_path = 'storage/profile_photos/'.$imageName;
        $user->save();
    
        // Redirect to the profile page
        return redirect('/user/profile')->with('success', 'Foto Profil Berhasil ditambahkan');
    }
    

    public function updateProfile(Request $request)
    {
       
            $request->validate([
                'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        
            $user = Auth::user();
        
            $imageName = time().'.'.$request->profile_photo->extension();
            $request->profile_photo->move(public_path('storage/profile_photos'), $imageName);
        
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
        
            $user->profile_photo_path = 'storage/profile_photos/'.$imageName;
            $user->save();
        
            return response()->json([
                'success' => 'Foto Profil Berhasil ditambahkan',
                'photo_url' => asset('storage/profile_photos/'.$imageName),
                
            ]);
        }
}
