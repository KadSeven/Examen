<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\Metodo_pagoController;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/about', function () {
//     return 'Acerca de nosotros';
// }); 

// Route::get('/user/{id}', function ($id) {
//     return 'ID de usuario: ' . $id;
// }); 

// Route::get('/contacto', function () {
//     return 'Página de contacto';
// })->name('contacto');

// Route::get('/user/{id}', function ($id) {
//      return 'ID de usuario: ' . $id;
// })->where('id', '[0-9]{3}');

// Route::prefix('admin')->group(function () {
//     Route::get('/', function () {
//     return 'Panel de administración';
//     });
//     Route::get('/users', function () {
//     return 'Lista de usuarios';
// });
// });

use App\Exceptions\NotFoundHttpException;

Route::get('/errors/404', function () {
    throw new NotFoundHttpException();
});

Route::get('/errors/403', function () {
    abort(403);
});

Route::get('/errors/500', function () {
    abort(500);
});

Route::get('/errors/419', function () {
    abort(419);
});

Route::middleware(['auth'])->group(function () { 

    //PANEL DE CONTROL
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //PARAMETROS
    // Ruta para ver la papelera de productos
    Route::get('productos/papelera', [ProductoController::class, 'papelera'])->name('productos.papelera');
    // Ruta para restaurar el producto
    Route::post('productos/{id}/restaurar', [ProductoController::class, 'restaurar'])->name('productos.restaurar');
    Route::resource('productos', ProductoController::class); //resorce significaque tiene los 7 metodos y luego e va y busca la funcion index del controllador en este caso Producto controller 
    
    // Ruta para ver la lista de clientes eliminados
    Route::get('clientes/papelera', [ClienteController::class, 'papelera'])->name('clientes.papelera');
    // Ruta para restaurar al cliente
    Route::post('clientes/{id}/restaurar', [ClienteController::class, 'restaurar'])->name('clientes.restaurar');
    Route::resource('clientes', ClienteController::class);

    Route::get('pagos/papelera', [PagoController::class, 'papelera'])->name('pagos.papelera');
    Route::post('pagos/{id}/restaurar', [PagoController::class, 'restaurar'])->name('pagos.restaurar');
    Route::resource('pagos', PagoController::class);

    Route::get('facturas/papelera', [FacturaController::class, 'papelera'])->name('facturas.papelera');
    Route::post('facturas/{id}/restaurar', [FacturaController::class, 'restaurar'])->name('facturas.restaurar');

    // Ruta para descargar el reporte Excel de todas las facturas registradas
    Route::get('facturas/exportar-excel-general', [\App\Http\Controllers\FacturaController::class, 'exportarExcelGeneral'])
        ->name('facturas.excelgeneral'); 
        
    Route::resource('facturas', FacturaController::class);
    Route::get('facturas/imprimirfactura/{id}', [FacturaController::class, 'imprimirfactura'])
    ->name('facturas.imprimirfactura');
    

    Route::get('metodo_pagos/papelera', [Metodo_pagoController::class, 'papelera'])
    ->name('metodo_pagos.papelera');
Route::post('metodo_pagos/{id}/restaurar', [Metodo_pagoController::class, 'restaurar'])
    ->name('metodo_pagos.restaurar');
    Route::resource('metodo_pagos', Metodo_pagoController::class);

    Route::get('cambioestadoproducto', [ProductoController::class, 'cambioestadoproducto'])->name('cambioestadoproducto');
    Route::get('cambioestadocliente', [ClienteController::class, 'cambioestadocliente'])->name('cambioestadocliente');
    Route::get('cambioestadofactura', [FacturaController::class, 'cambioestadofactura'])->name('cambioestadofactura');
    Route::get('cambioestadometodopago', [Metodo_pagoController::class, 'cambioestadometodopago'])->name('cambioestadometodopago');
});