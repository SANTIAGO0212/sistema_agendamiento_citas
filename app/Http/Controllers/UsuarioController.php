<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\UsuarioService;
use App\Models\User;

class UsuarioController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuarioService $service)
    {
        $this->usuarioService = $service;
    }

    /**
     * Función para mostrar la vista en la página web.
    */
    public function view() {
        $usuarios = User::where('estado', 1)->get();
        $usuarios_inactivos = User::where('estado', 0)->get();
        return view('modulos.usuario', compact('usuarios', 'usuarios_inactivos'));
    }

    /**
     * función para listar usuario con paginación y filtro
     * @return JsonResponse
    */
    public function listar(Request $request)
    {
        try {
            $buscar = $request->get('buscar');
            $porPagina = $request->get('porPagina', 10);

            $usuarios = $this->usuarioService->listar($buscar, $porPagina);
            
            return response()->json([
                'status' => 'success',
                'usuarios' => $usuarios
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo usuario.
    */
    public function guardar()
    {
        try {
            $usuarios = $this->usuarioService->crear();
            return response()->json([
                'status' => 'success',
                'message' => 'El usuario fue agregado correctamente.',
                'usuarios' => $usuarios,
                'id' => $usuarios->id
            ], status: 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualizar una nueva cita.
    */
    public function actualizar(int $id)
    {
        try {
            $usuarios = $this->usuarioService->actualizar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El usuario fue actualizado correctamente',
                'usuarios' => $usuarios
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar un usuario.
    */
    public function eliminar(int $id)
    {
        try {
            $usuario = $this->usuarioService->eliminar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El usuario se ha eliminado correctamente',
                'id' => $usuario['id'],
                'name' => $usuario['name'],
                'email' => $usuario['email'],
                'estado' => $usuario['estado']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Restaurar un usuario.
    */
    public function restaurar(int $id)
    {
        try {
            $usuario = $this->usuarioService->restaurar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El usuario fue restaurado correctamente',
                'id' => $usuario['id'],
                'name' => $usuario['name'],
                'email' => $usuario['email'],
                'estado' => $usuario['estado']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
