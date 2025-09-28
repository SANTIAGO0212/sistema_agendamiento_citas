<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class MigrationController extends Controller
{
    public function runMigrations(Request $request) 
    {
        try {
            // Ejecutar migraciones
            Artisan::call('migrate', ['--force' => true]);
            
            $output = Artisan::output();

            return response()->json([
                'status'  => 'success',
                'message' => 'Migraciones ejecutadas correctamente',
                'output'  => $output
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Error al ejecutar migraciones: ' . $e->getMessage()
            ], 500);
        }
    }

    public function migrationStatus(Request $request) 
    {
        try {
            Artisan::call('migrate:status');
            
            $output = Artisan::output();

            return response()->json([
                'status'  => 'success',
                'message' => 'Estado de migraciones',
                'output'  => $output
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Error al verificar estado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function rollbackMigrations(Request $request) 
    {
        try {
            Artisan::call('migrate:rollback', ['--force' => true]);
            
            $output = Artisan::output();

            return response()->json([
                'status'  => 'success',
                'message' => 'Rollback ejecutado correctamente',
                'output'  => $output
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Error al ejecutar rollback: ' . $e->getMessage()
            ], 500);
        }
    }
}
