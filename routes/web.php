<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\v1\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('get-tokens', function() {
    $credentials = [
        'email' => 'admin@admin.com',
        'password' => 'password'
    ];

        $user = new User();
        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->save();

        // $user = User::first();

    if ($user) {
        $siteAdminToken = $user->createToken('site-admin-token', ['create', 'update', 'delete']);
        $chefToken = $user->createToken('chef-token', ['create', 'update']);
        $basicToken = $user->createToken('basic-token', ['none']);

        return [
            'admin' => $siteAdminToken->plainTextToken,
            'update' => $chefToken->plainTextToken,
            'basic' => $basicToken->plainTextToken,
        ];
    }

    return response()->json(['error' => 'No user found'], 404);
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
