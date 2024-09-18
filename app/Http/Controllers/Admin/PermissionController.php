<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('query');

        if ($searchTerm) {
            $permissions = Permission::where('name', 'LIKE', '%' . $searchTerm . '%')->get();
        } else {
            $permissions = Permission::all();
        }
    
        if ($request->ajax()) {
            return response()->json([
                'permissions' => $permissions
            ]);
        }
    
        $permissions = Permission::paginate(10);

        $permissions = Permission::paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ], [
            'name.unique' => 'Nama Untuk Permission ini Sudah Ada!.',
        ]);
    
    
        Permission::create($request->only('name', 'slug'));
    
        return redirect()->route('permissions.index')->with('success', 'Permission Berhasil Ditambahkan!');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find the permission by ID
        $permission = Permission::findOrFail($id);

        // Return the edit view with the permission data
        return response()->json([
            'permission' => $permission
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
    
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ], [
            'name.unique' => 'Nama Untuk Permission ini Sudah Ada!.',
        ]);
    
        $permission->update($request->only('name', 'slug'));
    
        return redirect()->route('permissions.index')->with('success', 'Permission Berhasil Diubah.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission Berhasil Dihapus!');
    }
}
