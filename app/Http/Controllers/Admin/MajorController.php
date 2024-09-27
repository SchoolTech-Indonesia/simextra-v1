<?php
namespace App\Http\Controllers\Admin;



use App\Models\Major;
use App\Models\User; 
use App\Models\Classroom; 
use App\Http\Requests\StoreMajorRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class MajorController extends Controller
{
    public function index(Request $request)
    {
        $majors = Major::with(['classrooms'])
            ->where('name', 'like', '%' . $request->search . '%')
            ->paginate(10);
    
        $classrooms = Classroom::all();
    
        return view('admin.majors.index', compact('majors', 'classrooms'));
    }
    
    public function store(StoreMajorRequest $request)
    {
        // Validate and create the major
        $validated = $request->validated(); // This uses the StoreMajorRequest for validation
    
        $major = Major::create($validated); // Create the new major
    
        // If classrooms are provided, associate them with the major
        if ($request->has('classrooms')) {
            $major->classrooms()->sync($request->classrooms);
        }
    
        // Redirect to the index page with a success message
        return redirect()->route('majors.index')->with('success', 'Major created successfully.');
    }

    public function edit($id)
{
    try {
        $major = Major::with('classrooms')->findOrFail($id);
        $classrooms = Classroom::all();

        return response()->json([
            'major' => $major,
            'classrooms' => $classrooms,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error retrieving major data.'], 500);
    }
}
    
    public function update(Request $request, Major $major)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'classrooms' => 'array|exists:classrooms,id',
            ]);
    
            $major->update($validated);
    
            if ($request->has('classrooms')) {
                $major->classrooms()->sync($request->classrooms);
            }
    
            return redirect()->route('majors.index')->with('success', 'Major updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('majors.index')->with('error', 'Error updating major data.');
        }
    }
    
    public function show($id)
    {
        try {
            $major = Major::with('classrooms')->findOrFail($id);
    
            return response()->json([
                'major' => $major,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving major data.'], 500);
        }
    }

    public function destroy(Major $major)
    {
        $major->delete();

        return redirect()->route('majors.index')->with('success', 'Major deleted successfully.');
    }
}
