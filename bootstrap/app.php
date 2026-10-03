<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, Throwable $e, Request $request) {
            $status = $response->getStatusCode();
            if ($request->expectsJson() || $status < 400 || ($status === 500 && config('app.debug'))) {
                return $response;
            }

            try {
                $headers = array_intersect_key(
                    $response->headers->all(),
                    array_flip(['retry-after', 'allow'])
                );

                return response()->view('components.errors.error', ['status' => $status], $status, $headers);
            } catch (Throwable) {
                report($th);  
                return $response;
            }
        });
    })->create();