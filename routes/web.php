<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\v1\AuthController;
use Illuminate\Support\Facades\Auth;
use Faker\Factory;

Route::get('/', function () {
    return view('welcome');
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
