<?php
namespace App\Http\Controllers\Admin;

use App\Models\Major;
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
    
    public function store(Request $request)
    {
        // Validate the major and classrooms (array of IDs)
        $validated = $request->validate([
            'name' => 'required|string|max:255',  // Add validation for the major name
            'classrooms' => 'nullable|array',     // Classrooms can be nullable, must be an array
            'classrooms.*' => 'exists:classrooms,id'  // Ensure each classroom ID exists in the classrooms table
        ]);
    
        // Create or update the major
        $major = Major::updateOrCreate(
            ['id' => $request->id],   // If the ID is provided, update; otherwise, create a new major
            ['name' => $validated['name']]
        );
    
        // Sync the classrooms (if provided)
        if ($request->has('classrooms')) {
            $major->classrooms()->sync($validated['classrooms']);
        }
    
        // Redirect with success message
        return redirect()->route('majors.index')->with('success', 'Major created/updated successfully.');
    }
    
    //before associated major
    // public function show(Major $major)
    // {
    //     $major->load('classrooms'); // Eager load classrooms
    //     return response()->json([
    //         'major' => $major,
    //         'classrooms' => $major->classrooms // This will include classroom data
    //     ]);
    // }
    //after associated majorpublic function show($id)
    public function show($id)
    {
        $major = Major::with('classrooms')->find($id);
        return response()->json(['major' => $major]);

    }
    
    

    // public function edit($id)
    // {   
    //     $major = Major::find($id);
    //     $classrooms = Classroom::all();
    //     return response()->json([
    //         'major' => $major->load('classrooms'),
    //         'classrooms' => $classrooms
    //     ]);
    // }

    //sudah bisa tapi belum populated
    // public function edit($id)
    // {
    //     $major = Major::with('classrooms')->findOrFail($id); // Fetch the major with classrooms
    //     $allClassrooms = Classroom::all(); // Fetch all classrooms
    
    //     return response()->json([
    //         'major' => $major,
    //         'allClassrooms' => $allClassrooms // Pass all classrooms for selection
    //     ]);
    // }
    public function edit($id)
{
    // Fetch the major and its associated classrooms
    $major = Major::findOrFail($id);

    // Fetch all classrooms (available classrooms for selection)
    $classrooms = Classroom::all();

    // Send data back to the frontend for populating the modal form
    return response()->json([
        'major' => $major,
        'classrooms' => $classrooms, // All classrooms
        'majorClassrooms' => $major->classrooms->pluck('id')->toArray() // Classrooms associated with the major
    ]);
}
    //many to many 1
    // public function update(Request $request, $id)
    // {
    //     // Find the major by ID
    //     $major = Major::findOrFail($id);
    
    //     // Validate the incoming request data
    //     $validatedData = $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'classroom_ids' => ['nullable', 'array'], // Allow 'classroom_ids' to be nullable
    //         'classroom_ids.*' => ['exists:classrooms,id'] // Ensure each ID exists in the classrooms table
    //     ]);
    
    //     // Update the major name
    //     $major->update(['name' => $validatedData['name']]);
    
    //     // Sync classrooms if classroom_ids are present, otherwise detach all
    //     if (isset($validatedData['classroom_ids'])) {
    //         $major->classrooms()->sync($validatedData['classroom_ids']);
    //     } else {
    //         $major->classrooms()->detach(); // This will detach all classrooms if no IDs are provided
    //     }
    
    //     // Redirect back to the index page with a success message
    //     return redirect()->route('majors.index')->with('success', 'Major Berhasil Diubah!');
    // }
    public function update(Request $request, $id)
{
    $major = Major::findOrFail($id);
    
    // Update major name
    $major->update($request->only('name'));
    
    // Update the relationships in the pivot table
    if ($request->has('classrooms')) {
        $major->classrooms()->sync($request->input('classrooms'));
    }
    
    return response()->json(['message' => 'Major updated successfully']);
}

    public function removeClassroom(Request $request, $id)
{
    // Find the major by ID
    $major = Major::findOrFail($id);

    // Validate the incoming request data
    $validatedData = $request->validate([
        'classroom_id' => ['required', 'exists:classrooms,id'] // Validate the classroom ID
    ]);

    // Detach the specified classroom from the major
    $major->classrooms()->detach($validatedData['classroom_id']);

    // Return a success response
    return response()->json(['success' => 'Classroom removed successfully.']);
}

    public function destroy(Major $major)
    {
        $major->delete();

        return redirect()->route('majors.index')->with('success', 'Major deleted successfully.');
    }

}


//     public function edit($id)
// {
//     try {
//         $major = Major::with('classrooms')->findOrFail($id);
//         $classrooms = Classroom::all();

//         return response()->json([
//             'major' => $major,
//             'classrooms' => $classrooms,
//         ]);
//     } catch (\Exception $e) {
//         return response()->json(['error' => 'Error retrieving major data.'], 500);
//     }
// }
    
//     public function update(Request $request, Major $major)
//     {
//         try {
//             $validated = $request->validate([
//                 'name' => 'required|string|max:255',
//                 'classrooms' => 'array|exists:classrooms,id',
//             ]);
    
//             $major->update($validated);
    
//             if ($request->has('classrooms')) {
//                 $major->classrooms()->sync($request->classrooms);
//             }
    
//             return redirect()->route('majors.index')->with('success', 'Major updated successfully.');
//         } catch (\Exception $e) {
//             return redirect()->route('majors.index')->with('error', 'Error updating major data.');
//         }
//     }
    
//     public function show($id)
//     {
//         try {
//             $major = Major::with('classrooms')->findOrFail($id);
    
//             return response()->json([
//                 'major' => $major,
//             ]);
//         } catch (\Exception $e) {
//             return response()->json(['error' => 'Error retrieving major data.'], 500);
//         }
//     }

