<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SucursalRequest;
use App\Models\Sucursal;

class SucursalController extends Controller
{
    public function ver() {}

    public function guardar(SucursalRequest $request)
    {

        try {
            $data = $request->validated();
            //Crear la cita
            $sucursal = $request->create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'La sucursal fue ingresada correctamente',
                'cita' => $sucursal
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
