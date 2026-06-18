<?php

namespace Database\Factories;

use App\Models\Pago;
use App\Models\Factura;
use App\Models\Metodo_pago;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pago>
 */
class PagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'factura_id' => $this->faker->randomElement(\App\Models\Factura::pluck('id')->toArray()), // Relación
            'metodo_pago_id' => $this->faker->randomElement(\App\Models\Metodo_pago::pluck('id')->toArray()),
            'fecha_pago' => $this->faker->date(),
            'monto' => $this->faker->randomFloat(2, 50, 500),
            'registrado_por' => $this->faker->name(),
        ];
    }
}
