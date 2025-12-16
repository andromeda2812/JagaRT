<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class WargaController extends Controller
{
    /**
     * Menampilkan seluruh akun warga.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'warga');

        // Filter Status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter Nama (search)
        if ($request->search) {
            $query->where('nama_lengkap', 'LIKE', '%'.$request->search.'%');
        }

        $warga = $query->orderBy('nama_lengkap')->get();

        return view('admin.akun-warga', compact('warga'));
    }

    /**
     * Menampilkan detail 1 warga (opsional).
     */
    public function show($id)
    {
        $warga = User::findOrFail($id);
        return view('admin.akun-warga.show', compact('warga'));
    }

    public function toggleStatus($id)
    {
        $warga = User::findOrFail($id);

        // Toggle status
        $warga->status = ($warga->status === 'aktif') ? 'nonaktif' : 'aktif';
        $warga->save();

        return back()->with('success', 'Status akun berhasil diperbarui.');
    }
}
