<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'holamundo@reservali.com'], // Valida en primer lugar si el email ya fue registrado.
            [
                'name' => 'Hola Mundo',
                'password' => Hash::make('12345678'),
                'telefono' => '3133333',
                'num_identificacion' => '111111',
                'direccion' => 'calle92#40-13',
                'id_tipo_documento' => 1,
                'id_genero' => 1,
            ]
        );
    }
}