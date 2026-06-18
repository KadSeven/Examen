<?php

namespace App\Http\Controllers;
use App\Http\Requests\PagoRequest;
use App\Models\Pago;
use App\Models\Factura;
use App\Models\Metodo_pago;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pagos = Pago::all();
        return view('pagos.index', compact('pagos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        // Obtenemos facturas con sus clientes para el select
        $facturas = Factura::with('cliente')->where('estado', '=', '1')->get();
        $metodos = Metodo_pago::where('estado', '1')->get(); 
        return view('pagos.create', compact('facturas', 'metodos'));
    }

    public function store(PagoRequest $request) {
        $request->validate([
        'factura_id'     => 'required|exists:facturas,id',
        'monto'          => 'required|numeric|min:1',
        'fecha_pago'     => 'required|date',
        'metodo_pago_id' => [
            'required',
            \Illuminate\Validation\Rule::exists('metodo_pagos', 'id')->where(function ($query) {
                $query->where('estado', '1');
            }),
        ],
    ], [
        'metodo_pago_id.exists' => 'El método de pago seleccionado no está disponible actualmente.',
    ], [
        // Mensajes personalizados (opcional)
        'factura_id.required' => 'Debe seleccionar una factura obligatoriamente.',
        'monto.min'           => 'El monto debe ser mayor a cero.',
    ]);
        $request->merge([
            'estado' => '1', // Activo por defecto
            'registrado_por' => Auth::user()->name // Guardamos el nombre
        ]);

        Pago::create($request->all());

        return redirect()->route('pagos.index')->with('successMsg', 'Pago registrado correctamente');
    }


    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    // No olvides importar tus modelos arriba: 
// use App\Models\Pago; use App\Models\Factura; use App\Models\Metodo_pago;

public function edit($id)
{
    // 1. Buscamos el pago a editar
    $pago = Pago::findOrFail($id);

    // 2. Traemos las facturas y los métodos de pago activos para los selectores
    $facturas = Factura::all(); 
    $metodos = Metodo_pago::where('estado', '1')->get(); // Solo los activos

    // 3. Enviamos todo a la vista
    return view('pagos.edit', compact('pago', 'facturas', 'metodos'));
}

    /**
     * Update the specified resource in storage.
     */
    // Asegúrate de usar tu request validado arriba: use App\Http\Requests\PagoRequest;

public function update(PagoRequest $request, $id)
{
    // Buscamos el pago correspondiente
    $pago = Pago::findOrFail($id);

    // Actualizamos el registro con los datos limpios y validados
    $pago->update([
        'factura_id'     => $request->factura_id,
        'monto'          => $request->monto,
        'metodo_pago_id' => $request->metodo_pago_id,
        'fecha_pago'     => $request->fecha_pago,
        // Mantener "registrado_por" intacto para saber quién lo creó originalmente
    ]);

    return redirect()->route('pagos.index')
                     ->with('successMsg', 'El pago ha sido modificado y actualizado correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pago $pago)
{
    try {
        // Al tener SoftDeletes en el modelo, esto no borra el registro de la DB,
        // solo llena la columna deleted_at.
        $pago->delete();

        return redirect()->route('pagos.index')
            ->with('success', 'El pago ha sido movido a la papelera correctamente.');
    } catch (\Exception $e) {
        return redirect()->route('pagos.index')
            ->with('error', 'No se pudo eliminar el pago.');
    }
}
    public function papelera()
{
    // Obtenemos los pagos borrados incluyendo la relación con factura y cliente
    $pagos = Pago::onlyTrashed()->with('factura.cliente')->get();
    return view('pagos.papelera', compact('pagos'));
}

public function restaurar($id)
{
    Pago::withTrashed()->findOrFail($id)->restore();
    return redirect()->route('pagos.index')->with('success', 'Pago restaurado correctamente');
}

}
