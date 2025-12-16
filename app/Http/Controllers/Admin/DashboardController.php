<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JadwalRonda;
use App\Models\AbsensiRonda;
use App\Models\LaporanKejadian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /* ============================================================
           1. SUMMARY CARD – QUICK STATISTICS
        ============================================================ */

        // Total warga
        $totalWarga = User::where('role', 'warga')->count();

        // Jadwal bulan ini
        $bulanIni = Carbon::now()->month;
        $totalJadwalBulan = JadwalRonda::whereMonth('tanggal_ronda', $bulanIni)->count();

        // Laporan baru
        $laporanBaru = LaporanKejadian::where('status_laporan', 'baru')->count();

        // Total hadir
        $totalHadirBulan = AbsensiRonda::where('status', 'hadir')
            ->whereMonth('waktu_absen', $bulanIni)
            ->count();

        // Total absen yang seharusnya hadir
        $totalAbsenBulan = AbsensiRonda::whereMonth('waktu_absen', $bulanIni)->count();

        $persentaseHadir = ($totalAbsenBulan > 0)
            ? round(($totalHadirBulan / $totalAbsenBulan) * 100, 1)
            : 0;

        // List bulan Jan–Dec (sekali, dipakai ulang)
        $bulanList = collect(range(1, 12))
            ->map(fn ($b) => Carbon::create()->month($b)->format('M'));


        /* ============================================================
        2. GRAFIK RONDA – Ambil langsung dari tabel jadwal_ronda
        ============================================================ */
        $tahunIni = Carbon::now()->year;

        $rondaPerBulan = JadwalRonda::selectRaw(
                'MONTH(tanggal_ronda) as bulan, COUNT(*) as total'
            )
            ->whereYear('tanggal_ronda', $tahunIni)
            ->groupByRaw('MONTH(tanggal_ronda)')
            ->pluck('total', 'bulan');

        $labelsRonda = $bulanList->values()->all();

        $dataRonda = collect(range(1, 12))
            ->map(fn ($b) => $rondaPerBulan[$b] ?? 0)
            ->values()
            ->all();



        /* ============================================================
           3. GRAFIK KEHADIRAN BULANAN
        ============================================================ */
        $kehadiran = AbsensiRonda::selectRaw(
                "MONTH(waktu_absen) as bulan, COUNT(*) as total"
            )
            ->whereNotNull('waktu_absen')
            ->where('status', 'hadir')
            ->whereYear('waktu_absen', $tahunIni)
            ->groupByRaw('MONTH(waktu_absen)')
            ->pluck('total', 'bulan');


        $labelsKehadiran = $bulanList->values()->all();

        $dataKehadiran = collect(range(1, 12))
            ->map(fn ($b) => $kehadiran[$b] ?? 0)
            ->values()
            ->all();



        /* ============================================================
           4. ABSENSI TERBARU – ambil 5 data
        ============================================================ */
        $absensiTerakhir = AbsensiRonda::with('user')
            ->orderBy('waktu_absen', 'desc')
            ->take(5)
            ->get();


        return view('admin.dashboard', compact(
            'totalWarga',
            'totalJadwalBulan',
            'laporanBaru',
            'persentaseHadir',
            'labelsRonda',
            'dataRonda',
            'labelsKehadiran',
            'dataKehadiran',
            'absensiTerakhir'
        ));
    }
}