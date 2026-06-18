<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'precio_venta' => $this->faker->randomFloat(2, 600, 1000),
            'descripcion' => $this->faker->sentence(),
            'stock' => $this->faker->numberBetween(1, 100),
            'stock_minimo' => $this->faker->numberBetween(1, 100),
            'imagen' => $this->faker->imageUrl(),
            'estado' => '1',
            'registradopor' => $this->faker->name(),
        ];
    }
}
