<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Http\Requests\StoreMajorRequest;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::all();
        return view('admin.majors.index', compact('majors'));
    }

    public function create()
    {
        // Generate a unique code for the major
        $generatedCode = 'MJR' . str_pad(Major::count() + 1, 3, '0', STR_PAD_LEFT);
        
        // Return the view for creating a new major with the generated code
        return view('admin.majors', compact('generatedCode'));
    }
    

    public function store(StoreMajorRequest $request)
    {
        // Generate a unique code for the major when the form is submitted
        $generatedCode = 'MJR' . str_pad(Major::count() + 1, 3, '0', STR_PAD_LEFT);
    
        // Merge the generated code into the validated request data
        $validated = $request->validated();
        $validated['code'] = $generatedCode;
    
        // Store the new major with the generated code
        Major::create($validated);
    
        return response()->json(['message' => 'Major created successfully']);
    }
    
    
    public function edit(Major $major)
    {
        return response()->json(['major' => $major]);
    }

    public function update(Request $request, Major $major)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $major->update($request->all());

        return response()->json(['success' => 'Major updated successfully']);
    }

    public function destroy(Major $major)
    {
        $major->delete();
        return response()->json(['success' => 'Major deleted successfully']);
    }
}
