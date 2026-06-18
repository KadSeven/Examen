<?php

namespace App\Exceptions;

use Exception;

class PageExpiredException extends Exception
{
    public function report()
    {
        // Opcional: registrar cuando a los usuarios se les vence la sesión
    }

    public function render($request)
    {
        // Llamamos a la vista del monstruo 419 (el que suspira)
        return response()->view('errors.419', [], 419);
    }
}