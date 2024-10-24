<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the school years.
     */
    public function index(Request $request)
    {
        $query = SchoolYear::with('school');
        // Get all schools for the dropdown
        $schools = School::all();

        // Get all school years for display in the table
        $schoolYears = SchoolYear::with('school')->get();
    
        if ($request->has('search')) {
            $query->whereHas('school', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('search') . '%');
            });
        }
    
        $schoolYears = $query->get();
    
        return view('admin.school-year.index', compact('schools','schoolYears'));
    }

    /**
     * Show the form for creating a new school year.
     */
    public function create()
    {
        $schools = School::all(); 
        return view('school-year.create', compact('schools'));
    }

    /**
     * Store a newly created school year in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_year_code' => 'required|unique:school_years|max:255',
            'school_id' => 'required|exists:schools,id', // Ensure the school_id is valid
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required'
        ]);
    
        SchoolYear::create([
            'school_year_code' => $request->school_year_code,
            'school_id' => $request->school_id, // Save the selected school_id
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status
        ]);
    
        return redirect()->route('school-year.index')->with('success', 'School Year successfully created.');
    }
    

    /**
     * Show the form for editing the specified school year.
     */
    public function edit($id)
    {
        $schoolYear = SchoolYear::findOrFail($id); 
        return view('school-year.edit', compact('schoolYear')); 
    }

    /**
     * Update the specified school year in the database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'school_year_code' => 'required|max:255|unique:school_years,school_year_code,' . $id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required'
        ]);

        $schoolYear = SchoolYear::findOrFail($id);
        $schoolYear->update([
            'school_year_code' => $request->school_year_code,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status
        ]);

        return redirect()->route('school-year.index')->with('success', 'School Year successfully updated.');
    }

    /**
     * Remove the specified school year from the database.
     */
    public function destroy($id)
    {
        $schoolYear = SchoolYear::findOrFail($id);
        $schoolYear->delete();

        return redirect()->route('school-year.index')->with('success', 'School Year successfully deleted.');
    }

    /**
     * Display the specified school year details.
     */
    public function show($id)
    {
        $schoolYear = SchoolYear::findOrFail($id); 
        return response()->json(['schoolYear' => $schoolYear]); 
    }
}
