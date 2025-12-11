<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Moto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'moto_id' => Moto::factory(),
            'user_id' => User::factory(),
            'precio_venta' => fake()->randomFloat(2, 2000, 30000),
            'metodo_pago' => fake()->randomElement(['efectivo', 'tarjeta', 'transferencia', 'financiamiento']),
            'observaciones' => fake()->optional()->sentence(),
            'fecha_venta' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
