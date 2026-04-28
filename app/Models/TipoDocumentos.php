<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoDocumentos extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'tipo_documentos';

    protected $fillable = [
        'cod_tipo_documento',
        'nom_tipo_documento',
        'estado'
    ];

    protected $dates = ['deleted_at'];
}