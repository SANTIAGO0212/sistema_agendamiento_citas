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

    public function listar_activo(?string $buscar = null, int $porPagina = 10)
    {
        $query = User::where('estado', 1);

        // Si hay filtro, aplica búsqueda
        if (!empty($buscar)) {
            $query->where('name', 'LIKE', "%{$buscar}%");
        }

        // Si el parámetro de paginación es verdadero
        if ($porPagina) {
            return $query->paginate($porPagina);
        }

        // Si no se requiere paginación
        return $query->get();
    }

    public function listar_inactivo(?string $buscar = null, int $porPagina = 10)
    {
        $query = User::where('estado', 0);

        // Si hay filtro, aplica búsqueda
        if (!empty($buscar)) {
            $query->where('name', 'LIKE', "%{$buscar}%");
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
        $user->load('genero', 'tipoDocumento');

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'estado' => $user->estado,
            'num_identificacion' => $user->num_identificacion,
            'telefono' => $user->telefono,
            'nom_genero' => $user->genero->nom_genero,
            'nom_tipo_documento' => $user->tipoDocumento->nom_tipo_documento,
            'cod_tipo_documento' => $user->tipoDocumento->cod_tipo_documento,
            'direccion' => $user->direccion
        ];

        $user->estado = 0;
        $user->save();
        //$user->delete();

        return $data;
    }

    /**
     * Restaurar una sucursal eliminada (opcional).
     *
     * @param int $id
     * @return bool
     */
    public function restaurar(int $id)
    {
        $user = User::findOrFail($id);
        $user->load('genero', 'tipoDocumento');
        
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'estado' => $user->estado,
            'num_identificacion' => $user->num_identificacion,
            'telefono' => $user->telefono,
            'nom_genero' => $user->genero->nom_genero,
            'nom_tipo_documento' => $user->tipoDocumento->nom_tipo_documento,
            'cod_tipo_documento' => $user->tipoDocumento->cod_tipo_documento,
            'direccion' => $user->direccion,
            'id_genero' => $user->id_genero,
            'id_tipo_documento' => $user->id_tipo_documento
        ];

        $user->estado = 1;
        $user->save();
        //$user->delete();

        return $data;
    }
}