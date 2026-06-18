<?php

namespace App\Exceptions;

use Exception;

class AccessDeniedHttpException extends Exception
{
    public function report()
    {
        // Aquí podrías registrar el error en logs si quisieras
    }

    public function render($request)
    {
        // Aquí llamamos a la vista del monstruo 403 que creamos
        return response()->view('errors.403', [], 403);
    }
}