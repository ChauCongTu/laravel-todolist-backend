<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/tokens/create', function () {
    $user = User::first();
    // dd($user);
    $token = $user->createToken('token-name')->plainTextToken;

    return ['token' => $token];
});

Route::get('/tokens', function () {
    $user = User::first();
    // dd($user);
    $token = $user->tokens();

    return ['user' => $user, 'token' => $token];
});

Route::get('/sanctum', function () {
    return response()->json([
        'name' => 'Châu Quế Nhơn',
        'email' => 'quenhon2002@gmail.com'
    ], 200);
})->middleware('auth:sanctum');

Route::get('/do-not-permission', function() {
    return response()->json([], 403);
})->name('not_auth');
