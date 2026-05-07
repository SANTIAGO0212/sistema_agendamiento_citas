<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\UsuarioService;
use App\Models\User;
use App\Models\Genero;
use App\Models\TipoDocumentos;

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
        $tipo_documentos= TipoDocumentos::select('id', 'cod_tipo_documento', 'nom_tipo_documento')->where('estado',1)->get();
        $generos= Genero::select('id', 'nom_genero')->where('estado',1)->get();
        return view('modulos.usuario', compact('usuarios', 'usuarios_inactivos', 'tipo_documentos', 'generos'));
    }

    /**
     * función para listar usuarios activos con paginación y filtro
     * @return JsonResponse
    */
    public function listar_activo(Request $request)
    {
        try {
            $buscar = $request->get('buscar');
            $porPagina = $request->get('porPagina', 5);

            $usuarios = $this->usuarioService->listar_activo($buscar, $porPagina);
            
            return response()->json([
                'status' => 'success',
                'usuarios' => $usuarios
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se encontraron los resultados'
            ], 500);
        }
    }

        /**
     * función para listar usuarios inactivos con paginación y filtro
     * @return JsonResponse
    */
    public function listar_inactivo(Request $request)
    {
        try {
            $buscar = $request->get('buscar');
            $porPagina = $request->get('porPagina', 5);

            $usuarios = $this->usuarioService->listar_inactivo($buscar, $porPagina);
            
            return response()->json([
                'status' => 'success',
                'usuarios' => $usuarios
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se encontraron los resultados'
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
            $usuarios->load('genero', 'tipoDocumento');
            return response()->json([
                'status' => 'success',
                'message' => 'El usuario fue agregado correctamente.',
                'usuarios' => $usuarios,
                'id' => $usuarios->id,
                'num_identificacion' => $usuarios->num_identificacion,
                'telefono' => $usuarios->telefono,
                'direccion' => $usuarios->direccion,
                'id_genero' => $usuarios->id_genero,
                'id_tipo_documento' => $usuarios->id_tipo_documento,
                'estado' => $usuarios->estado,
                'nom_genero' => $usuarios->genero->nom_genero,
                'cod_tipo_documento' => $usuarios->tipoDocumento->cod_tipo_documento,
                'nom_tipo_documento' => $usuarios->tipoDocumento->nom_tipo_documento
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
            $usuarios->load('genero', 'tipoDocumento');
            return response()->json([
                'status' => 'success',
                'message' => 'El usuario fue actualizado correctamente',
                'usuarios' => $usuarios,
                'num_identificacion' => $usuarios->num_identificacion,
                'telefono' => $usuarios->telefono,
                'direccion' => $usuarios->direccion,
                'id_genero' => $usuarios->id_genero,
                'id_tipo_documento' => $usuarios->id_tipo_documento,
                'estado' => $usuarios->estado,
                'nom_genero' => $usuarios->genero->nom_genero,
                'cod_tipo_documento' => $usuarios->tipoDocumento->cod_tipo_documento,
                'nom_tipo_documento' => $usuarios->tipoDocumento->nom_tipo_documento
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
