<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalRonda;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * ============================
     *  USER
     * ============================
     */
    public function indexUser()
    {
        $userId = Auth::id();

        // Ambil jadwal berdasarkan absensi user
        $jadwalRonda = JadwalRonda::with(['absensi' => function($query) use ($userId) {
            $query->where('user_id', $userId);
        }])
        ->orderBy('tanggal_ronda', 'asc')
        ->get();

        return view('user.jadwal', compact('jadwalRonda'));
    }


    /**
     * ============================
     *  ADMIN
     * ============================
     */
    public function indexAdmin()
    {
        $jadwal = JadwalRonda::orderBy('tanggal_ronda', 'asc')->get();

        return view('admin.jadwal', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_ronda' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        JadwalRonda::create([
            'tanggal_ronda' => $request->tanggal_ronda,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'dibuat_oleh' => Auth::id(),
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Jadwal ronda berhasil ditambahkan!');
    }
}
