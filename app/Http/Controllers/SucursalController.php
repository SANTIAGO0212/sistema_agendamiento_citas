<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SucursalService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SucursalRequest;

class SucursalController extends Controller
{
    protected $sucursalService;

    public function __construct(SucursalService $service)
    {
        $this->sucursalService = $service;
    }

    /**
     * función para listar sucursales con paginación y filtro
     * @return JsonResponse
     */
    public function listar(Request $request)
    {
        try {
            $buscar = $request->get('buscar');
            $porPagina = $request->get('porPagina', 10);

            $sucursales = $this->sucursalService->listar($buscar, $porPagina);
            
            return response()->json([
                'status' => 'success',
                'sucursales' => $sucursales
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nueva sucursal.
     */
    public function guardar()
    {

        try {
            $sucursal = $this->sucursalService->crear();
            return response()->json([
                'status' => 'success',
                'message' => 'La sucursal fue ingresada correctamente',
                'sucursal' => $sucursal
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualizar una nueva sucursal.
     */
    public function actualizar(int $id)
    {
        try {
            $sucursal = $this->sucursalService->actualizar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'La sucursal fue actualizada correctamente',
                'sucursal' => $sucursal
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar una nueva sucursal.
     */
    public function eliminar(int $id)
    {
        try {
            $this->sucursalService->eliminar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'La sucursal se ha eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Restaurar una nueva sucursal.
     */
    public function restaurar(int $id)
    {
        try {
            $this->sucursalService->restaurar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'La sucursal fue restaurada correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
