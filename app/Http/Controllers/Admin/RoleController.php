<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.roles.index', compact('roles', 'permissions'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        // Kirim data permissions ke view 'admin.roles.create'
        // return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
 

     public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'rolespermission' => 'required|array'
        ]);

        // Membuat role baru
        $role = Role::create(['name' => $request->name]);

        // Mendapatkan permission berdasarkan ID
        if ($request->filled('rolespermission')) {
            // Mengambil permission names berdasarkan ID
            $permissions = Permission::whereIn('id', $request->rolespermission)->pluck('name')->toArray();

            // Memastikan permission ditemukan dan memberikan izin ke role
            if (count($permissions) > 0) {
                $role->givePermissionTo($permissions);
            } else {
                return redirect()->route('roles.index')->with('error', 'No valid permissions found.');
            }
        }

        // Redirect dengan pesan sukses
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }
    

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;

        return response()->json([
            'role' => $role,
            'permissions' => $permissions->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name
                ];
            })
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil role berdasarkan ID
        $role = Role::find($id);
        
        // Ambil semua permission
        $permissions = Permission::all();
        
        // Kirim data role dan permission ke view modal edit
        
        return response()->json([
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $role->permissions->pluck('id')->toArray()
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Temukan role berdasarkan ID
        $role = Role::find($id);

        // Validasi input
        $request->validate(['name' => 'required']);

        // Update nama role
        $role->update(['name' => $request->name]);

        // Cek apakah ada permissions yang diberikan dalam request
        if ($request->filled('rolespermission')) {
            // Dapatkan nama permissions berdasarkan ID dari request
            $permissions = Permission::whereIn('id', $request->rolespermission)->pluck('name');

            // Sync permissions berdasarkan nama permissions
            $role->syncPermissions($permissions);
        } else {
            // Jika tidak ada permissions yang diberikan, sinkronisasi dengan array kosong untuk menghapus semua permissions
            $role->syncPermissions([]);
        }

        // Redirect kembali dengan pesan sukses
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Temukan role berdasarkan ID
        $role = Role::findOrFail($id);

        // Hapus role
        $role->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
