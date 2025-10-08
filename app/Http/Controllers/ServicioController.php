<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ServicioService;
use Illuminate\Http\JsonResponse;

class ServicioController extends Controller
{
    protected $servicioService;

    public function __construct(ServicioService $service)
    {
        $this->servicioService = $service;
    }

    /**
     * función para listar servicios con paginación y filtro
     * @return JsonResponse
     */
    public function listar(Request $request)
    {
        try {
            $buscar = $request->get('buscar');
            $porPagina = $request->get('porPagina', 10);

            $servicios = $this->servicioService->listar($buscar, $porPagina);
            
            return response()->json([
                'status' => 'success',
                'servicios' => $servicios
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nuevo servicio.
     */
    public function guardar()
    {

        try {
            $servicio = $this->servicioService->crear();
            return response()->json([
                'status' => 'success',
                'message' => 'El servicio fue ingresada correctamente',
                'servicio' => $servicio
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualizar una nuevo servicio.
     */
    public function actualizar(int $id)
    {
        try {
            $servicio = $this->servicioService->actualizar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El servicio fue actualizada correctamente',
                'servicio' => $servicio
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar un nuevo servicio.
     */
    public function eliminar(int $id)
    {
        try {
            $this->servicioService->eliminar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El servicio se ha eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Restaurar un nuevo servicio.
     */
    public function restaurar(int $id)
    {
        try {
            $this->servicioService->restaurar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El servicio fue restaurada correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
