<?php

namespace App\Services;

use App\Http\Requests\TipoDocumentosRequest;
use App\Http\Requests\UpdateTipoDocumentosRequest;
use App\Models\TipoDocumentos;

class TipoDocumentosService
{
    /**
     * Create a new class instance.
     */

    protected $TipoDocumentoRequest, $updateTipoDocumentoRequest;

    /**
     * Constructor: inyecta el request validado.
     */

    public function __construct()
    {
        $this->TipoDocumentoRequest = null;
        $this->updateTipoDocumentoRequest = null;
    }

    /**
     * Listar tipos documentos.
     *
    */
    public function listar()
    {
        $query = TipoDocumentos::select('cod_tipo_documento', 'nom_tipo_documento', 'estado')->where('estado', 1);

        return $query->get();
    }

    /**
     * Crear nuevo tipo de documentos
     * @return \App\Models\TipoDocumentos
    */
    public function crear()
    {
        $request = app(TipoDocumentosRequest::class);
        $data = $request->validated();
        return TipoDocumentos::create($data);
    }

    /**
     * Actualizar un tipo de documento
     * 
     * @param int $id
     * @return \App\Models\TipoDocumentos|null
    */
    public function actualizar(int $id)
    {
        $request = app(UpdateTipoDocumentosRequest::class);
        $data = $request->validated();

        $tipo_documento = TipoDocumentos::findOrFail($id);
        $tipo_documento->update($data);

        return $tipo_documento;
    }
    /**
     * Eliminar un tipo de documento (SoftDelete).
     *
     * @param int $id
     * @return bool
    */
    public function eliminar(int $id)
    {
        $tipo_documento = TipoDocumentos::findOrFail($id);
        
        $tipo_documento->estado = 0;
        $tipo_documento->save();

        return $tipo_documento;
    }

    /**
     * Restaurar un tipo de documento eliminado.
     *
     * @param int $id
     * @return bool
    */
    public function restaurar(int $id)
    {
        $tipo_documento = TipoDocumentos::findOrFail($id);
        
        $tipo_documento->estado = 1;
        $tipo_documento->save();
        
        return $tipo_documento;
    }
}
