<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\CitaService;

class CitasController extends Controller
{
    protected $citaService;

    public function __construct(CitaService $service)
    {
        $this->citaService = $service;
    }

    /**
     * función para listar citas con paginación y filtro
     * @return JsonResponse
     */
    public function listar(Request $request)
    {
        try {
            $buscar = $request->get('buscar');
            $porPagina = $request->get('porPagina', 10);

            $citas = $this->citaService->listar($buscar, $porPagina);
            
            return response()->json([
                'status' => 'success',
                'citas' => $citas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nueva cita.
     */
    public function guardar()
    {

        try {
            $cita = $this->citaService->crear();
            return response()->json([
                'status' => 'success',
                'message' => 'La cita fue ingresada correctamente',
                'cita' => $cita
            ], 201);
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
            $cita = $this->citaService->actualizar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'La cita fue actualizada correctamente',
                'cita' => $cita
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar una nueva cita.
     */
    public function eliminar(int $id)
    {
        try {
            $this->citaService->eliminar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'La cita se ha eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Restaurar una nueva cita.
     */
    public function restaurar(int $id)
    {
        try {
            $this->citaService->restaurar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'La cita fue restaurada correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
