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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'classrooms' => 'nullable|array',
            'classrooms.*' => 'exists:classrooms,id'
        ]);

        $major = Major::updateOrCreate(
            ['id' => $request->id],
            ['name' => $validated['name']]
        );

        if ($request->has('classrooms')) {
            $major->classrooms()->sync($validated['classrooms']);
        }

        return redirect()->route('majors.index')->with('success', 'Major created/updated successfully.');
    }

    public function show($id)
    {
        $major = Major::with('classrooms')->find($id);
        return response()->json(['major' => $major]);
    }

    public function edit($id)
    {
        $major = Major::findOrFail($id);
        $classrooms = Classroom::all();

        return response()->json([
            'major' => $major,
            'classrooms' => $classrooms,
            'majorClassrooms' => $major->classrooms->pluck('id')->toArray()
        ]);
    }

    public function update(Request $request, $id)
    {
        $major = Major::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'classrooms' => 'nullable|array',
            'classrooms.*' => 'exists:classrooms,id'
        ]);

        $major->update(['name' => $validatedData['name']]);

        if (isset($validatedData['classrooms'])) {
            Classroom::whereIn('id', $validatedData['classrooms'])->update(['major_id' => $major->id]);

            Classroom::where('major_id', $major->id)
                      ->whereNotIn('id', $validatedData['classrooms'])
                      ->update(['major_id' => null]);
        } else {
            Classroom::where('major_id', $major->id)->update(['major_id' => null]);
        }

        return redirect()->route('majors.index')->with('success', 'Major updated successfully!');
    }

    public function removeClassroom(Request $request, $id)
    {
        $major = Major::findOrFail($id);
    
        $validatedData = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id']
        ]);
    
        // Detach the classroom from the major
        $major->classrooms()->detach($validatedData['classroom_id']);
    
        return response()->json(['success' => 'Classroom removed successfully.']);
    }
    

    public function destroy(Major $major)
    {
        $major->delete();

        return redirect()->route('majors.index')->with('success', 'Major deleted successfully.');
    }
}
