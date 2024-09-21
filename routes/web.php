<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\TpsController;
use App\Http\Controllers\CalonController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuaraController;

Route::get('/', function () {
    return view('auth.login');
})->name('home');

// Halaman login dan proses login
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');

// Logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
// Group for routes accessible by both admin and superadmin
Route::middleware(['auth', 'role:superadmin,admin'])->prefix('admin')->group(function () {
    Route::resource('dashboard', AdminController::class);
    Route::post('/change-password', [AdminController::class, 'changePassword'])->name('change.password');
    Route::resource('suara', SuaraController::class); // For both admin and superadmin
    Route::get('/kelurahan/{kecamatan_id}', [SuaraController::class, 'getKelurahan']);
    // Route::get('/tps/{kelurahan_id}', [SuaraController::class, 'getTps']);
    Route::put('admin/suara/update-all', [SuaraController::class, 'updateAll'])->name('suara.updateAll');
});
// Group for routes accessible only by superadmin
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/get-kelurahans/{kecamatan_id}', [TpsController::class, 'getKelurahansByKecamatan']);
    Route::resource('kecamatan', KecamatanController::class);
    Route::resource('kelurahan', KelurahanController::class);
    Route::resource('tps', TpsController::class);
    Route::resource('calon', CalonController::class);
    // You can define superadmin-specific routes here if needed
});
