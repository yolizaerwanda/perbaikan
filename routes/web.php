<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\users\PengaduanController;
use App\Http\Controllers\users\TanggapanPengaduanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// // Route::get('/dashboard/user', function () {
// //     return view('user.index');
// // })->middleware(['auth', 'verified'])->name('user.index');

// Route::get('/dashboard/admin', function () {
//     return view('admin.index');
// })->middleware(['auth', 'verified','cekLevel'])->name('admin.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('/pengaduan', PengaduanController::class);
    Route::get('/tanggapan', [TanggapanPengaduanController::class, 'index'])->name('tanggapan.index');
});

require __DIR__.'/auth.php';
