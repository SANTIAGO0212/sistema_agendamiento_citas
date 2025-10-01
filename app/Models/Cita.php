<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Especialista;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'citas';

    protected $fillable = [
        'fecha',
        'hora',
        'estado',
        'id_usuario',
        'id_servicio',
        'id_especialista',
        'id_sucursal'
    ];
    protected $dates = ['deleted_at'];

    public function users() {

        return $this->belongsToMany(User::class, 'id_usuario');

    }

    public function servicios() {

        return $this->belongsToMany(Servicio::class, 'id_servicio');

    }

    public function especialistas() {

        return $this->belongsToMany(Especialista::class, 'id_especialista');

    }

    public function sucursales() {

        return $this->belongsToMany(Sucursal::class, 'id_sucursal');

    }

    
}
