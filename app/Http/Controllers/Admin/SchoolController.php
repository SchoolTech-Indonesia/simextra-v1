<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        return view('admin.schools.index', compact('schools'));
    }

    public function show($id)
    {
        $school = School::findOrFail($id);
        return response()->json([
            'school' => $school
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'logo_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $logoPath = $request->file('logo_img')->store('assets/img/logo-sekolah', 'public');

        School::create([
            'logo_img' => $logoPath,
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('schools.index')->with('success', 'School added successfully.');
    }

    public function edit($id)
    {
        $school = School::findOrFail($id);
        return response()->json([
            'school' => $school
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'logo_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $school = School::findOrFail($id);

        if ($request->hasFile('logo_img')) {
            if ($school->logo_img) {
                Storage::disk('public')->delete($school->logo_img);
            }

            $logoPath = $request->file('logo_img')->store('assets/img/logo-sekolah', 'public');
            $school->logo_img = $logoPath;
        }

        $school->name = $request->name;
        $school->address = $request->address;
        $school->save();

        return redirect()->route('schools.index')->with('success', 'School updated successfully.');
    }

    public function destroy($id)
    {
        $school = School::findOrFail($id);
    
        if ($school->logo_img) {
            Storage::disk('public')->delete($school->logo_img);
        }
    
        $school->delete();
    
        return redirect()->route('schools.index')->with('success', 'Sekolah berhasil dihapus.');
    }
}
