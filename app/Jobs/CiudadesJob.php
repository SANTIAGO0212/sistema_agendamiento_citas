<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Ciudades;

class CiudadesJob implements ShouldQueue
{
    use Queueable;

    protected array $filas;

    /**
     * Create a new job instance.
     */
    public function __construct(array $filas)
    {
        $this->filas = $filas;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->filas as $fila) {
            
            if(empty($fila[0])) {
                continue;
            }

            Ciudades::firstOrCreate([
                'cod_ciudad' => $fila[0],
                'nom_ciudad' => $fila[2],
                'id_departamento' => $fila[3],
            ]);
        }
    }
}
