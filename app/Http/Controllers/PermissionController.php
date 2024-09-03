<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('user.permission.show', compact('permissions'));
    }

    public function create()
    {
        return view('user.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:permissions,slug',
        ]);

        Permission::create($request->only(['name', 'slug']));
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        return view('user.permission.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:permissions,slug,' . $permission->id,
        ]);

        $permission->update($request->only(['name', 'slug']));
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
{
    $permission->delete();
    return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
}


    public function show(Permission $permission)
    {
        return view('user.permission.show', compact('permission'));
    }
}
