<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Method to Login Api
    public function login(LoginRequest $request)
    {
        $credentials = $request->only("email", "password");
        $user = User::where("email", $credentials["email"])->first();
        if ($user) {
            if (Hash::check($credentials["password"], $user->password)) {
                $token = $user->createToken("")->plainTextToken;
                return response()->json(['login' => $user, 'token' => $token], 200);
            } else {
                return response()->json(['error' => 'incorrect password'], 403);
            }
        } else {
            return response()->json(['error' => 'account not found'], 403);
        }
    }

    // Method to Register Account Api
    public function register(RegisterRequest $request)
    {
        // validate use validator in laravel
        $user = $request->only('username', 'password', 'email', 'full_name', 'date_of_birth', 'gender', 'phone_number');

        if ($user) {
            $user['password'] = Hash::make($user['password']);
            $user['date_of_birth'] = DateTime::createFromFormat('Y-m-d', $user['date_of_birth']);
            $user['avatar_url'] = 'avatar/default.jpg';
            $userSaved = User::create($user);

            $token = $userSaved->createToken('api_token')->plainTextToken;
            $user['date_of_birth'] = $user['date_of_birth']->format('d/m/Y');
            // User::destroy($userSaved->id);

            return response()->json(['login' => $user, 'token' => $token], 201);
        } else {
            return response()->json($user, 500);
        }
    }
    public function logout(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->delete();
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['error' => ''], 200);
        }
    }
}
