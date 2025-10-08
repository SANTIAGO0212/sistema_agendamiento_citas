<?php

namespace App\Http\Controllers;

use App\Services\EspecialistaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EspecialistaController extends Controller
{
    protected $especialistaService;

    public function __construct(EspecialistaService $service)
    {
        $this->especialistaService = $service;
    }

    /**
     * función para listar especialistas con paginación y filtro
     * @return JsonResponse
     */
    public function listar(Request $request)
    {
        try {
            $buscar = $request->get('buscar');
            $porPagina = $request->get('porPagina', 10);

            $especialistas = $this->especialistaService->listar($buscar, $porPagina);
            
            return response()->json([
                'status' => 'success',
                'especialistas' => $especialistas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nuevo especialista.
     */
    public function guardar()
    {

        try {
            $especialista = $this->especialistaService->crear();
            return response()->json([
                'status' => 'success',
                'message' => 'El especialista fue ingresado correctamente',
                'especialista' => $especialista
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualizar una nuevo especialista.
     */
    public function actualizar(int $id)
    {
        try {
            $especialista = $this->especialistaService->actualizar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El especialista fue actualizado correctamente',
                'especialista' => $especialista
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar un nuevo especialista.
     */
    public function eliminar(int $id)
    {
        try {
            $this->especialistaService->eliminar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El especialista se ha eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Restaurar un nuevo especialista.
     */
    public function restaurar(int $id)
    {
        try {
            $this->especialistaService->restaurar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El especialista fue restaurado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
