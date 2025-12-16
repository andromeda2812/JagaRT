<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalRonda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\AbsensiRonda;

class JadwalController extends Controller
{
    /**
     * ===================================
     *  USER — Melihat jadwal masing-masing
     * ===================================
     */
    public function indexUser()
    {
        $userId = Auth::user()->user_id; 

        // ambil jadwal yang terkait dengan user ini
        $jadwalRonda = JadwalRonda::whereHas('users', function($q) use ($userId) {
                $q->where('jadwal_users.user_id', $userId);   // TABEL PIVOT
            })
            ->with(['absensi' => function($q) use ($userId) {
                $q->where('absensi_ronda.user_id', $userId);  // TABEL ABSENSI
            }])
            ->orderBy('tanggal_ronda')
            ->get();

        /* =======================================
        *  AUTO UPDATE STATUS DATABASE → ALPA
        *  jika:
        *  - status masih "belum"
        *  - waktu sudah melewati 23:59 pada tanggal ronda
        * ======================================= */
        $now = now();

        foreach ($jadwalRonda as $jadwal) {

            $absen = $jadwal->absensi->first();
            if (! $absen) continue;

            if ($absen->status === 'belum') {

                $tanggalRonda = \Carbon\Carbon::parse($jadwal->tanggal_ronda);
                $batasAbsen = $tanggalRonda->copy()->setTime(23, 59, 59);

                if ($now->greaterThan($batasAbsen)) {
                    // UPDATE DATABASE
                    $absen->update([
                        'status' => 'alpa'
                    ]);
                }
            }
        }

        return view('user.jadwal', compact('jadwalRonda'));
    }



    /**
     * ===================================
     *  ADMIN — Halaman kalender & modal
     * ===================================
     */
    public function indexAdmin()
    {
        // HANYA warga (role = "warga") yang boleh dipilih untuk ronda
        $users = User::where('role', 'warga')->orderBy('nama_lengkap')->get();

        // ambil jadwal + relasi users
        $jadwalRonda = JadwalRonda::with('users')->get();

        $events = [];

        foreach ($jadwalRonda as $jadwal) {

            foreach ($jadwal->users as $user) {

                $events[] = [
                    'title' => $user->nama_lengkap,          // tampilkan nama user
                    'start' => $jadwal->tanggal_ronda,       // tanggal ronda
                    'user_id' => $user->user_id,             // untuk hapus user
                    'jadwal_id' => $jadwal->jadwal_id,       // ID jadwalnya
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#2563eb',
                    'textColor' => '#fff'
                ];
            }
        }

        return view('admin.jadwal', compact('users', 'events'));
    }



    /**
     * ===================================
     *  ADMIN — Simpan jadwal ronda
     * ===================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'users' => 'required|array|min:1',
        ]);

        // Buat jadwal baru
        $jadwal = JadwalRonda::create([
            'tanggal_ronda' => $request->tanggal,
            'lokasi'        => $request->lokasi,
            'keterangan'    => $request->keterangan,
            'dibuat_oleh'   => Auth::user()->user_id,  // otomatis pengguna yang login
            'created_at'    => now(),
        ]);

        // Attach user dan buat absensi
        foreach ($request->users as $uid) {

            $jadwal->users()->attach($uid);

            AbsensiRonda::create([
                'user_id' => $uid,
                'jadwal_id' => $jadwal->jadwal_id,
                'status' => 'belum',
            ]);
        }

        return back()->with('success', 'Jadwal ronda berhasil dibuat!');
    }

    /**
     * ===================================
     *  ADMIN — Hapus jadwal 
     * ===================================
     */
    public function destroyJadwal(Request $request)
    {
        $jadwalId = $request->jadwal_id;

        DB::beginTransaction();
        try {
            $jadwal = JadwalRonda::findOrFail($jadwalId);

            // 1. Hapus absensi terkait
            AbsensiRonda::where('jadwal_id', $jadwalId)->delete();

            // 2. Lepas semua user di pivot
            $jadwal->users()->detach();

            // 3. Hapus jadwal
            $jadwal->delete();

            DB::commit();
            return back()->with('success', 'Jadwal ronda berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }
}