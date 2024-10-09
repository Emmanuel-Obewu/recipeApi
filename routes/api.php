<?php

use App\Http\Controllers\v1\RecipeController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRecipeOwner;
use Illuminate\Support\Facades\Hash;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
    Route::apiResource('recipes', RecipeController::class)->except(['destroy']);
    Route::delete('recipes/{recipe}', 'RecipeController@destroy')->middleware(CheckRecipeOwner::class);
});

Route::get('get-tokens', function() {
    $faker = \Faker\Factory::create();

    $name = $faker->name;
    $email = $faker->email;
    $password = $faker->password('6');

    $user = User::whereEmail($email)->first();

    if ($user) {
        return response()->json([
            'error' => 'User/Chef  already exists'
        ], 400);
    }

    $user = new User();
    $user->name = $name;
    $user->email = $email;
    $user->password = Hash::make($password);
    $user->save();

    $siteAdminToken = $user->createToken('site-admin-token', ['create', 'update', 'delete']);
    $chefToken = $user->createToken('chef-token', ['create', 'update']);
    $basicToken = $user->createToken('basic-token', ['none']);

    return [
        'Username' => $name,
        'admin' => $siteAdminToken->plainTextToken,
        'update' => $chefToken->plainTextToken,
        'basic' => $basicToken->plainTextToken,
    ];
});















// Route::group(['prefix' => 'v1'], function() {
// Route::middleware('auth:sanctum')->get('recipes', [RecipeController::class, 'index']);
// Route::middleware('auth:sanctum')->post('recipes', [RecipeController::class, 'store']);
// Route::middleware('auth:sanctum')->put('recipes', [RecipeController::class, 'update']);
// Route::middleware('auth:sanctum')->patch('recipes', [RecipeController::class, 'update']);
// Route::middleware('auth:sanctum')->delete('recipes', [RecipeController::class, 'destroy'])->middleware('check.recipe.owner');
// });
