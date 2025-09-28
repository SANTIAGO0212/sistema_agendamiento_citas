<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:12'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api_token')->plainTextToken;
        
        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Te has registrado correctamente'
        ],201);
    }

    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        } // Se validan las credeniales ingresadas y al ser inválidas marca error status 401 en la respuesta del JSON

        $token = $user->createToken('api_token')->plainTextToken; //general el token de acceso

        return response()->json(['user' => $user, 'token' => $token, 'message' => 'credenciales correctas, ¡Bienvenido!'], 200);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Has finalizado sesión'], 200);
    }
}
