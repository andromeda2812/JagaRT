<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| HOME & PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('home'));
Route::view('/home', 'home')->name('home');


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // LOGIN
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

    // REGISTER
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

    // ===============================
    // FORGOT & RESET PASSWORD
    // ===============================

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');    
});

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| USER ROUTES (AUTH REQUIRED)
|--------------------------------------------------------------------------
*/

Route::prefix('user')->name('user.')->middleware('auth')->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])
         ->name('dashboard.user');

    // Jadwal
    Route::get('/jadwal', [JadwalController::class, 'indexUser'])->name('jadwal');

    // Absensi
    Route::post('/absen', [AbsenController::class, 'store'])->name('absen.store');

    // Laporan (khusus user)
    Route::get('/laporan', [LaporanController::class, 'indexUser'])
        ->name('laporan');

    Route::post('/laporan/store', [LaporanController::class, 'storeUser'])
        ->name('laporan.store');

    // Profil
    Route::get('/profil', [UserController::class, 'show'])->name('profil');
    Route::put('/profil/update', [UserController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [UserController::class, 'updatePassword'])->name('profil.password');

});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |------------------ JADWAL RONDA ------------------
    */
    Route::get('/jadwal', [JadwalController::class, 'indexAdmin'])->name('jadwal');
    Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::delete('/jadwal/hapus', [JadwalController::class, 'destroyJadwal'])
        ->name('jadwal.destroy');


    /*
    |------------------ ABSENSI ------------------
    */
    Route::get('/absensi', [AbsenController::class, 'indexAdmin'])->name('absensi');

    /*
    |------------------ AKUN WARGA ------------------
    */
    Route::get('/akun-warga', [WargaController::class, 'index'])->name('akun-warga');
    Route::post('/akun-warga/{id}/toggle-status', [WargaController::class, 'toggleStatus'])
    ->name('akun-warga.toggle-status');
    Route::get('/akun-warga/{id}/detail', [WargaController::class, 'show'])->name('akun-warga.show');


    /*
    |------------------ LAPORAN KEJADIAN (ADMIN) ------------------
    */
    Route::get('/laporan', [LaporanController::class, 'indexAdmin'])
        ->name('laporan');

    Route::get('/laporan/{id}', [LaporanController::class, 'showAdmin'])
        ->name('laporan.show');

    Route::post('/laporan/{id}/status', [LaporanController::class, 'updateStatus'])
        ->name('laporan.status');

    Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])
        ->name('laporan.delete');
    
    Route::get('/laporan/{id}/print', [LaporanController::class, 'print'])
    ->name('laporan.print');

    Route::get('/laporan/print/filter', [LaporanController::class, 'printFilter'])
    ->name('laporan.printFilter');
});