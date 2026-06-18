<?php

namespace Database\Seeders;

// Importamos todos los modelos necesarios
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Factura;
use App\Models\Detalle_factura;
use App\Models\Metodo_pago;
use App\Models\Pago;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Datos independientes
        Cliente::factory(20)->create();
        Producto::factory(20)->create();

        // 2. Métodos de Pago (Tu lógica de únicos)
        $metodos = ['Efectivo', 'Tarjeta', 'Transferencia'];
        foreach ($metodos as $tipo) {
            Metodo_pago::firstOrCreate(
                ['tipo' => $tipo],
                ['estado' => 1, 'registrado_por' => 'Sistema']
            );
        }

        // 3. Datos dependientes (Importante el orden)
        Factura::factory(20)->create();
        Detalle_factura::factory(20)->create();
        Pago::factory(20)->create();
        User::factory(20)->create();
    }
}