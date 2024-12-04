<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('email', 'password');
        $check = User::where('email', $credentials['email'])->first();

        if(!$check) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        try {
            if(!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid email or password'
                ], 401);
            }

            $user = auth()->user();
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'token' => $token,
                'user' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'message' => 'User logged out successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to logout'
            ], 401);
        }
    }
}
