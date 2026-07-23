<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TipoDocumentoSeeder;
use Database\Seeders\GeneroSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\DepartamentoSeeder;
use Database\Seeders\CiudadesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            TipoDocumentoSeeder::class,
            GeneroSeeder::class,
            UserSeeder::class,
            DepartamentoSeeder::class,
            CiudadesSeeder::class
        ]);
    }
}