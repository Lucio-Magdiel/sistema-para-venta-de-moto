<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MotoFactory extends Factory
{
    public function definition(): array
    {
        $marcas = ['Honda', 'Yamaha', 'Suzuki', 'Kawasaki', 'Ducati', 'BMW', 'Harley-Davidson', 'KTM', 'Triumph', 'Bajaj'];
        $colores = ['Rojo', 'Negro', 'Azul', 'Blanco', 'Verde', 'Naranja', 'Gris', 'Amarillo'];
        
        return [
            'marca' => fake()->randomElement($marcas),
            'modelo' => fake()->bothify('??-####'),
            'año' => fake()->numberBetween(2018, 2025),
            'color' => fake()->randomElement($colores),
            'cilindrada' => fake()->randomElement([125, 150, 200, 250, 300, 500, 650, 750, 1000]),
            'precio' => fake()->randomFloat(2, 2000, 30000),
            'stock' => fake()->numberBetween(0, 10),
            'descripcion' => fake()->sentence(20),
            'estado' => fake()->randomElement(['nuevo', 'usado']),
        ];
    }
}
