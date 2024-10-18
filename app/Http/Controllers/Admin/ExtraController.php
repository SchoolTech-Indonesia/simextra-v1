<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Models\User;
use Illuminate\Http\Request;

class ExtraController extends Controller
{
    public function index(Request $request){$query = Extra::query();

        // Cek apakah ada parameter pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $extras = $query->get();
        // Ambil pengguna dengan role 'Koordinator' secara manual
    $users = User::whereHas('role', function($query) {
        $query->where('name', 'Koordinator');
    })->get();

        return view('admin.extras.index', compact('extras', 'users')); // Kirim ke tampilan
    }

    public function create()
    {
        $users = User::all(); 
        return view('admin.extras.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:extras,name',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $extra = new Extra();
        $extra->name = $validatedData['name'];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('extras', 'public');
            $extra->logo = $path;
        }

        $extra->save();

        if ($request->has('coordinators')) {
            $extra->coordinators()->attach($request->coordinators);
        }    

        return redirect()->route('admin.extras.index')->with('success', 'Extra berhasil ditambahkan.');
    }

    public function update(Request $request, Extra $extra)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tambahkan validasi untuk logo
        ]);

        $extra->name = $request->name;

        // Periksa apakah ada logo baru yang diunggah
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($extra->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($extra->logo);
            }

            // Simpan logo baru
            $path = $request->file('logo')->store('extras', 'public');
            $extra->logo = $path;
        }

        $extra->save();

        if ($request->has('coordinators')) {
            $extra->coordinators()->sync($request->coordinators);
        } else {
            $extra->coordinators()->sync([]); // Hapus semua jika tidak ada koordinator yang dipilih
        }    

        return redirect()->route('admin.extras.index')->with('success', 'Ekstra berhasil diperbarui.');
    }

    public function destroy(Extra $extra)
    {
        $extra->delete();

        return redirect()->route('admin.extras.index')->with('success', 'Ekstra berhasil dihapus.');
    }
}