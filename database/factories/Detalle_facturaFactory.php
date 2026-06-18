<?php

namespace Database\Factories;

use App\Models\Detalle_factura;
use App\Models\Factura;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Detalle_factura>
 */
class Detalle_facturaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cantidad = $this->faker->numberBetween(1, 5);
        $precio = $this->faker->randomFloat(2, 100, 500);

        return [
            'factura_id' => Factura::factory(), // Relación
            'producto_id' => Producto::factory(), // Relación
            'cantidad' => $cantidad,
            'subtotal' => $cantidad * $precio,
            'registrado_por' => $this->faker->name(),
        ];
    }
}
