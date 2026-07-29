<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursal extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'sucursales';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'estado',
        'id_departamento',
        'id_ciudad'
    ];
    protected $dates = ['deleted_at'];

    public function departamento() {
        return $this->belongsTo(Departamentos::class, 'id_departamento');
    }

    public function ciudad() {
        return $this->belongsTo(Ciudades::class, 'id_ciudad');
    }
}
