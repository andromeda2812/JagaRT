<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKejadian;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = LaporanKejadian::with('user')->where('user_id', Auth::id())->latest()->get();
        return view('user.laporan', compact('laporan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_kejadian' => 'required|date',
            'lokasi' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto_bukti')) {
            $validated['foto_bukti'] = $request->file('foto_bukti')->store('bukti_kejadian', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status_laporan'] = 'baru';
        $validated['dibuat_pada'] = now();

        LaporanKejadian::create($validated);

        return redirect()->route('laporan.index')->with('success', 'Laporan kejadian berhasil dikirim.');
    }
}
