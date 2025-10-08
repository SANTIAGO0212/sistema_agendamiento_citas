<?php

namespace App\Services;

use App\Models\Servicio;
use App\Http\Requests\ServicioRequest;
use App\Http\Requests\UpdateServicioRequest;

class ServicioService
{
    /**
     * Create a new class instance.
     */
    protected $ServicioRequest, $updateServicioRequest;
    /**
     * Constructor: inyecta el request validado.
     */
    public function __construct()
    {
        $this->ServicioRequest = null;
        $this->updateServicioRequest = null;
    }

    /**
     * Listar servicios con paginación y filtro.
     *
     * @param string|null $buscar
     * @param int $porPagina
     */

    public function listar(?string $buscar = null, int $porPagina = 10)
    {
        $query = Servicio::query();

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
     * Crear nuevo servicio
     * @return \App\Models\Servicio
     */
    public function crear()
    {
        $request = app(ServicioRequest::class);
        $data = $request->validated();
        return Servicio::create($data);
    }

    /**
     * Actualizar un servicio existente
     * 
     * @param int $id
     * @return \App\Models\Servicio|null
     */
    public function actualizar(int $id)
    {
        $request = app(UpdateServicioRequest::class);
        $data = $request->validated();

        $servicio = Servicio::findOrFail($id);
        $servicio->update($data);

        return $servicio;
    }
    /**
     * Eliminar un servicio (SoftDelete).
     *
     * @param int $id
     * @return bool
     */
    public function eliminar(int $id)
    {
        $servicio = Servicio::findOrFail($id);
        return $servicio->delete();
    }

    /**
     * Restaurar un servicio eliminada (opcional).
     *
     * @param int $id
     * @return bool
     */
    public function restaurar(int $id)
    {
        $servicio = Servicio::onlyTrashed()->findOrFail($id);
        return $servicio->restore();
    }
}
