<?php

namespace App\Http\Controllers;
Use App\Http\Requests\MetodoPagoRequest;
use App\Models\Metodo_pago;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;  
use Exception;                           
use Illuminate\Support\Facades\Log;

class Metodo_pagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $metodo_pagos = Metodo_pago::all(); 
    return view('metodo_pagos.index', compact('metodo_pagos'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('metodo_pagos.create'); 
}

public function store(MetodoPagoRequest $request)
{
    // 1. ELIMINAMOS el $request->validate porque el Request ya lo hace solo.

    // 2. Registramos el método de pago de forma directa y limpia
    Metodo_pago::create([
        'tipo'           => $request->tipo,
        'estado'         => '1', // 1 = Disponible por defecto
        'registrado_por' => auth()->user()->name // Captura "Angie Ramirez"
    ]);

    // 3. Redirección con el mensaje de éxito
    return redirect()->route('metodo_pagos.index')
                     ->with('successMsg', 'Método de pago creado exitosamente');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    // Buscamos el método de pago por su ID
    $metodo_pago = Metodo_pago::findOrFail($id);

    // Retornamos la vista pasándole la variable
    return view('metodo_pagos.edit', compact('metodo_pago'));
}

    /**
     * Update the specified resource in storage.
     */
    // Asegúrate de que arriba esté importado tu Request: use App\Http\Requests\MetodoPagoRequest;

public function update(MetodoPagoRequest $request, $id)
{
    // Buscamos el registro a modificar
    $metodo_pago = Metodo_pago::findOrFail($id);

    // Actualizamos únicamente el nombre (tipo)
    $metodo_pago->update([
        'tipo' => $request->tipo,
    ]);

    return redirect()->route('metodo_pagos.index')
                     ->with('successMsg', 'El método de pago se ha actualizado correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Metodo_pago $metodo_pago)
    {
        try {

            $metodo_pago->delete();

            return redirect()
                ->route('metodo_pagos.index')
                ->with('successMsg', 'El registro se eliminó exitosamente');

        } catch (QueryException $e) {

            Log::error('Error al eliminar el método de pago: ' . $e->getMessage());

            return redirect()
                ->route('metodo_pagos.index')
                ->withErrors('El registro tiene información relacionada');

        } catch (Exception $e) {

            Log::error('Error inesperado: ' . $e->getMessage());

            return redirect()
                ->route('metodo_pagos.index')
                ->withErrors('Ocurrió un error inesperado');
        }
    }

    public function cambioestadometodopago(Request $request)
    {
        // 1. Buscamos el registro
        // Nota: Si te da error de "Class not found", cámbialo a MetodoPago::find...
        $metodo_pago = Metodo_pago::find($request->id);
        
        if ($metodo_pago) {
            // 2. Forzamos el valor "1" o "0" como string
            $metodo_pago->estado = ($request->estado == 'true' || $request->estado == 1 || $request->estado == true) ? "1" : "0";
            
            $metodo_pago->save();

            return response()->json(['success' => 'Estado del método de pago actualizado']);
        }

        return response()->json(['error' => 'No se encontró el método de pago'], 404);
    }
    public function papelera()
{
    // Solo trae los que tienen deleted_at lleno
    $metodo_pagos = Metodo_pago::onlyTrashed()->get();
    
    return view('metodo_pagos.papelera', compact('metodo_pagos'));
}

/**
 * Restaura un método de pago desde la papelera
 */
public function restaurar($id)
{
    // Busca el registro incluso entre los borrados y lo restaura
    $metodo = Metodo_pago::withTrashed()->findOrFail($id);
    $metodo->restore();

    return redirect()->route('metodo_pagos.index')
        ->with('success', 'Método de pago restaurado y disponible nuevamente.');
}

}
