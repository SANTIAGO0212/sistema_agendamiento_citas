<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'orders' => 4805,
            'revenue' => 84245,
            'bounce' => 34.6,
            'customers' => 8400
        ];

        $sales = [65, 59, 80, 81, 56, 78, 90, 85, 70, 88, 92, 75];
        $visits = [28, 48, 40, 19, 35, 50, 45, 22, 41, 23, 36, 52];

        $trending = [
            ['name' => 'Vaqueros', 'value' => 25, 'color' => '#28c76f'],
            ['name' => 'Camisetas', 'value' => 10, 'color' => '#ea5455'],
            ['name' => 'Zapatos', 'value' => 65, 'color' => '#7367f0'],
            ['name' => 'Lencería', 'value' => 14, 'color' => '#ff9f43'],
        ];

        $orders = [
            ['product' => 'Iphone 5', 'id' => '#9405822', 'status' => 'Pagado', 'amount' => 1250, 'date' => '03 Feb 2025', 'progress' => 90],
            ['product' => 'Auriculares GL', 'id' => '#8304620', 'status' => 'Pendiente', 'amount' => 1500, 'date' => '05 Feb 2025', 'progress' => 50],
            ['product' => 'Cámara HD', 'id' => '#4736890', 'status' => 'Fallido', 'amount' => 1400, 'date' => '06 Feb 2025', 'progress' => 30],
            ['product' => 'Zapatos clásicos', 'id' => '#8543765', 'status' => 'Pagado', 'amount' => 1200, 'date' => '14 Feb 2025', 'progress' => 95],
        ];

        return view('dashboards.index_admin', compact(
            'metrics',
            'sales',
            'visits',
            'trending',
            'orders'
        ));
    }
}
