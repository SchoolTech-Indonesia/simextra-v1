<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        // Retrieve all permission from the database
        $permissions = Permission::all();

        // Pass the permissions data to the view
        return view('user.permission.show', compact('permissions'));
        // dd($permissions);
    }

    public function create()
    {
        return view('user.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Permission::create($request->all());
        return redirect()->route('permission.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        return view('user.permission.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required']);
        $permission->update($request->all());
        return redirect()->route('permission.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permission.index')->with('success', 'Permission deleted successfully.');
    }

    public function show(Permission $permission)
    {
        return view('user.permission.show', compact('permission'));
    }
}
