<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
// Importamos las excepciones originales de Laravel/Symfony para compararlas
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as LaravelNotFound;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException as LaravelAccessDenied;
use Illuminate\Session\TokenMismatchException as LaravelTokenMismatch;

class Handler extends ExceptionHandler
{
    /**
     * Lista de entradas que no se guardan en la sesión durante excepciones de validación.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registro de los callbacks de manejo de excepciones.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {
            
            // Solo activamos nuestras vistas si el modo DEBUG está en false
            if (!config('app.debug')) {

                // 1. Si es un Error 404
                if ($e instanceof LaravelNotFound) {
                    throw new \App\Exceptions\NotFoundHttpException;
                }

                // 2. Si es un Error 403
                else if ($e instanceof LaravelAccessDenied) {
                    throw new \App\Exceptions\AccessDeniedHttpException;
                }

                // 3. Si es un Error 419 (Token vencido)
                else if ($e instanceof LaravelTokenMismatch) {
                    throw new \App\Exceptions\PageExpiredException;
                }

                // 4. Para cualquier otro error (500)
                // Usamos una excepción general para capturar fallos de BD o código
                throw new \App\Exceptions\InternalServerException;
            }
        });
    }
}