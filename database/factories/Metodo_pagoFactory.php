<?php

namespace Database\Factories;

use App\Models\Metodo_pago;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Metodo_pago>
 */
class Metodo_pagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        // Usamos unique() para que no repita nombres en una misma ejecución
        'tipo' => $this->faker->unique()->randomElement(['efectivo', 'tarjeta', 'transferencia']),
        'estado' => '1',
        'registrado_por' => $this->faker->name(),
    ];
}
}
