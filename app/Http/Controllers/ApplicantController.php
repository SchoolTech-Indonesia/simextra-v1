<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;
use App\Models\Classroom;
use App\Models\StatusApplicant;
use App\Models\Extra;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve applicants with their associated classrooms, status, and extracurriculars
        $applicants = Applicant::with(['classroom', 'statusApplicant', 'extracurricular'])->get();
        $extracurriculars = Extra::all();
        $statuses = StatusApplicant::all(); // Fetch all statuses
        $search = $request->input('search');

        $applicants = Applicant::with(['user', 'extracurricular', 'statusApplicant'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            })
            ->get();
            return view('applicants.index', [
                'applicants' => $applicants,
                'extracurriculars' => Extra::all(),  // Assuming this is your extracurricular model
                'statuses' => StatusApplicant::all(), // Assuming this is your status model
            ]);
    }

    public function create()
    {
        // Retrieve classrooms, statuses, and extracurriculars for selection
        $classrooms = Classroom::all();
        $statuses = StatusApplicant::all(); // Fetch statuses for the form
        $extracurriculars = Extra::all();
    
        return view('applicants.create', compact('classrooms', 'statuses', 'extracurriculars'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'id_status_applicant' => 'required|exists:status_applicants,id',
            'id_extrakurikuler' => 'required|exists:extrakurikulers,id',
        ]);

        // Create a new applicant with the given data
        Applicant::create($validatedData);

        return redirect()->route('applicants.index')->with('success', 'Applicant created successfully.');
    }

    public function edit(Applicant $applicant)
    {
        // Retrieve classrooms, statuses, and extracurriculars for selection in the edit form
        $classrooms = Classroom::all();
        $statuses = StatusApplicant::all();
        $extracurriculars = Extra::all();
    
        return view('applicants.edit', compact('applicant', 'classrooms', 'statuses', 'extracurriculars'));
    }

    public function update(Request $request, Applicant $applicant)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'id_status_applicant' => 'required|exists:status_applicants,id',
            'id_extrakurikuler' => 'required|exists:extrakurikulers,id',
        ]);

        // Update the applicant with the validated data
        $applicant->update($validatedData);

        return redirect()->route('applicants.index')->with('success', 'Applicant updated successfully.');
    }

    public function destroy(Applicant $applicant)
    {
        // Delete the applicant
        $applicant->delete();

        return redirect()->route('applicants.index')->with('success', 'Applicant deleted successfully.');
    }
    public function getUserExtracurriculars()
{
    $user = Auth::user();
    $extracurriculars = $user->extracurriculars; // Assuming a relationship between user and extracurricular
    return response()->json(['data' => $extracurriculars]);
}

}
