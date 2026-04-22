<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Fungsi Register User Baru
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User berhasil dibuat', 'user' => $user], 201);
    }

    // Fungsi Login untuk dapat Token
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Email atau Password salah (Unauthorized)'], 401);
        }

        return response()->json([
            'status' => 'Success',
            'message' => 'Login berhasil',
            'token' => $token
        ]);
    }
}
