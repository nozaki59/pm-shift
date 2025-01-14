<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Route;

// TOPページ
Route::get('/', [MainController::class, 'Index'])->name('Index');

// import
Route::get('/import', function () {
    return view('import');
});
Route::post('/import', [ShiftController::class, 'import'])->name('shifts.import');

// シフトデータの取得
Route::get('/api/shifts', [MainController::class, 'getShifts']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
