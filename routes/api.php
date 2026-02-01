<?php

use App\Domains\Property\Http\Controllers\Api\PropertyController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('properties', [PropertyController::class, 'index']);
});
