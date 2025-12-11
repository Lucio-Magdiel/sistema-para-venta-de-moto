<?php

namespace App\Http\Controllers;

use App\Models\Moto;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MotoController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Moto::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('marca', 'like', "%{$search}%")
                    ->orWhere('modelo', 'like', "%{$search}%")
                    ->orWhere('color', 'like', "%{$search}%");
            });
        }

        $motos = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Motos/Index', [
            'motos' => $motos,
            'filters' => $request->only('search'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Motos/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'año' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:255',
            'cilindrada' => 'required|integer|min:50',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|string',
            'estado' => 'required|in:nuevo,usado',
        ]);

        Moto::create($validated);

        return redirect()->route('motos.index')->with('success', 'Moto creada exitosamente.');
    }

    public function show(Moto $moto): Response
    {
        return Inertia::render('Motos/Show', [
            'moto' => $moto,
        ]);
    }

    public function edit(Moto $moto): Response
    {
        return Inertia::render('Motos/Edit', [
            'moto' => $moto,
        ]);
    }

    public function update(Request $request, Moto $moto)
    {
        $validated = $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'año' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:255',
            'cilindrada' => 'required|integer|min:50',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|string',
            'estado' => 'required|in:nuevo,usado',
        ]);

        $moto->update($validated);

        return redirect()->route('motos.index')->with('success', 'Moto actualizada exitosamente.');
    }

    public function destroy(Moto $moto)
    {
        $moto->delete();

        return redirect()->route('motos.index')->with('success', 'Moto eliminada exitosamente.');
    }
}
