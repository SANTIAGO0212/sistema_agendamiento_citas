<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialista extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'especialistas';

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'email',
        'estado',
        'id_sucursal',
        'id_servicio'
    ];
    protected $dates = ['deleted_at'];

    public function servicios() {

        return $this->belongsToMany(Servicio::class, 'id_servicio');

    }

    public function sucursales() {

        return $this->belongsToMany(Sucursal::class, 'id_sucursal');

    }
}
