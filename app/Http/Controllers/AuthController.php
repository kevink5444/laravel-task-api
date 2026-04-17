<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
    
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Register Berhasil',
            'user' => $user
        ]);

    }
    public function login(Request $request) {
       // 1. Validasi
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // 2. Cek login
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Email atau password salah'
        ], 401);
    }

    // 3. Ambil user
    $user = User::where('email', $request->email)->first();

    // 4. Buat token
    $token = $user->createToken('auth_token')->plainTextToken;

    // 5. RETURN RESPONSE (INI YANG ANDA KURANG)
    return response()->json([
        'message' => 'Login berhasil',
        'token' => $token,
        'user' => $user
        ]);
    }
}