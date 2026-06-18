<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Http\Requests\ProductoRequest;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all(); //en la variable productos me consulte el modedelo producto y saque todos los elementos y los guarde en esa variable
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    public function store(ProductoRequest $request)
    {
        // 1. Primero Validar (Si esto falla, no intenta guardar nada)
        $request->validate([
            'nombre' => 'required|max:255',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer',
            'stock_minimo' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validamos que sea una imagen real
        ]);

        // Pasamos todos los datos del request a un array para poder manipularlos
        $datos = $request->all();

        // 2. PROCESAR Y GUARDAR LA IMAGEN REAL EN EL SERVIDOR
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            
            // Creamos un nombre único con el tiempo actual para evitar que se dupliquen o borren
            $nombreImagen = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            
            // Movemos físicamente la foto a la carpeta pública: public/images/productos/
            $file->move(public_path('images/productos'), $nombreImagen);
            
            // Guardamos el nombre real del archivo para que se inserte en la base de datos
            $datos['imagen'] = $nombreImagen;
        } else {
            // Si el usuario no subió ninguna foto, la dejamos como nula
            $datos['imagen'] = null;
        }

        // 3. Preparar los datos automáticos (Estado y Usuario)
        $datos['estado'] = 'Activo';
        $datos['registradopor'] = auth()->user()->name ?? 'Sistema'; // Captura "Angie Ramirez" o el usuario logueado

        // 4. Ahora sí, Crear el registro con todos los datos procesados
        Producto::create($datos);

        // 5. Redirigir al listado
        return redirect()->route('productos.index')
                        ->with('successMsg', 'El producto se guardó exitosamente con su imagen');
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
    // Revisa que esté importado arriba: use App\Models\Producto;

public function edit($id)
{
    // Buscamos el producto por su ID
    $producto = Producto::findOrFail($id);

    // Retornamos la vista pasándole el producto
    return view('productos.edit', compact('producto'));
}

    /**
     * Update the specified resource in storage.
     */
    // Asegúrate de importar tu Request arriba: use App\Http\Requests\ProductoRequest;

public function update(ProductoRequest $request, $id)
{
    $producto = Producto::findOrFail($id);

    $producto->update([
        'nombre'       => $request->nombre,
        'descripcion'  => $request->descripcion,
        'precio_venta' => $request->precio_venta,
        'stock'        => $request->stock,
        'stock_minimo' => $request->stock_minimo,
        // La imagen la dejamos igual por ahora para no complicar el flujo
    ]);

    return redirect()->route('productos.index')
                     ->with('successMsg', 'El producto ha sido actualizado correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
		try {
            $producto->delete();
            return redirect()->route('productos.index')->with('successMsg', 'El registro se eliminó exitosamente');
        } catch (QueryException $e) {
            // Capturar y manejar violaciones de restricción de clave foránea
            Log::error('Error al eliminar el producto: ' . $e->getMessage());
            return redirect()->route('productos.index')->withErrors('El registro que desea eliminar tiene información relacionada. Comuníquese con el Administrador');
        } catch (Exception $e) {
            // Capturar y manejar cualquier otra excepción
            Log::error('Error inesperado al eliminar el producto: ' . $e->getMessage());
            return redirect()->route('productos.index')->withErrors('Ocurrió un error inesperado al eliminar el registro. Comuníquese con el Administrador');
        }
    }

    public function cambioestadoproducto(Request $request)
    {
        $producto = Producto::find($request->id);
        
        // Convertimos lo que llegue a 1 o 0
        $producto->estado = ($request->estado == 'true' || $request->estado == 1) ? 1 : 0;
        
        $producto->save();
        
        // Es vital retornar algo para que el JavaScript sepa que terminó bien
        return response()->json(['success' => 'Estado cambiado correctamente']);
    }

    public function papelera()
    {
        // Solo trae los productos que han sido "borrados"
        $productos = Producto::onlyTrashed()->get();
        return view('productos.papelera', compact('productos'));
    }

    public function restaurar($id)
    {
        // Busca el producto incluso entre los borrados y lo restaura
        $producto = Producto::withTrashed()->findOrFail($id);
        $producto->restore();

        return redirect()->route('productos.index')
            ->with('success', 'Producto restaurado correctamente.');
    }
}
