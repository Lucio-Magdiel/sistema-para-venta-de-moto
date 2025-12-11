<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ReporteController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Reportes/Index');
    }

    public function ventas(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $ventas = Venta::with(['cliente', 'moto', 'user'])
            ->whereBetween('fecha_venta', [
                $request->fecha_inicio,
                $request->fecha_fin . ' 23:59:59'
            ])
            ->orderBy('fecha_venta', 'desc')
            ->get();

        $totalIngresos = $ventas->sum('precio_venta');
        $totalVentas = $ventas->count();

        // Ventas por método de pago
        $ventasPorMetodo = $ventas->groupBy('metodo_pago')->map(function ($items, $key) {
            return [
                'metodo' => $key,
                'cantidad' => $items->count(),
                'total' => $items->sum('precio_venta'),
            ];
        })->values();

        // Ventas por vendedor
        $ventasPorVendedor = $ventas->groupBy('user.name')->map(function ($items, $key) {
            return [
                'vendedor' => $key,
                'cantidad' => $items->count(),
                'total' => $items->sum('precio_venta'),
            ];
        })->values();

        return Inertia::render('Reportes/Ventas', [
            'ventas' => $ventas,
            'resumen' => [
                'totalIngresos' => $totalIngresos,
                'totalVentas' => $totalVentas,
                'promedioVenta' => $totalVentas > 0 ? $totalIngresos / $totalVentas : 0,
            ],
            'ventasPorMetodo' => $ventasPorMetodo,
            'ventasPorVendedor' => $ventasPorVendedor,
            'filtros' => $request->only(['fecha_inicio', 'fecha_fin']),
        ]);
    }
}
