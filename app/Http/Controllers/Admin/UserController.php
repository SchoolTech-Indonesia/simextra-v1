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

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all(); 
        $schools = School::all(); 
 
        return view('admin.users.index', compact('users', 'roles', 'schools'));
    }

    public function show($id)
    {
        $user = User::with('role', 'schools')->findOrFail($id);
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
            'id_school' => 'required|array',
        ], [
            'email.unique' => 'Email untuk User ini Sudah Ada!.',
            'phone_number.unique' => 'Nomor Telepon untuk User ini Sudah Ada!.',
            'NISN_NIP.unique' => 'NISN/NIP untuk User ini Sudah Ada!.'
        ]);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'NISN_NIP' => $validated['NISN_NIP'],
            'password' => bcrypt($validated['password']),
            'id_role' => $validated['id_role'],
            'id_school' => $validated['id_school'],
        ]);

        $user->schools()->sync($validated['id_school'] ?? []);
        
        return redirect()->route('users.index')->with('success', 'User Berhasil Ditambahkan.');
    }
      
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $schools = School::all();
    
        return response()->json([
            'user' => $user,
            'roles' => $roles,
            'schools' => $schools,
            'userSchoolIds' =>$user->schools->pluck('id')->toArray()
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
            'id_school' => 'required|array', 
            'id_school.*' => 'exists:schools,id',
            'status' => 'sometimes|boolean',
        ]);
        
        $user->update($validated);

         $user->schools()->sync($validated['id_school']);
        
        return redirect()->route('users.index')->with('success', 'User Berhasil Diubah!');
    }
    

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User Berhasil Dihapus!');
    }
}
