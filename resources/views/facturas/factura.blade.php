<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $factura->id }}</title>
    <style>
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 13px; 
            margin: 15px; 
            color: #333;
        }
        .header { 
            text-align: center; 
            border-bottom: 3px solid #dc3545; /* Rojo oficial PDF */
            padding-bottom: 12px;
            margin-bottom: 25px; 
        }
        .header h2 { margin: 0; color: #dc3545; letter-spacing: 1px; }
        .header p { margin: 4px 0 0 0; font-size: 12px; color: #666; }
        
        .info-table { 
            width: 100%;
            margin-bottom: 25px; 
            border: none;
        }
        .info-table td {
            padding: 4px 0;
            border: none;
            width: 50%;
            vertical-align: top;
        }
        
        .items-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 25px; 
        }
        .items-table th { 
            padding: 10px; 
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            text-align: left;
            font-weight: bold;
        }
        .items-table td { 
            padding: 10px; 
            border: 1px solid #ddd;
            text-align: left; 
        }
        
        .total-container {
            width: 100%;
            margin-top: 15px;
        }
        .total-box { 
            float: right;
            width: 40%;
            border-collapse: collapse;
        }
        .total-box td {
            padding: 6px 10px;
            border: 1px solid #ddd;
        }
        .total-highlight {
            background-color: #f8d7da;
            color: #721c24;
            font-weight: bold;
            font-size: 15px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>FACTURA DE VENTA</h2>
        <p>Fecha de impresión: {{ $fecha }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td>
                <strong>Factura N°:</strong> {{ $factura->id }}<br>
                <strong>Fecha Emisión:</strong> {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}<br>
                <strong>Método de Pago:</strong> {{ $factura->metodo_pago->tipo ?? 'No especificado' }}
            </td>
            <td>
                <strong>Cliente:</strong> {{ $factura->cliente->nombre ?? 'Consumidor Final' }}<br>
                <strong>Estado:</strong> {{ $factura->estado == 1 ? 'Activa' : 'Inactiva' }}<br>
                <strong>Registrado Por:</strong> {{ $factura->registrado_por ?? 'Sistema' }}
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Descripción / Producto</th>
                <th style="text-align: center; width: 12%;">Cantidad</th>
                <th style="text-align: right; width: 20%;">Precio Unitario</th>
                <th style="text-align: right; width: 20%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            {{-- Usamos la relación dinámica por defecto de Laravel para tu modelo Detalle_factura --}}
            @php
                $detalles = $factura->detalles ?? $factura->detalle_facturas ?? $factura->detallefacturas;
            @endphp

            @forelse($detalles as $detalle)
                <tr>
                    {{-- Nombre del producto relacionado --}}
                    <td>{{ $detalle->producto->nombre ?? 'Artículo de Venta #' . $detalle->producto_id }}</td>
                    
                    {{-- Cantidad --}}
                    <td style="text-align: center;">{{ $detalle->cantidad }}</td>
                    
                    {{-- Precio Unitario Calculado (Subtotal / Cantidad) para evitar los ceros --}}
                    <td style="text-align: right;">
                        @if($detalle->cantidad > 0)
                            ${{ number_format($detalle->subtotal / $detalle->cantidad, 2) }}
                        @else
                            ${{ number_format($detalle->producto->precio_venta ?? 0, 2) }}
                        @endif
                    </td>
                    
                    {{-- Subtotal real de la base de datos --}}
                    <td style="text-align: right;">${{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #999;">
                        No hay artículos registrados en los detalles de esta factura.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-container">
        <table class="total-box">
            <tr>
                <td><strong>Saldo Pendiente:</strong></td>
                <td style="text-align: right;">${{ number_format($factura->saldopendiente, 2) }}</td>
            </tr>
            <tr class="total-highlight">
                <td><strong>TOTAL NETO:</strong></td>
                <td style="text-align: right;">${{ number_format($factura->total, 2) }}</td>
            </tr>
        </table>
    </div>

</body>
</html>