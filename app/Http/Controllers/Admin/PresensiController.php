<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PresensiController extends Controller
{
    public function index(Request $request)
{
    $query = Presensi::query();

    // Cek apakah ada input pencarian
    if ($request->has('search')) {
        $search = $request->get('search');
        $query->where('name', 'like', "%{$search}%"); // Filter berdasarkan nama
    }

    $presensi = $query->get(); // Ambil data sesuai pencarian
    return view('admin.presensi.index', compact('presensi'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $presensi = new Presensi();
        $presensi->uuid = (string) Str::uuid();
        $presensi->name = $request->name;
        $presensi->start_date = $request->start_date;
        $presensi->end_date = $request->end_date;
        $presensi->save();

        return redirect()->route('admin.presensi.index')->with('success', 'Presensi created successfully.');
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $presensi = Presensi::findOrFail($uuid);
        $presensi->name = $request->name;
        $presensi->start_date = $request->start_date;
        $presensi->end_date = $request->end_date;
        $presensi->save();

        return redirect()->route('admin.presensi.index')->with('success', 'Presensi updated successfully.');
    }

    public function destroy($uuid)
    {
        $presensi = Presensi::findOrFail($uuid);
        $presensi->delete();

        return redirect()->back()->with('success', 'Presensi berhasil dihapus');
    }
}
