<?php

namespace Database\Factories;

use App\Models\Factura;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Factura>
 */
class FacturaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha' => $this->faker->dateTime(),
            // 'cliente_id' => Cliente::factory(), // Relación
            'cliente_id' => $this->faker->randomElement(\App\Models\Cliente::pluck('id')->toArray()),
            'metodo_pago_id' => \App\Models\Metodo_pago::all()->random()->id,
            'saldopendiente' => $this->faker->randomFloat(2, 0, 500),
            'total' => $this->faker->randomFloat(2, 100, 1000),
            'estado' => '1',
            'registrado_por' => $this->faker->name(),
        ];
    }
}
