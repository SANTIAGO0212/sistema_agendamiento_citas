<?php

namespace App\Services;

use App\Http\Requests\GeneroRequest;
use App\Http\Requests\UpdateGeneroRequest;
use App\Models\Genero;

class GeneroService
{
    /**
     * Create a new class instance.
    */

    protected $GeneroRequest, $updateGeneroRequest;

    public function __construct()
    {
        $this->GeneroRequest = null;
        $this->updateGeneroRequest = null;
    }

    /**
     * Listar generos.
     *
    */
    public function listar()
    {
        $query = Genero::select('nom_genero', 'estado')->where('estado', 1);

        return $query->get();
    }

    /**
     * Crear nuevo género
     * @return \App\Models\Genero
    */
    public function crear()
    {
        $request = app(GeneroRequest::class);
        $data = $request->validated();
        return Genero::create($data);
    }

    /**
     * Actualizar un género
     * 
     * @param int $id
     * @return \App\Models\Genero|null
    */
    public function actualizar(int $id)
    {
        $request = app(UpdateGeneroRequest::class);
        $data = $request->validated();

        $genero = Genero::findOrFail($id);
        $genero->update($data);

        return $genero;
    }
    /**
     * Eliminar un género (SoftDelete).
     *
     * @param int $id
     * @return bool
    */
    public function eliminar(int $id)
    {
        $genero = Genero::findOrFail($id);
        
        $genero->estado = 0;
        $genero->save();

        return $genero;
    }

    /**
     * Restaurar un género eliminado.
     *
     * @param int $id
     * @return bool
    */
    public function restaurar(int $id)
    {
        $genero = Genero::findOrFail($id);
        
        $genero->estado = 1;
        $genero->save();
        
        return $genero;
    }
}