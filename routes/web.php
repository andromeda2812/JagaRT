<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\LaporanController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

// FORM login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// PROSES login (POST)
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// DASHBOARD (protected)
Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', function () { return view('user.dashboard'); })->name('user.dashboard');
    Route::get('/jadwal-ronda', [JadwalController::class, 'index'])->name('user.jadwal');
    Route::post('/absen', [AbsenController::class, 'store'])->name('absen.store');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('user.laporan');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/profil', [UserController::class, 'show'])->name('user.profil');
    Route::put('/profil/update', [UserController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [UserController::class, 'updatePassword'])->name('profil.password');
});

Route::get('/admin/beranda', function () { return view('admin.beranda'); })->name('admin.beranda');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::get('/user/jadwal', [JadwalController::class, 'indexUser'])->name('jadwal.user');

Route::get('/admin/jadwal', [JadwalController::class, 'indexAdmin'])->name('jadwal.admin');
Route::post('/admin/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');

Route::get('/admin/absensi', [AbsenController::class, 'indexAdmin'])->name('admin.absensi');

Route::get('/admin/akun-warga', [WargaController::class, 'index'])->name('admin.akun-warga');
Route::get('/admin/akun-warga/{id}/edit', [WargaController::class, 'edit'])->name('admin.akun-warga.edit');
Route::put('/admin/akun-warga/{id}', [WargaController::class, 'update'])->name('admin.akun-warga.update');
Route::delete('/admin/akun-warga/{id}', [WargaController::class, 'destroy'])->name('admin.akun-warga.delete');

Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
Route::get('/admin/laporan/{id}', [LaporanController::class, 'show'])->name('admin.laporan.show');
Route::delete('/admin/laporan/{id}', [LaporanController::class, 'destroy'])->name('admin.laporan.delete');

