<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ClienteController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Cliente::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('documento', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $clientes = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Clientes/Index', [
            'clientes' => $clientes,
            'filters' => $request->only('search'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Clientes/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'documento' => 'required|string|unique:clientes,documento',
            'email' => 'required|email|unique:clientes,email',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string',
        ]);

        Cliente::create($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function show(Cliente $cliente): Response
    {
        $cliente->load('ventas.moto');

        return Inertia::render('Clientes/Show', [
            'cliente' => $cliente,
        ]);
    }

    public function edit(Cliente $cliente): Response
    {
        return Inertia::render('Clientes/Edit', [
            'cliente' => $cliente,
        ]);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'documento' => 'required|string|unique:clientes,documento,' . $cliente->id,
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}
