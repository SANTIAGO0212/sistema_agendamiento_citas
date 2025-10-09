<?php

namespace App\Services;

use App\Models\Cita;
use App\Http\Requests\CrearCitaRequest;
use App\Http\Requests\UpdateCitaRequest;

class CitaService
{
    /**
     * Create a new class instance.
     */
    protected $CitaRequest, $updateCitaRequest;
    /**
     * Constructor: inyecta el request validado.
     */
    public function __construct()
    {
        $this->CitaRequest = null;
        $this->updateCitaRequest = null;
    }

    /**
     * Listar citas con paginación y filtro.
     *
     * @param string|null $buscar
     * @param int $porPagina
     */

    public function listar(?string $buscar = null, int $porPagina = 10)
    {
        $query = Cita::query();

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
     * Crear nueva cita
     * @return \App\Models\Cita
     */
    public function crear()
    {
        $request = app(CrearCitaRequest::class);
        $data = $request->validated();
        return Cita::create($data);
    }

    /**
     * Actualizar una cita existente
     * 
     * @param int $id
     * @return \App\Models\Cita|null
     */
    public function actualizar(int $id)
    {
        $request = app(UpdateCitaRequest::class);
        $data = $request->validated();

        $cita = Cita::findOrFail($id);
        $cita->update($data);

        return $cita;
    }
    /**
     * Eliminar una cita (SoftDelete).
     *
     * @param int $id
     * @return bool
     */
    public function eliminar(int $id)
    {
        $cita = Cita::findOrFail($id);
        return $cita->delete();
    }

    /**
     * Restaurar una cita eliminada (opcional).
     *
     * @param int $id
     * @return bool
     */
    public function restaurar(int $id)
    {
        $cita = Cita::onlyTrashed()->findOrFail($id);
        return $cita->restore();
    }
}
