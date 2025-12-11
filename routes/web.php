<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas de Motos - Solo Admin puede crear, editar y eliminar
    Route::get('motos', [MotoController::class, 'index'])->name('motos.index');
    Route::get('motos/{moto}', [MotoController::class, 'show'])->name('motos.show');
    Route::middleware('role:admin')->group(function () {
        Route::get('motos/create', [MotoController::class, 'create'])->name('motos.create');
        Route::post('motos', [MotoController::class, 'store'])->name('motos.store');
        Route::get('motos/{moto}/edit', [MotoController::class, 'edit'])->name('motos.edit');
        Route::put('motos/{moto}', [MotoController::class, 'update'])->name('motos.update');
        Route::delete('motos/{moto}', [MotoController::class, 'destroy'])->name('motos.destroy');
    });
    
    // Rutas de Clientes - Solo Admin puede crear, editar y eliminar
    Route::get('clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');
    Route::middleware('role:admin')->group(function () {
        Route::get('clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
        Route::post('clientes', [ClienteController::class, 'store'])->name('clientes.store');
        Route::get('clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::put('clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
        Route::delete('clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    });
    
    // Rutas de Ventas - Todos pueden crear, solo Admin puede eliminar
    Route::get('ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('ventas/create', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');
    Route::middleware('role:admin')->group(function () {
        Route::delete('ventas/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');
    });
    
    // Rutas de Reportes - Solo Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::post('reportes/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');
    });
});

require __DIR__.'/settings.php';
