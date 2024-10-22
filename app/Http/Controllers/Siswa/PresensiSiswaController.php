<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\ResponsPresensi;
use App\Models\StatusPresensi; // Import the StatusPresensi model
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PresensiSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = ResponsPresensi::query();

        $presensi = $query->get(); // Ambil data sesuai pencarian

        // Fetch status options
        $statuses = StatusPresensi::all(); // Get all status options

        return view('siswa.presensi-siswa.index', compact('presensi', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|exists:status_presensi,uuid', // Validate that the status exists
        ]);

        $responsPresensi = new ResponsPresensi();
        $responsPresensi->id_status_presensi = $request->status; // Assuming you have this field
        $responsPresensi->id_user = auth()->id(); // Assuming you want to associate it with the logged-in user
        $responsPresensi->save();

        return redirect()->route('siswa.presensi.index')->with('success', 'Presensi created successfully.');
    }

    public function update(Request $request, $uuid)
    {

        return redirect()->route('siswa.presensi-siswa.index')->with('success', 'Presensi updated successfully.');
    }

    public function destroy($uuid)
    {
        return redirect()->back()->with('success', 'Presensi berhasil dihapus');
    }


}
