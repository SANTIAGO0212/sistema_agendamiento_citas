<?php

namespace App\Services;

use App\Models\Especialista;
use App\Http\Requests\EspecialistaRequest;
use App\Http\Requests\UpdateEspecialistaRequest;

class EspecialistaService
{
    /**
     * Create a new class instance.
     */
    protected $EspecialistaRequest, $updateEspecialistaRequest;
    /**
     * Constructor: inyecta el request validado.
     */
    public function __construct()
    {
        $this->EspecialistaRequest = null;
        $this->updateEspecialistaRequest = null;
    }

    /**
     * Listar especialistar con paginación y filtro.
     *
     * @param string|null $buscar
     * @param int $porPagina
     */

    public function listar(?string $buscar = null, int $porPagina = 10)
    {
        $query = Especialista::query();

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
     * Crear nuevo especialista
     * @return \App\Models\Especialista
     */
    public function crear()
    {
        $request = app(EspecialistaRequest::class);
        $data = $request->validated();
        return Especialista::create($data);
    }

    /**
     * Actualizar un especialista existente
     * 
     * @param int $id
     * @return \App\Models\Especialista|null
     */
    public function actualizar(int $id)
    {
        $request = app(UpdateEspecialistaRequest::class);
        $data = $request->validated();

        $especialista = Especialista::findOrFail($id);
        $especialista->update($data);

        return $especialista;
    }
    /**
     * Eliminar un especialista (SoftDelete).
     *
     * @param int $id
     * @return bool
     */
    public function eliminar(int $id)
    {
        $especialista = Especialista::findOrFail($id);
        return $especialista->delete();
    }

    /**
     * Restaurar un especialista eliminada (opcional).
     *
     * @param int $id
     * @return bool
     */
    public function restaurar(int $id)
    {
        $especialista = Especialista::onlyTrashed()->findOrFail($id);
        return $especialista->restore();
    }
}
