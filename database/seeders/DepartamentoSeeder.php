<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Departamentos;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filas = Excel::toArray([], storage_path('app/imports/lista_departamentos.xlsx'));

        //En la primera hoja
        $filas = $filas[0];

        //Se elimina la fila de encabezados.
        unset($filas[0]);

        foreach($filas as $fila) {
            Departamentos::firstOrCreate([
                'cod_departamento' => $fila[0],
                'nom_departamento' => $fila[2],
            ]);
        }
    }
}
