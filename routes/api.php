<?php

use App\Http\Controllers\v1\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
    Route::apiResource('recipes', RecipeController::class);
});
















// Route::group(['prefix' => 'v1'], function() {
// Route::middleware('auth:sanctum')->get('recipes', [RecipeController::class, 'index']);
// Route::middleware('auth:sanctum')->post('recipes', [RecipeController::class, 'store']);
// Route::middleware('auth:sanctum')->put('recipes', [RecipeController::class, 'update']);
// Route::middleware('auth:sanctum')->patch('recipes', [RecipeController::class, 'update']);
// Route::middleware('auth:sanctum')->delete('recipes', [RecipeController::class, 'destroy']);
// });
