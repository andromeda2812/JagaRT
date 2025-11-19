<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class WargaController extends Controller
{
    /**
     * Menampilkan seluruh akun warga.
     */
    public function index()
    {
        // Ambil semua user dengan role 'warga' / 'user'
        $warga = User::where('role', 'warga')->get();

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

    /**
     * Form edit warga (opsional).
     */
    public function edit($id)
    {
        $warga = User::findOrFail($id);
        return view('admin.akun-warga.edit', compact('warga'));
    }

    /**
     * Update data warga.
     */
    public function update(Request $request, $id)
    {
        $warga = User::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username'     => 'required|string|max:50',
            'no_hp'        => 'nullable|string|max:20',
            'alamat'       => 'nullable|string|max:255',
        ]);

        $warga->update($validated);

        return redirect()->route('admin.akun-warga')
                        ->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Hapus akun warga.
     */
    public function destroy($id)
    {
        $warga = User::findOrFail($id);
        $warga->delete();

        return redirect()->route('admin.akun-warga')
                        ->with('success', 'Akun warga berhasil dihapus.');
    }
}
