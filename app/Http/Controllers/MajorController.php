<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Http\Requests\StoreMajorRequest;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index(Request $request)
    {
    // // Retrieve majors with pagination and include the 'koordinator' relationship
    // $majors = Major::with(['classrooms', 'koordinator'])
    //                ->where('name', 'like', '%' . $request->search . '%')
    //                ->paginate(10); // Adjust the number of items per page as needed
    $majors = Major::paginate(10);
    return view('admin.majors.index', compact('majors'));
    }
    public function store(StoreMajorRequest $request)
    {
        // Generate a unique code for the major when the form is submitted
        $generatedCode = 'JRS' . str_pad(Major::count() + 1, 3, '0', STR_PAD_LEFT);
    
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
