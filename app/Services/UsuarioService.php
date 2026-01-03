<?php

namespace App\Services;

use App\Models\User;
use App\Http\Requests\UsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;

class UsuarioService
{
    protected $UsuarioRequest, $updateUsuarioRequest;
    /**
     * Constructor: inyecta el request validado.
     */
    public function __construct()
    {
        $this->UsuarioRequest = null;
        $this->updateUsuarioRequest = null;
    }

    /**
     * Listar sucursales con paginación y filtro.
     *
     * @param string|null $buscar
     * @param int $porPagina
     */

    public function listar(?string $buscar = null, int $porPagina = 10)
    {
        $query = User::query();

        // Si hay filtro, aplica búsqueda
        if (!empty($buscar)) {
            $query->where('name', 'LIKE', "%{$buscar}%")
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
     * @return \App\Models\User
     */
    public function crear()
    {
        $request = app(UsuarioRequest::class);
        $data = $request->validated();
        return User::create($data);
    }

    /**
     * Actualizar una sucursal existente
     * 
     * @param int $id
     * @return \App\Models\User|null
     */
    public function actualizar(int $id)
    {
        $request = app(UpdateUsuarioRequest::class);
        $data = $request->validated();

        $user = User::findOrFail($id);
        $user->update($data);

        return $user;
    }
    /**
     * Eliminar una sucursal (SoftDelete).
     *
     * @param int $id
     * @return bool
     */
    public function eliminar(int $id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }

    /**
     * Restaurar una sucursal eliminada (opcional).
     *
     * @param int $id
     * @return bool
     */
    public function restaurar(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        return $user->restore();
    }
}