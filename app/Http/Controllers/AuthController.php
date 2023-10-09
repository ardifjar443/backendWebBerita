<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['message' => 'Login berhasil'], 200);
        } else {
            return response()->json(['message' => 'Login gagal'], 401);
        }
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return response()->json(['message' => 'Registrasi berhasil'], 201);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Logout berhasil'], 200);
    }
}