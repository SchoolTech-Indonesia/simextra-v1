<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\User; // Import the User model
use App\Models\Classroom; // Import the Classroom model
use App\Http\Requests\StoreMajorRequest;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index(Request $request)
    {
        $majors = Major::with(['classrooms', 'koordinator'])
                       ->where('name', 'like', '%' . $request->search . '%')
                       ->paginate(10);
    
        $koordinators = User::whereHas('role', function ($query) {
            $query->where('name', 'koordinator');
        })->get();
    
        $classrooms = Classroom::all(); // Retrieve all Classrooms
    
        return view('admin.majors.index', compact('majors', 'koordinators', 'classrooms'));
    }
    
    public function create()
    {
        $koordinators = User::whereHas('role', function ($query) {
            $query->where('name', 'koordinator');
        })->get();
        $classrooms = Classroom::all(); // Retrieve all Classrooms
    
        return view('admin.majors.create', compact('koordinators', 'classrooms'));
    }
    
    

    public function store(StoreMajorRequest $request)
    {
        // Generate a major code
        $generatedCode = 'JRS' . str_pad(Major::count() + 1, 3, '0', STR_PAD_LEFT);
    
        // Validate request data
        $validated = $request->validated();
    
        // Assign generated code
        $validated['code'] = $generatedCode;
    
        // Allow null for `koordinator_id` and `classroom_id` if not provided
        $validated['koordinator_id'] = $request->koordinator_id ?: null;
        $validated['classroom_id'] = $request->classroom_id ?: null;
    
        // Create the major
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
