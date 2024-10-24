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
use Illuminate\Support\Str;

class ApplicantController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
    
        // Retrieve applicants with their associated user (for name), classrooms, status, and extracurriculars
        $applicants = Applicant::with(['user', 'classroom', 'statusApplicant', 'ekstrakurikuler'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            })
            ->get();
    
        return view('applicant.index', [
            'applicants' => $applicants,
            'extracurriculars' => Extra::all(),
            'statuses' => StatusApplicant::all(),
            'classroom' => Classroom::all(),
        ]);
    }
    
    public function create()
    {
        // Retrieve classrooms, statuses, and extracurriculars for selection
        $classrooms = Classroom::all();
        $statuses = StatusApplicant::all(); // Fetch statuses for the form
        $extracurriculars = Extra::all();
    
        return view('applicant.create', compact('classrooms', 'statuses', 'extracurriculars'));
    }
    public function store(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to apply'
                ], 401);
            }
    
            // Get the currently logged-in user
            $user = Auth::user();
    
            // Check if the user already applied for this extracurricular
            $existingApplication = Applicant::where('user_id', $user->id)
                ->where('id_extrakurikuler', $request->extracurricular_id)
                ->first();
            
            // Get the extracurricular name if the application exists
            $extracurricularName = null;
            if ($existingApplication) {
                $extracurricular = Extra::find($existingApplication->id_extrakurikuler);
                $extracurricularName = $extracurricular ? $extracurricular->name : 'this extracurricular'; // Fallback if not found
                
                return response()->json([
                    'success' => false,
                    'message' => 'You have already applied for ' . $extracurricularName . '.'
                ], 422);
            }
    
            // Create a new applicant with the logged-in user's ID
            $applicant = Applicant::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'id_extrakurikuler' => $request->extracurricular_id,
                'id_status_applicant' => $request->status_applicant_id ?? 1,  // Default to pending
                'applicant_code' => 'APPL-' . strtoupper(Str::random(8)),
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully',
                'data' => $applicant
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit application: ' . $e->getMessage()
            ], 500);
        }
    }
    
public function show($id)
{
    try {
        $applicant = Applicant::with(['user', 'ekstrakurikuler', 'statusApplicant'])
            ->findOrFail($id);

        return response()->json([
            'applicant' => $applicant,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error retrieving applicant data.'
        ], 500);
    }
}
    public function edit(Applicant $applicant)
    {
        // Retrieve classrooms, statuses, and extracurriculars for selection in the edit form
        $classrooms = Classroom::all();
        $statuses = StatusApplicant::all();
        $extracurriculars = Extra::all();
    
        return view('applicant.edit', compact('applicant', 'classrooms', 'statuses', 'extracurriculars'));
    }

    public function update(Request $request, Applicant $applicant)
    {
        try {
            // Validate the input
            $validatedData = $request->validate([
                'id_status_applicant' => 'required|exists:status_applicants,id',
            ]);
    
            // Update the applicant with validated data
            $applicant->update($validatedData);
    
            // Optionally load related models for the view
            $applicant->load(['ekstrakurikuler', 'statusApplicant']);
    
            // Redirect to a view with the updated applicant data and success message
            return redirect()->route('applicant.index')->with([
                'success' => 'Applicant updated successfully.',
                'applicant' => $applicant,
            ]);
        } catch (\Exception $e) {
            // Redirect to a view with an error message
            return redirect()->back()->withErrors([
                'error' => 'Error updating applicant data: ' . $e->getMessage(),
            ]);
        }
    }
    
    

    public function destroy(Applicant $applicant)
    {
        // Delete the applicant
        $applicant->delete();

        return redirect()->route('applicant.index')->with('success', 'Applicant deleted successfully.');
    }
//     public function getUserExtracurriculars()
// {
//     $user = Auth::user();
//     $extracurriculars = $user->extracurriculars; // Assuming a relationship between user and extracurricular
//     return response()->json(['data' => $extracurriculars]);
// }
public function getUserExtracurriculars()
{
    try {
        // Fetch all extracurriculars. You can also filter this based on your logic.
        $extracurriculars = Extra::all(); 

        return response()->json([
            'success' => true,
            'data' => $extracurriculars
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch extracurriculars: ' . $e->getMessage()
        ], 500);
    }
}

}
