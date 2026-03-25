<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Akun kasir berhasil dibuat'
        ], 201);
    }

    // 2. Login & Dapatkan Token
    public function login(Request $request)
    {
        // Tangkap data yang sudah divalidasi ke dalam variabel
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cari user pakai data yang sudah aman
        $user = User::where('email', $validated['email'])->first();

        // Cek kecocokan email dan password
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Email atau Password salah!'], 401);
        }

        // Buat Kunci Token
        $token = $user->createToken('kasir_token')->plainTextToken;

        return response()->json([
            'message' => 'Login sukses!',
            'token' => $token
        ], 200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout berhasil!'
        ], 200);
    }
}
