<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScreenShareController;

Route::get('/', function () {
    return view('welcome');
});

// Halaman utama aplikasi
Route::get('/host/{code}', [ScreenShareController::class, 'showHostPage'])->name('host');
Route::get('/join/{code}', [ScreenShareController::class, 'showViewerPage'])->name('viewer');

// API endpoints
Route::post('/api/rooms', [ScreenShareController::class, 'createRoom']);
Route::post('/api/rooms/join/{code}', [ScreenShareController::class, 'joinRoom']);
Route::get('/api/rooms/{code}/status', [ScreenShareController::class, 'getRoomStatus']);
Route::post('/api/rooms/{code}/mode', [ScreenShareController::class, 'changeMode']);
Route::post('/api/rooms/{code}/signals', [ScreenShareController::class, 'sendSignal']);
Route::get('/api/rooms/{code}/signals', [ScreenShareController::class, 'getSignals']);
Route::post('/api/rooms/{code}/frame', [ScreenShareController::class, 'uploadFrame']);

