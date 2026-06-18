<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'documento' => $this->faker->numerify('##########'), // 10 almohadillas = 10 números
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->phoneNumber(),
            'correo' => $this->faker->unique()->safeEmail(),
            'estado' => '1',
            'registrado_por' => $this->faker->name(),
        ];
    }
}
