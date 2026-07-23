<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\CiudadesJob;

class CiudadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filas = Excel::toArray([], storage_path('app/imports/lista_ciudades.xlsx'));

        //En la primera hoja
        $filas = $filas[0];

        //Se elimina la fila de encabezados.
        unset($filas[0]);

        // Se dividen de a 200 registros para mayor rapidez.
        $chunks = array_chunk($filas,200);

        foreach($chunks as $chunk) {
            CiudadesJob::dispatch($chunk);
        }
        $this->command->info('Job ejecutado correctamente.');
    }
}
