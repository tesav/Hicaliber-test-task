<?php

use App\Http\Controllers\Api\PropertyController;

Route::prefix('v1')->group(function () {
    Route::get('properties', [PropertyController::class, 'index']);
});


