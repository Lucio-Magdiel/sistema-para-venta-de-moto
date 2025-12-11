<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Moto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $totalVentas = Venta::count();
        $totalIngresos = Venta::sum('precio_venta');
        $totalClientes = Cliente::count();
        $totalMotos = Moto::count();
        $stockDisponible = Moto::sum('stock');

        // Ventas por mes (últimos 6 meses)
        $ventasPorMes = Venta::select(
            DB::raw('strftime("%Y-%m", fecha_venta) as mes'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(precio_venta) as ingresos')
        )
            ->where('fecha_venta', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Motos más vendidas
        $motasMasVendidas = Venta::select('motos.marca', 'motos.modelo', DB::raw('COUNT(*) as ventas'))
            ->join('motos', 'ventas.moto_id', '=', 'motos.id')
            ->groupBy('motos.id', 'motos.marca', 'motos.modelo')
            ->orderByDesc('ventas')
            ->limit(5)
            ->get();

        // Métodos de pago
        $metodosPago = Venta::select('metodo_pago', DB::raw('COUNT(*) as total'))
            ->groupBy('metodo_pago')
            ->get();

        // Ventas recientes
        $ventasRecientes = Venta::with(['cliente', 'moto', 'user'])
            ->latest('fecha_venta')
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => [
                'totalVentas' => $totalVentas,
                'totalIngresos' => $totalIngresos,
                'totalClientes' => $totalClientes,
                'totalMotos' => $totalMotos,
                'stockDisponible' => $stockDisponible,
            ],
            'ventasPorMes' => $ventasPorMes,
            'motasMasVendidas' => $motasMasVendidas,
            'metodosPago' => $metodosPago,
            'ventasRecientes' => $ventasRecientes,
        ]);
    }
}
