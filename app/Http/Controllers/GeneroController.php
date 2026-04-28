<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\GeneroService;

class GeneroController extends Controller
{
    protected $generoService;

    public function __construct(GeneroService $service)
    {
        $this->generoService = $service;
    }

    /**
     * función para listar géneros
     * @return JsonResponse
     */
    public function listar()
    {
        try {

            $genero = $this->generoService->listar();
            
            return response()->json([
                'status' => 'success',
                'genero' => $genero
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo genero.
     */
    public function guardar()
    {

        try {
            $genero = $this->generoService->crear();
            return response()->json([
                'status' => 'success',
                'message' => 'El género fue ingresado correctamente',
                'genero' => $genero
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualizar un género.
     */
    public function actualizar(int $id)
    {
        try {
            $genero = $this->generoService->actualizar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El género fue actualizado correctamente',
                'genero' => $genero
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar un género.
     */
    public function eliminar(int $id)
    {
        try {
            $genero = $this->generoService->eliminar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El género se ha eliminado correctamente',
                'genero' => $genero
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Restaurar un género.
     */
    public function restaurar(int $id)
    {
        try {
            $genero = $this->generoService->restaurar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El género fue restaurado correctamente',
                'genero' => $genero
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}