<?php

namespace App\Http\Controllers;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;  // ← ¿Tienes esta línea?
use Exception;                           // ← ¿Y esta?
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    public function store(ClienteRequest $request)
{
    // El ClienteRequest ya validó todo con éxito antes de entrar aquí

    Cliente::create([
        'nombre'         => $request->nombre,
        'documento'      => $request->documento,
        'direccion'      => $request->direccion,
        'telefono'       => $request->telefono, 
        'correo'         => $request->correo,
        'estado'         => '1', // Asigna estado activo automáticamente
        'registrado_por' => auth()->user()->name // Registra al usuario logueado
    ]);

    return redirect()->route('clientes.index')
                     ->with('successMsg', 'El registro se guardó exitosamente');
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
    // Buscamos al cliente por su ID
    $cliente = Cliente::findOrFail($id);

    // Retornamos la vista de edición pasándole el cliente encontrado
    return view('clientes.edit', compact('cliente'));
}



public function update(ClienteRequest $request, $id)
{
    // Buscamos al cliente que se va a modificar
    $cliente = Cliente::findOrFail($id);

    // Actualizamos los datos de forma masiva y segura
    $cliente->update([
        'nombre'    => $request->nombre,
        'documento' => $request->documento,
        'direccion' => $request->direccion,
        'telefono'  => $request->telefono,
        'correo'    => $request->correo,
        // El estado y "registrado_por" se quedan iguales, no hace falta tocarlos
    ]);

    return redirect()->route('clientes.index')
                     ->with('successMsg', 'El cliente ha sido actualizado correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
		try {
            $cliente->delete();
            return redirect()->route('clientes.index')->with('successMsg', 'El registro se eliminó exitosamente');
        } catch (QueryException $e) {
            // Capturar y manejar violaciones de restricción de clave foránea
            Log::error('Error al eliminar el cliente: ' . $e->getMessage());
            return redirect()->route('clientes.index')->withErrors('El registro que desea eliminar tiene información relacionada. Comuníquese con el Administrador');
        } catch (Exception $e) {
            // Capturar y manejar cualquier otra excepción
            Log::error('Error inesperado al eliminar el cliente: ' . $e->getMessage());
            return redirect()->route('clientes.index')->withErrors('Ocurrió un error inesperado al eliminar el registro. Comuníquese con el Administrador');
        }
    }

    public function cambioestadocliente(Request $request)
    {
        $cliente = Cliente::find($request->id);
        
        // Forzamos la conversión: 
        // Si es el texto 'true', el booleano true, o el número 1, guardamos el string "1"
        $cliente->estado = ($request->estado == 'true' || $request->estado == 1 || $request->estado == true) ? "1" : "0";
        
        $cliente->save();

        // Es importante retornar una respuesta para que el AJAX no falle
        return response()->json([
            'success' => 'Estado actualizado correctamente',
            'nuevo_estado' => $cliente->estado
        ]);

    }

    public function papelera()
{
    // Solo trae los clientes que han sido "borrados" (deleted_at no es null)
    $clientes = Cliente::onlyTrashed()->get();
    
    return view('clientes.papelera', compact('clientes'));
}

public function restaurar($id)
{
    // Buscamos al cliente incluso entre los borrados y lo restauramos
    $cliente = Cliente::withTrashed()->findOrFail($id);
    $cliente->restore();

    return redirect()->route('clientes.index')
                     ->with('success', 'Cliente restaurado correctamente.');
}

}
