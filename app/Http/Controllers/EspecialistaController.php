<?php

namespace App\Http\Controllers;

use App\Http\Requests\EspecialistaRequest;
use Illuminate\Http\Request;
use App\Models\Especialista;

class EspecialistaController extends Controller
{
    public function ver() {}

    public function guardar(EspecialistaRequest $request)
    {

        try {
            $data = $request->validated();
            //Crear la cita
            $especialista = $request->create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'El especialista ha sido registrado correctamente',
                'especialista' => $especialista
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
