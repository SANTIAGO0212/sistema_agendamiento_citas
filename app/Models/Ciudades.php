<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Ciudades extends Model
{
    use HasFactory, Notifiable;
    protected $tables = ['ciudades'];

    protected $fillable = [
        'cod_ciudad',
        'nom_ciudad',
        'id_departamento',
        'estado'
    ];

    public function departamento() {
        return $this->belongsTo(Departamentos::class, 'id_departamento');
    }
}
