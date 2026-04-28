<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genero;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genero::firstOrCreate(
            ['nom_genero' => 'Masculino']
        );

        Genero::firstOrCreate(
            ['nom_genero' => 'Femenino']
        );

        Genero::firstOrCreate(
            ['nom_genero' => 'No Binario']
        );
    }
}
