<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKejadian;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // ============================================
    // USER
    // ============================================
    public function indexUser()
    {
        $laporan = LaporanKejadian::where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('user.laporan', compact('laporan'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'tanggal_kejadian' => 'required|date',
            'lokasi' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto_bukti')) {
            $validated['foto_bukti'] = $request->file('foto_bukti')
                    ->store('bukti_kejadian', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status_laporan'] = 'baru';

        LaporanKejadian::create($validated);

        return redirect()->route('user.laporan')
                ->with('success', 'Laporan kejadian berhasil dikirim.');
    }


    // ============================================
    // ADMIN
    // ============================================
    public function indexAdmin()
    {
        $laporan = LaporanKejadian::with('user')->latest()->get();
        return view('admin.laporan', compact('laporan'));
    }

    public function showAdmin($id)
    {
        $laporan = LaporanKejadian::findOrFail($id);
        return view('admin.laporan-show', compact('laporan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $laporan = LaporanKejadian::findOrFail($id);
        $laporan->status_laporan = $request->status;
        $laporan->save();

        return back()->with('success', 'Status laporan diperbarui.');
    }

    public function print($id)
    {
        $laporan = LaporanKejadian::findOrFail($id);

        $pdf = Pdf::loadView('admin.laporan-print', compact('laporan'))
                ->setPaper('A4', 'portrait');

        return $pdf->stream("Laporan-Kejadian-$id.pdf");
    }

    public function printFilter(Request $request)
    {
        $query = LaporanKejadian::query();

        // Filter tanggal
        if ($request->start) {
            $query->whereDate('tanggal_kejadian', '>=', $request->start);
        }
        if ($request->end) {
            $query->whereDate('tanggal_kejadian', '<=', $request->end);
        }

        // Filter status
        if ($request->status) {
            $query->where('status_laporan', $request->status);
        }

        $laporan = $query->orderBy('tanggal_kejadian', 'desc')->get();

        $pdf = Pdf::loadView('admin.laporan-print-filter', compact('laporan', 'request'))
                ->setPaper('A4', 'portrait');

        return $pdf->stream("Laporan-Kejadian-Filter.pdf");
    }
}