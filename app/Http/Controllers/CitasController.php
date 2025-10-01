<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CrearCitaRequest;
use App\Models\Cita;

class CitasController extends Controller
{
    public function ver() {}

    public function guardar(CrearCitaRequest $request)
    {

        try {
            $data = $request->validated();
            //Crear la cita
            $cita = $request->create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'La cita fue ingresada correctamente',
                'cita' => $cita
            ],201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function actualizar() {}

    public function eliminar() {}
}
