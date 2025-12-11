<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Moto;
use App\Models\User;
use App\Models\Venta;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@motos.com',
            'role' => 'admin',
        ]);

        // Crear usuario vendedor
        $user = User::factory()->create([
            'name' => 'Vendedor Test',
            'email' => 'test@example.com',
            'role' => 'vendedor',
        ]);

        // Crear motos
        $motos = Moto::factory(20)->create();

        // Crear clientes
        $clientes = Cliente::factory(15)->create();

        // Crear algunas ventas
        foreach ($clientes->random(10) as $cliente) {
            $moto = $motos->where('stock', '>', 0)->random();
            
            Venta::factory()->create([
                'cliente_id' => $cliente->id,
                'moto_id' => $moto->id,
                'user_id' => fake()->randomElement([$admin->id, $user->id]),
                'precio_venta' => $moto->precio,
            ]);

            // Reducir stock
            $moto->decrement('stock');
        }
    }
}
