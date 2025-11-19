<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalRonda;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
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
}