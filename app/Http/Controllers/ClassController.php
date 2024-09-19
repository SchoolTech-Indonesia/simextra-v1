<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Major;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');
    $major_id = $request->input('major_id'); // Get major filter

    // Query classrooms based on search and major filter
    $classroom = Classroom::when($search, function ($query, $search) {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('code', 'like', "%{$search}%");
    })->when($major_id, function ($query, $major_id) {
        return $query->where('major_id', $major_id);
    })->get();

    $majors = Major::all();

    return view('admin.classroom.index', compact('classroom', 'majors', 'search', 'major_id'));
}

    public function show($id)
    {
        // Mengambil data classroom beserta major dan daftar student
        //!! Silahkan pakai ini, Jika sudah ada mahasiswanya untuk menampilkan detail students
        // $classroom = Classroom::with(['major', 'students'])->findOrFail($id);
        // Jika belum pakai ini saja..
        $classroom = Classroom::with(['major'])->findOrFail($id);

        return response()->json($classroom);
    }
    public function create()
    {
      
        $generatedCode = 'CLSRM' . str_pad(Classroom::count() + 1, 3, '0', STR_PAD_LEFT);
        
 
        return view('admin.classroom', compact('generatedCode'));
    }
    

    public function store(Request $request)
{
    // Validasi data
    $validated = $request->validate([
        'name' => 'required|unique:classrooms,name',
        'major_id' => 'required|exists:majors,id'
    ]);

    // Generate kode kelas
    $generatedCode = 'CLSRM' . str_pad(Classroom::count() + 1, 3, '0', STR_PAD_LEFT);

    // Simpan data classroom
    $classroom = Classroom::create([
        'name' => $validated['name'],
        'code' => $generatedCode,
        'major_id' => $validated['major_id'] // Major diambil dari input tunggal
    ]);

    return response()->json(['message' => 'Classroom created successfully']);
}


    
    
public function edit(Classroom $classroom)
{
    $majors = Major::all(); // Mengambil semua data major untuk dropdown
    return response()->json([
        'classroom' => $classroom,
        'majors' => $majors, // Kirim data major ke view
        'selected_major_id' => $classroom->major_id // Kirim data major_id yang dipilih sebelumnya
    ]);
}


    public function update(Request $request, Classroom $classroom)
    {
    $request->validate([
        'code' => 'required|string|max:10|unique:classrooms,code,' . $classroom->id, // Validasi unik untuk code classroom
        'name' => 'required|string|max:255|unique:classrooms,name,' . $classroom->id, // Validasi unik untuk name
        'major_id' => 'required|exists:majors,id' // Validasi major
    ]);

    // Update data classroom
    $classroom->update([
        'code' => $request->code,
        'name' => $request->name,
        'major_id' => $request->major_id,
    ]);

    return response()->json(['success' => 'Classroom updated successfully']);
    }   
    

    public function destroy(Classroom $classroom)
    {
        if ($classroom->delete()) {
            return response()->json(['success' => 'Classroom deleted successfully']);
        } else {
            return response()->json(['error' => 'Failed to delete classroom'], 500);
        }
    }

}
