<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::post('/identify', Controllers\Arbiter\IdentificationController::class);

Route::middleware(['auth.arbiter'])->group(function() {
    Route::post('/{uuid}/log', [Controllers\Arbiter\LogController::class, 'log']);
    Route::post('/{uuid}/resources', [Controllers\Arbiter\LogController::class, 'resources']);
    Route::get('/{uuid}/status', Controllers\Arbiter\StateController::class);
});
