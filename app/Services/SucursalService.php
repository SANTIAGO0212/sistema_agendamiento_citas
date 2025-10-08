<?php

namespace App\Services;

use App\Models\Sucursal;
use App\Http\Requests\SucursalRequest;
use App\Http\Requests\UpdateSucursalRequest;

class SucursalService
{
    protected $SucursalRequest, $updateSucursalRequest;
    /**
     * Constructor: inyecta el request validado.
     */
    public function __construct()
    {
        $this->SucursalRequest = null;
        $this->updateSucursalRequest = null;
    }

    /**
     * Listar sucursales con paginación y filtro.
     *
     * @param string|null $buscar
     * @param int $porPagina
     */

    public function listar(?string $buscar = null, int $porPagina = 10)
    {
        $query = Sucursal::query();

        // Si hay filtro, aplica búsqueda
        if (!empty($buscar)) {
            $query->where('nombre', 'LIKE', "%{$buscar}%")
                ->orWhere('direccion', 'LIKE', "%{$buscar}%");
        }

        // Si el parámetro de paginación es verdadero
        if ($porPagina) {
            return $query->paginate($porPagina);
        }

        // Si no se requiere paginación
        return $query->get();
    }

    /**
     * Crear nueva sucursal
     * @return \App\Models\Sucursal
     */
    public function crear()
    {
        $request = app(SucursalRequest::class);
        $data = $request->validated();
        return Sucursal::create($data);
    }

    /**
     * Actualizar una sucursal existente
     * 
     * @param int $id
     * @return \App\Models\Sucursal|null
     */
    public function actualizar(int $id)
    {
        $request = app(UpdateSucursalRequest::class);
        $data = $request->validated();

        $sucursal = Sucursal::findOrFail($id);
        $sucursal->update($data);

        return $sucursal;
    }
    /**
     * Eliminar una sucursal (SoftDelete).
     *
     * @param int $id
     * @return bool
     */
    public function eliminar(int $id)
    {
        $sucursal = Sucursal::findOrFail($id);
        return $sucursal->delete();
    }

    /**
     * Restaurar una sucursal eliminada (opcional).
     *
     * @param int $id
     * @return bool
     */
    public function restaurar(int $id)
    {
        $sucursal = Sucursal::onlyTrashed()->findOrFail($id);
        return $sucursal->restore();
    }
}
