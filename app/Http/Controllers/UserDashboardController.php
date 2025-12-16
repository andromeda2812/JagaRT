<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbsensiRonda;
use App\Models\JadwalRonda;
use App\Models\LaporanKejadian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->user_id;

        // ========== SUMMARY ==========
        $jumlahRonda = AbsensiRonda::where('user_id', $userId)
                                    ->where('status', 'hadir')
                                    ->count();

        $jumlahHadir = $jumlahRonda;

        $jumlahLaporan = LaporanKejadian::where('user_id', $userId)->count();
        
        // Growth jumlah ronda dibanding bulan lalu
        $bulanIni = AbsensiRonda::where('user_id', $userId)
                    ->whereMonth('waktu_absen', now()->month)
                    ->whereYear('waktu_absen', now()->year)
                    ->where('status', 'hadir')
                    ->count();

        $bulanLalu = AbsensiRonda::where('user_id', $userId)
                    ->whereMonth('waktu_absen', now()->subMonth()->month)
                    ->whereYear('waktu_absen', now()->subMonth()->year)
                    ->where('status', 'hadir')
                    ->count();

        $growthRonda = $bulanLalu > 0 
                        ? round((($bulanIni - $bulanLalu) / $bulanLalu) * 100, 1)
                        : 0;

        // ========== JADWAL BERIKUTNYA ==========
        $jadwalBerikutnya = JadwalRonda::whereHas('users', function($q) use ($userId) {
                                        $q->where('jadwal_users.user_id', $userId);
                                    })
                                    ->whereDate('tanggal_ronda', '>=', now())
                                    ->orderBy('tanggal_ronda')
                                    ->first()
                                    ->tanggal_ronda ?? '-';

        // ========== CHART ABSENSI PER BULAN ==========
        $absenPerBulan = AbsensiRonda::join('jadwal_ronda', 'jadwal_ronda.jadwal_id', '=', 'absensi_ronda.jadwal_id')
            ->select(
                DB::raw("MONTH(jadwal_ronda.tanggal_ronda) AS bulan"),
                DB::raw("COUNT(*) as total")
            )
            ->where('absensi_ronda.user_id', $userId)
            ->where('absensi_ronda.status', 'hadir')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $dataRonda = array_fill(1, 12, 0);
        foreach ($absenPerBulan as $row) {
            $dataRonda[$row->bulan] = $row->total;
        }

        $labels = [
            1=>"Jan", 2=>"Feb", 3=>"Mar", 4=>"Apr",
            5=>"Mei", 6=>"Jun", 7=>"Jul", 8=>"Agu",
            9=>"Sep", 10=>"Okt", 11=>"Nov", 12=>"Des"
        ];
        
        $jsonLabels = json_encode(array_values($labels));
        $jsonDataRonda = json_encode(array_values($dataRonda));


        // ========== ABSENSI TERAKHIR ==========
        $absensiTerakhir = AbsensiRonda::where('user_id', $userId)
            ->join('jadwal_ronda', 'jadwal_ronda.jadwal_id', '=', 'absensi_ronda.jadwal_id')
            ->select(
                'absensi_ronda.*',
                'jadwal_ronda.tanggal_ronda'
            )
            ->orderBy('jadwal_ronda.tanggal_ronda', 'desc')
            ->limit(5)
            ->get();


        return view('user.dashboard', compact(
            'jumlahRonda',
            'jumlahHadir',
            'jumlahLaporan',
            'jadwalBerikutnya',
            'labels',
            'dataRonda',
            'absensiTerakhir',
            'growthRonda',
            'jsonLabels',
            'jsonDataRonda'
        ));
    }
}