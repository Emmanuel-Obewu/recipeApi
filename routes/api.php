<?php

use App\Http\Controllers\v1\RecipeController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\v1\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRecipeOwner;
use Illuminate\Support\Facades\Hash;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::group(['prefix' => 'v1'], function() {
    Route::get('recipes', [RecipeController::class, 'index']);
    });

Route::group(['prefix' => 'v1', 'middleware' => ['check_bearer_token', 'auth:sanctum']], function() {
    Route::apiResource('recipes', RecipeController::class)->except(['destroy', 'index']);
    Route::delete('recipes/{recipe}', 'RecipeController@destroy')->middleware('CheckRecipeOwner');
    Route::post('logout', [AuthController::class, 'logout']);
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















// Route::group(['prefix' => 'v1',  'middleware' => 'auth:api'], function () {
// Route::get('recipes', [RecipeController::class, 'index']);
// Route::post('recipes', [RecipeController::class, 'store']);
// Route::put('recipes', [RecipeController::class, 'update']);
// Route::patch('recipes', [RecipeController::class, 'update']);
// Route::delete('recipes', [RecipeController::class, 'destroy'])->middleware('check.recipe.owner');
// });
