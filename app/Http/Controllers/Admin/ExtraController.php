<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Models\User;
use Illuminate\Http\Request;

class ExtraController extends Controller
{
    public function index()
    {
        $extras = Extra::all();
        $users = User::all(); // Ambil semua pengguna
        return view('admin.extras.index', compact('extras', 'users')); // Kirim ke tampilan
    }

    public function create()
    {
        $users = User::all(); 
        return view('admin.extras.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:extras,name',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $extra = new Extra();
        $extra->name = $validatedData['name'];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('extras', 'public');
            $extra->logo = $path;
        }

        $extra->save();

        return redirect()->route('admin.extras.index')->with('success', 'Extra berhasil ditambahkan.');
    }

    public function update(Request $request, Extra $extra)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schedule' => 'required|string',
        ]);

        $extra->name = $request->name;
        $extra->description = $request->description;
        $extra->schedule = $request->schedule;
        $extra->save();

        return redirect()->route('admin.extras.index')->with('success', 'Ekstra berhasil diperbarui.');
    }

    public function destroy(Extra $extra)
    {
        $extra->delete();

        return redirect()->route('admin.extras.index')->with('success', 'Ekstra berhasil dihapus.');
    }
}