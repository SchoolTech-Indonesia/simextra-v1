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

    public function store(StoreMajorRequest $request)
    {
        $validated = $request->validated();
    
        Major::create($validated);
    
        return response()->json(['message' => 'Major created successfully.']);
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
