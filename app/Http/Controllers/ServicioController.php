<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServicioRequest;
use App\Models\Sucursal;

class ServicioController extends Controller
{
    public function ver() {}
    public function guardar(ServicioRequest $request)
    {

        try {
            $data = $request->validated();
            //Crear la cita
            $servicio = $request->create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'El servicio fue registrado correctamente',
                'cita' => $servicio
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
