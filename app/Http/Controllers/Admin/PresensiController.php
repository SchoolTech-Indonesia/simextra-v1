<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PresensiController extends Controller
{
    public function index()
    {
        $presensi = Presensi::all(); // This should be correct
        return view('admin.presensi.index', compact('presensi'));
    }

    public function create()
    {
        return view('admin.presensi.create');
    }

    public function store(Request $request)
    {
        $presensi = new Presensi();
        $presensi->uuid = (string) Str::uuid();
        $presensi->name = $request->name;
        $presensi->start_date = $request->start_date;
        $presensi->end_date = $request->end_date;
        $presensi->save();

        return redirect()->route('admin.presensi.index');
    }

    public function edit($uuid)
    {
        $presensi = Presensi::findOrFail($uuid);
        return view('admin.presensi.edit', compact('presensi'));
    }

    public function update(Request $request, $uuid)
    {
        $presensi = Presensi::findOrFail($uuid);
        $presensi->name = $request->name;
        $presensi->start_date = $request->start_date;
        $presensi->end_date = $request->end_date;
        $presensi->save();

        return redirect()->route('admin.presensi.index');
    }

    public function destroy($uuid)
    {
        $presensi = Presensi::findOrFail($uuid);
        $presensi->delete();

        return response()->json(['success' => 'Deleted successfully']);
    }
}
