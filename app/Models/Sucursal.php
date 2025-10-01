<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
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
    ];
    protected $dates = ['deleted_at'];
}
