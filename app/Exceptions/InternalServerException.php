<?php

namespace App\Exceptions;

use Exception;

class InternalServerException extends Exception
{
    public function report()
    {
        // Los errores 500 son importantes, aquí Laravel suele guardarlos en los logs automáticamente
    }

    public function render($request)
    {
        // Llamamos a la vista del monstruo 500 que configuramos
        return response()->view('errors.500', [], 500);
    }
}