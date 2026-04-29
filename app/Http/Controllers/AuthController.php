<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TipoDocumentos;
use App\Models\Genero;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function view() {
        $credenciales = User::all();
        $tipo_documentos= TipoDocumentos::select('id', 'cod_tipo_documento', 'nom_tipo_documento')->where('estado',1)->get();
        $generos= Genero::select('id', 'nom_genero')->where('estado',1)->get();
        return view('auth.auths', compact('credenciales','tipo_documentos', 'generos'));
    }


    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|max:12',
            'estado' => 'boolean',
            'telefono' => 'required|string|max:255',
            'num_identificacion' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'id_tipo_documento' => 'integer|exists:tipo_documentos,id',
            'id_genero' => 'integer|exists:generos,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'num_identificacion' => $request->num_identificacion,
            'direccion' => $request->direccion,
            'id_tipo_documento' => $request->id_tipo_documento,
            'id_genero' => $request->id_genero,
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        Auth::login($user);
        
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

        if($user->estado === 0) {
            return response()->json([
                'message' => 'La cuenta se encuentra inactiva. Comuníquese directamente con el administrador.'
            ],402);
        }

        $token = $user->createToken('api_token')->plainTextToken; //general el token de acceso

        Auth::login($user);

        return response()->json(['user' => $user, 'token' => $token, 'message' => 'credenciales correctas, ¡Bienvenido!'], 200);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Sesión finalizada correctamente'], 200);
    }
}
