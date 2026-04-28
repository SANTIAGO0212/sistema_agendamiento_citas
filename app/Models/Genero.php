<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genero extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'generos';

    protected $fillable = [
        'nom_genero',
        'estado'
    ];

    protected $dates = ['deleted_at'];
}
