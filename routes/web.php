<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityLogController;

Route::get('/', function () {
    return view('welcome');
});

// Export Riwayat Aktivitas
Route::get('/activity-logs/export', [ActivityLogController::class, 'export'])
    ->name('activity-logs.export');

// Halaman Riwayat Aktivitas
Route::get('/activity-logs', [ActivityLogController::class, 'index'])
    ->name('activity-logs.index');