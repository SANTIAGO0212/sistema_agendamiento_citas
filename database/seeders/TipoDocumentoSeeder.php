<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoDocumentos;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoDocumentos::firstOrCreate(
            ['cod_tipo_documento' => 'CC'],
            ['nom_tipo_documento' => 'Cédula de ciudadanía']
        );

        TipoDocumentos::firstOrCreate(
            ['cod_tipo_documento' => 'CE'],
            ['nom_tipo_documento' => 'Cédula de extranjería']
        );

        TipoDocumentos::firstOrCreate(
            ['cod_tipo_documento' => 'TI'],
            ['nom_tipo_documento' => 'Tarjeta de identidad']
        );

        TipoDocumentos::firstOrCreate(
            ['cod_tipo_documento' => 'PEP/PPT'],
            ['nom_tipo_documento' => 'Permisos de permanencia']
        );
    }
}