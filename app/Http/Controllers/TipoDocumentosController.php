<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TipoDocumentosService;
use Illuminate\Http\JsonResponse;

class TipoDocumentosController extends Controller
{
    protected $tipoDocumentoService;

    public function __construct(TipoDocumentosService $service)
    {
        $this->tipoDocumentoService = $service;
    }

    /**
     * función para listar tipo de documentos
     * @return JsonResponse
     */
    public function listar()
    {
        try {

            $tipo_documentos = $this->tipoDocumentoService->listar();
            
            return response()->json([
                'status' => 'success',
                'tipo_documentos' => $tipo_documentos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nuevo tipo de documento.
     */
    public function guardar()
    {

        try {
            $tipo_documentos = $this->tipoDocumentoService->crear();
            return response()->json([
                'status' => 'success',
                'message' => 'El tipo de documento fue ingresado correctamente',
                'tipo_documentos' => $tipo_documentos
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualizar un tipo de documento.
     */
    public function actualizar(int $id)
    {
        try {
            $tipo_documentos = $this->tipoDocumentoService->actualizar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El tipo de documento fue actualizado correctamente',
                'tipo_documentos' => $tipo_documentos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar un nuevo tipo de documento.
     */
    public function eliminar(int $id)
    {
        try {
            $tipo_documentos = $this->tipoDocumentoService->eliminar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El tipo de documento se ha eliminado correctamente',
                'tipos_documentos' => $tipo_documentos
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
            $tipo_documentos = $this->tipoDocumentoService->restaurar($id);
            return response()->json([
                'status' => 'success',
                'message' => 'El tipo de documento fue restaurado correctamente',
                'tipo_documentos' => $tipo_documentos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}