<?php

use Illuminate\Http\Request;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('recipes', RecipeController::class);


// sanctum middleware
Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
});
