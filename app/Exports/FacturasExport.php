<?php

namespace App\Exports;

use App\Models\Factura;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FacturasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * Traemos todas las facturas de la base de datos junto con su cliente
    */
    public function collection()
    {
        return Factura::with(['cliente', 'metodo_pago'])->get();
    }

    /**
    * Aquí ordenamos qué dato va en cada columna del Excel
    */
    public function map($factura): array
    {
        return [
            $factura->id,
            \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y'),
            $factura->cliente->nombre ?? 'Consumidor Final',
            $factura->metodo_pago->tipo ?? 'No especificado',
            $factura->saldopendiente,
            $factura->total,
            // Si el estado es 1 muestra 'Activa', de lo contrario muestra 'Inactiva'
            $factura->estado == 1 ? 'Activa' : 'Inactiva' 
        ];
    }

    /**
    * Los títulos que se verán en la fila de arriba (Fila 1)
    */
    public function headings(): array
    {
        return [
            'ID Factura',
            'Fecha Emisión',
            'Cliente',
            'Método de Pago',
            'Saldo Pendiente',
            'Total Facturado',
            'Estado'
        ];
    }

   
}
