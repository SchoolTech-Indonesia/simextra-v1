<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Mpdf\Mpdf;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search'); // Ganti 'query' dengan 'search'
        $roleId = $request->input('role');
        
        $users = User::when($roleId, function($query, $roleId) {
            return $query->whereHas('role', function($query) use ($roleId) {
                $query->where('id', $roleId);
            });
        })->when($query, function($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })->with('role') // Eager load role untuk menghindari N+1 query
        ->paginate(10);
        
        $roles = Role::all(); 
        $schools = School::all(); 
        
        if ($request->ajax()) {
            return response()->json(['users' => $users]);
        }
        
        return view('admin.users.index', compact('users', 'roles', 'schools'));
    }
    
    
    
    
    public function show($id)
    {
        $user = User::with('role', 'school')->findOrFail($id);
        $roles = Role::all(); 
        $schools = School::all(); 
        
        return response()->json([
            'user' => $user,
            'roles' => $roles,
            'schools' => $schools
        ]);
    }


    public function create()
    {
        $roles = Role::all();
        $schools = School::all();
    
        $roleId = request('role');
    
        if ($roleId) {
            $roles = $roles->where('id', $roleId);
        }
    
        return view('admin.users.create', compact('roles', 'schools'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:255|unique:users',
            'NISN_NIP' => 'required|numeric|unique:users',
            'password' => 'required|string|confirmed',
            'id_role' => 'required|exists:roles,id',
            'id_school' => 'required|exists:schools,id',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow optional profile photo upload
        ], [
            'email.unique' => 'Email untuk User ini Sudah Ada!.',
            'phone_number.unique' => 'Nomor Telepon untuk User ini Sudah Ada!.',
            'NISN_NIP.unique' => 'NISN/NIP untuk User ini Sudah Ada!.',
            'profile_photo.image' => 'Profile photo must be an image.',
            'profile_photo.mimes' => 'Profile photo must be a jpeg, png, jpg, or gif.',
            'profile_photo.max' => 'Profile photo must be less than 2MB.',
        ]);
    
        // Initialize the profile photo path
        $profilePhotoPath = 'https://freesvg.org/img/abstract-user-flat-4.png'; // Default photo URL
    
        // If a profile photo is uploaded, store it and update the path
        if ($request->hasFile('profile_photo')) {
            $imageName = time() . '.' . $request->profile_photo->extension();
            $request->profile_photo->move(public_path('assets/img/fotoprofil'), $imageName);
            $profilePhotoPath = asset('assets/img/fotoprofil/' . $imageName); // Use the stored file path
        }
    
        // Create the user with the validated data
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'NISN_NIP' => $validated['NISN_NIP'],
            'password' => bcrypt($validated['password']),
            'id_role' => $validated['id_role'],
            'id_school' => $validated['id_school'],
            'profile_photo_path' => $profilePhotoPath, // Use the stored file path or default URL
        ]);
    
        return redirect()->route('users.index')->with('success', 'User Berhasil Ditambahkan.');
    }
    

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $schools = School::all();
        $roleId = request('role');
    
        if ($roleId) {
            // Filter roles yang sesuai dengan pilihan navbar
            $roles = $roles->where('id', $roleId);
        }

        return response()->json([
            'user' => $user,
            'roles' => $roles,
            'schools' => $schools, 
        ]);
    }
   

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'phone_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'NISN_NIP' => [
                'required',
                'numeric',
                Rule::unique('users')->ignore($id),
            ],
            'id_role' => 'required|exists:roles,id',
            'id_school' => 'required|exists:schools,id', 
            'status' => 'sometimes|boolean',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('users.index')->with('success', 'User Berhasil Diubah!');
    } 

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User Berhasil Dihapus!');
    }

    public function showImportForm()
    {
        return view('users.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        return redirect()->back()->with('success', 'Users Berhasil Diimport!');
    }

    public function downloadPDF()
    {
        // Ambil semua data pengguna dari database
        $users = User::all();
        
        // Render view ke HTML
        $html = view('admin.users.download-pdf', compact('users'))->render();
        
        // Inisialisasi objek mPDF
        $mpdf = new Mpdf();
        
        // Tuliskan HTML ke PDF
        $mpdf->WriteHTML($html);
        
        // Output PDF untuk diunduh
    
        $mpdf->Output('users.pdf', 'D'); 

        return redirect()->back()->with('success', 'Data User Berhasil Diunduh');
    }

}
