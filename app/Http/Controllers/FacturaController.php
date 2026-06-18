<?php

namespace App\Http\Controllers;
use App\Models\Factura;
use App\Models\Cliente;
use App\Http\Requests\FacturaRequest;
use App\Models\Metodo_pago;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\FacturasExport;
use Maatwebsite\Excel\Facades\Excel;


class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facturas = Factura::with(['cliente', 'metodo_pago'])->get();
        return view('facturas.index', compact('facturas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Traemos todos los registros necesarios de la Base de Datos
        $clientes = \App\Models\Cliente::all();
        $metodos_pago = \App\Models\Metodo_pago::all();
        $productos = \App\Models\Producto::all(); // <-- Agregamos esta línea

        // Enviamos las tres variables a la vista
        return view('facturas.create', compact('clientes', 'metodos_pago', 'productos'));
    }

    public function store(FacturaRequest $request)
    {
        // 1. Convertir la fecha al formato que acepta MySQL (YYYY-MM-DD)
        // Soporta tanto si llega DD/MM/AAAA por máscara como si llega YYYY-MM-DD por el input date nativo
        $fechaOriginal = $request->fecha;
        $fechaConvertida = null;

        if ($fechaOriginal) {
            try {
                if (str_contains($fechaOriginal, '/')) {
                    // Si viene con slashes (DD/MM/AAAA)
                    $fechaConvertida = \Carbon\Carbon::createFromFormat('d/m/Y', $fechaOriginal)->format('Y-m-d');
                } else {
                    // Si viene con guiones del input date nativo (YYYY-MM-DD)
                    $fechaConvertida = \Carbon\Carbon::parse($fechaOriginal)->format('Y-m-d');
                }
            } catch (\Exception $e) {
                // Si algo falla, asignamos la fecha actual por seguridad
                $fechaConvertida = now()->format('Y-m-d');
            }
        }

        // 2. Prepara y limpia los datos de auditoría mezclándolos en el request junto con la fecha procesada
        $request->merge([
            'fecha' => $fechaConvertida,
            'estado' => ($request->estado == 'Activo' || $request->estado == '1') ? '1' : '0',
            'registrado_por' => Auth::user()->name ?? 'Sistema'
        ]);

        // 3. Registra la factura principal en la tabla 'facturas' y recupera el objeto creado
        $factura = Factura::create($request->all());

        // 4. Procesa de forma secuencial la lista de productos enviados en los arreglos del formulario
        if ($request->has('productos')) {
            $productos = $request->productos;
            $cantidades = $request->cantidades;
            $precios = $request->precios; // Este es el precio unitario que viene de la vista

            for ($i = 0; $i < count($productos); $i++) {
                // Instancia el modelo con su nombre exacto de la base de datos
                $detalle = new \App\Models\Detalle_factura(); 
                $detalle->factura_id = $factura->id; // Enlaza al ID de la factura generada arriba
                $detalle->producto_id = $productos[$i];
                $detalle->cantidad = $cantidades[$i];
                
                // CORRECCIÓN SEGÚN TU TABLA: 
                // Multiplicamos precio por cantidad para calcular el 'subtotal' que exige tu base de datos
                $detalle->subtotal = $precios[$i] * $cantidades[$i]; 
                
                // Campo de auditoría opcional si tu modelo lo requiere
                $detalle->registrado_por = Auth::user()->name ?? 'Sistema';

                $detalle->save();
            }
        }

        // 5. Envía de vuelta al listado principal con el mensaje de éxito original
        return redirect()->route('facturas.index')
            ->with('successMsg', 'El registro se guardó exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Cargamos la factura junto con su cliente y todos sus detalles con sus productos en una sola consulta
        $factura = Factura::with(['cliente', 'detallefacturas.producto'])->findOrFail($id);
        
        return view('facturas.show', compact('factura'));
    }

  

// Asegúrate de tener el modelo importado arriba: use App\Models\Metodo_pago;



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Factura $factura)
    {
		try {
            $factura->delete();
            return redirect()->route('facturas.index')->with('successMsg', 'El registro se eliminó exitosamente');
        } catch (QueryException $e) {
            // Capturar y manejar violaciones de restricción de clave foránea
            Log::error('Error al eliminar la factura: ' . $e->getMessage());
            return redirect()->route('facturas.index')->withErrors('El registro que desea eliminar tiene información relacionada. Comuníquese con el Administrador');
        } catch (Exception $e) {
            // Capturar y manejar cualquier otra excepción
            Log::error('Error inesperado al eliminar la factura: ' . $e->getMessage());
            return redirect()->route('facturas.index')->withErrors('Ocurrió un error inesperado al eliminar el registro. Comuníquese con el Administrador');
        }
    }

    public function cambioestadofactura(Request $request)
    {
        // 1. Buscamos la factura por ID
        $factura = Factura::find($request->id);
        
        if ($factura) {
            // 2. Forzamos que guarde "1" o "0" como string
            // Esto cubre si el JS envía true, "true", 1 o "1"
            $factura->estado = ($request->estado == 'true' || $request->estado == 1 || $request->estado == true) ? "1" : "0";
            
            $factura->save();

            return response()->json(['success' => 'Estado de factura actualizado']);
        }

        return response()->json(['error' => 'Factura no encontrada'], 404);
    }

    public function papelera()
    {
        // Obtenemos solo las facturas eliminadas
        $facturas = Factura::onlyTrashed()->get();
        return view('facturas.papelera', compact('facturas'));
    }

    public function restaurar($id)
    {
        Factura::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('facturas.index')->with('success', 'Factura restaurada con éxito');
    }

    public function imprimirfactura($id)
    {
        // 1. Buscamos la factura incluyendo sus relaciones reales del modelo
        // Cargamos 'detallefacturas' que es el nombre exacto de tu función
        $factura = \App\Models\Factura::with(['cliente', 'metodo_pago', 'detallefacturas'])->findOrFail($id);

        // 2. Datos organizados para la plantilla del PDF
        $data = [
            'factura' => $factura,
            'fecha'   => now()->format('d/m/Y H:i'),
        ];

        // 3. Cargar la vista en tamaño carta (letter) y orientación vertical (portrait)
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('facturas.pdf', $data)
                ->setPaper('letter', 'portrait');

        // 4. Desplegar el PDF en el navegador
        return $pdf->stream('factura-'.$factura->id.'.pdf');
    }

    public function exportGeneral()
{
    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FacturasExport, 'reporte-facturas.xlsx');
}
    

}