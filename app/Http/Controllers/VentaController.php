<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Moto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class VentaController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Venta::with(['cliente', 'moto', 'user']);

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%");
            })->orWhereHas('moto', function ($q) use ($search) {
                $q->where('marca', 'like', "%{$search}%")
                    ->orWhere('modelo', 'like', "%{$search}%");
            });
        }

        $ventas = $query->latest('fecha_venta')->paginate(10)->withQueryString();

        return Inertia::render('Ventas/Index', [
            'ventas' => $ventas,
            'filters' => $request->only('search'),
        ]);
    }

    public function create(): Response
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $motos = Moto::where('stock', '>', 0)->orderBy('marca')->get();

        return Inertia::render('Ventas/Create', [
            'clientes' => $clientes,
            'motos' => $motos,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'moto_id' => 'required|exists:motos,id',
            'precio_venta' => 'required|numeric|min:0',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia,financiamiento',
            'observaciones' => 'nullable|string',
            'fecha_venta' => 'required|date',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $moto = Moto::findOrFail($validated['moto_id']);

            if ($moto->stock <= 0) {
                throw new \Exception('No hay stock disponible para esta moto.');
            }

            $validated['user_id'] = $request->user()->id;

            Venta::create($validated);

            $moto->decrement('stock');
        });

        return redirect()->route('ventas.index')->with('success', 'Venta registrada exitosamente.');
    }

    public function show(Venta $venta): Response
    {
        $venta->load(['cliente', 'moto', 'user']);

        return Inertia::render('Ventas/Show', [
            'venta' => $venta,
        ]);
    }

    public function destroy(Venta $venta)
    {
        DB::transaction(function () use ($venta) {
            $moto = $venta->moto;
            $moto->increment('stock');
            $venta->delete();
        });

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada y stock restaurado.');
    }
}
