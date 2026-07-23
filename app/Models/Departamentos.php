<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Departamentos extends Model
{
    use HasFactory, Notifiable;

    protected $tables = ['departamentos'];

    protected $fillable = [
        'cod_departamento',
        'nom_departamento',
        'estado'
    ];
}
