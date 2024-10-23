<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\ResponsPresensi;
use App\Models\StatusPresensi;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PresensiSiswaController extends Controller
{
    public function index(Request $request)
    {
        $this->handleMissingPresensi();
    
        // Mengambil data presensi dari tabel respons_presensi
        $presensi = ResponsPresensi::with(['status', 'presensi'])
            ->where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        $statuses = StatusPresensi::all();
    
        $today = Carbon::now()->startOfDay();
        $userCheckedInToday = ResponsPresensi::where('id_user', Auth::id())
            ->whereDate('created_at', $today)
            ->exists();
    
        return view('siswa.presensi-siswa.index', compact('presensi', 'statuses', 'userCheckedInToday'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|exists:status_presensi,uuid',
        ]);

        DB::beginTransaction();
        try {
            // Mencari presensi aktif yang tersedia
            $activePresensi = Presensi::where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            if (!$activePresensi) {
                throw new \Exception('Tidak ada sesi presensi yang aktif saat ini.');
            }

            // Cek apakah sudah ada respons untuk presensi ini
            $existingResponse = ResponsPresensi::where('id_user', Auth::id())
                ->where('id_presensi', $activePresensi->uuid)
                ->exists();

            if ($existingResponse) {
                throw new \Exception('Anda sudah melakukan presensi untuk sesi ini.');
            }

            // Buat respons presensi baru
            $responsPresensi = new ResponsPresensi();
            $responsPresensi->uuid = Str::uuid();
            $responsPresensi->id_presensi = $activePresensi->uuid;
            $responsPresensi->id_status_presensi = $request->status;
            $responsPresensi->id_user = Auth::id();
            $responsPresensi->save();

            DB::commit();
            return redirect()->route('siswa.presensi.index')->with('success', 'Presensi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('siswa.presensi.index')->with('error', $e->getMessage());
        }
    }

    private function handleMissingPresensi()
    {
        $user_id = Auth::id();
        $today = now()->timezone(config('app.timezone'))->startOfDay();

        // Ambil tanggal pembuatan akun pengguna
        $user = Auth::user();
        $accountCreationDate = $user->created_at->timezone(config('app.timezone'))->startOfDay();

        // Cari presensi terakhir dari respons_presensi
        $lastPresensi = ResponsPresensi::where('id_user', $user_id)
            ->orderBy('created_at', 'desc')
            ->first();

        $startDate = $lastPresensi 
            ? Carbon::parse($lastPresensi->created_at)->timezone(config('app.timezone'))->addDay()
            : $accountCreationDate;

        $startDate = $startDate->max($accountCreationDate);

        // Ambil semua sesi presensi yang belum direspons
        $missedSessions = Presensi::where('start_date', '>=', $startDate)
            ->where('start_date', '<', $today)
            ->whereNotIn('uuid', function($query) use ($user_id) {
                $query->select('id_presensi')
                    ->from('respons_presensi')
                    ->where('id_user', $user_id);
            })
            ->get();

        foreach ($missedSessions as $session) {
            $status = StatusPresensi::where('name', 'Alpha')->first();
            if ($status) {
                ResponsPresensi::create([
                    'uuid' => Str::uuid(),
                    'id_presensi' => $session->uuid,
                    'id_user' => $user_id,
                    'id_status_presensi' => $status->uuid,
                    'created_at' => $session->start_date,
                    'updated_at' => now()
                ]);
            }
        }

        Log::info("Checked and updated presensi for user {$user_id} from " . $startDate->toDateString());
    }
}