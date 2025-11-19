<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbsensiRonda;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'absensi_id' => 'required|exists:absensi_ronda,absensi_id',
            'status' => 'required|in:hadir,izin,alpa',
            'bukti_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $absensi = AbsensiRonda::findOrFail($validated['absensi_id']);

        if ($absensi->user_id !== Auth::id()) {
            return back()->withErrors('Kamu tidak bisa absen untuk jadwal orang lain!');
        }

        $fotoPath = null;
        if ($request->hasFile('bukti_foto')) {
            $fotoPath = $request->file('bukti_foto')->store('bukti_ronda', 'public');
        }

        $absensi->update([
            'status' => $validated['status'],
            'waktu_absen' => now(),
            'bukti_foto' => $fotoPath ?? $absensi->bukti_foto,
        ]);

        return back()->with('success', 'Absensi berhasil disimpan.');
    }
}