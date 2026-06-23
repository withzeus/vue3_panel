<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\SetLocale;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Inertia\Inertia;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(
            append: [
                SetLocale::class,
                HandleInertiaRequests::class,
            ]
        );

        $middleware->redirectTo(
            guests: '/login',
            users: '/dashboard'
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
        $exceptions->respond(function ($response, Throwable $exception, Request $request) {
            if ($response->getStatusCode() === 404 && ! $request->expectsJson()) {
                return Inertia::render('Errors/NotFound', [
                    'translations' => [
                        'actions' => __('actions'),
                        'labels' => __('labels'),
                        'pages' => __('pages'),
                    ],
                ])->toResponse($request)->setStatusCode(404);
            }
            if (in_array($response->getStatusCode(), [403]) || $exception instanceof AuthorizationException) {
                if ($request->expectsJson() && ! $request->header('X-Inertia')) {
                    return response()->json([
                        'message' => 'This action is unauthorized.',
                    ], 403);
                }

                return Inertia::render('Errors/Unauthorized')
                    ->toResponse($request)
                    ->setStatusCode(403);
            }

            return $response;
        });
    })->create();
