@extends('layouts.panel')

@section('content')

{{-- MÉTRICAS --}}
<div class="row g-4">

@php
$cards = [
    ['title'=>'Pedidos totales','value'=>$metrics['orders'],'color'=>'primary','icon'=>'bx-cart'],
    ['title'=>'Ingresos totales','value'=>'$'.number_format($metrics['revenue']),'color'=>'danger','icon'=>'bx-wallet'],
    ['title'=>'Tasa de rebote','value'=>$metrics['bounce'].'%','color'=>'success','icon'=>'bx-trending-down'],
    ['title'=>'Total clientes','value'=>'8.4K','color'=>'warning','icon'=>'bx-user'],
];
@endphp

@foreach($cards as $card)
<div class="col-md-3">
    <div class="metric-card border-{{ $card['color'] }}">
        <div>
            <small>{{ $card['title'] }}</small>
            <h4>{{ $card['value'] }}</h4>
        </div>
        <div class="icon-circle bg-{{ $card['color'] }}">
            <i class='bx {{ $card['icon'] }}'></i>
        </div>
    </div>
</div>
@endforeach

</div>

{{-- GRÁFICOS --}}
<div class="row mt-4">
    <div class="col-lg-8 grafica_general">
        <div class="card p-3">
            <h6>Descripción general de ventas</h6>
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card p-3">
            <h6>Productos de tendencia</h6>
            <canvas id="donutChart"></canvas>

            <ul class="trend-list mt-3">
                @foreach($trending as $item)
                <li>
                    <span>{{ $item['name'] }}</span>
                    <span class="badge" style="background:{{ $item['color'] }}">
                        {{ $item['value'] }}
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

{{-- TABLA --}}
<div class="card mt-4 p-3">
    <h6>Pedidos recientes</h6>

    <table class="table align-middle">
        <thead>
        <tr>
            <th>Producto</th>
            <th>ID</th>
            <th>Estado</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            <th>Envío</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order['product'] }}</td>
            <td>{{ $order['id'] }}</td>
            <td>
                <span class="badge 
                @if($order['status']=='Pagado') bg-success
                @elseif($order['status']=='Pendiente') bg-warning
                @else bg-danger @endif">
                {{ $order['status'] }}
                </span>
            </td>
            <td>${{ $order['amount'] }}</td>
            <td>{{ $order['date'] }}</td>
            <td>
                <div class="progress" style="height:6px;">
                    <div class="progress-bar bg-success" 
                        style="width:{{ $order['progress'] }}%">
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
window.salesData = @json($sales);
window.visitsData = @json($visits);
window.trendingData = @json($trending);
</script>

@endsection