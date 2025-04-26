<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;
use Illuminate\Support\Arr;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'message' => 'Tidak terotentikasi',
                    ], 401);
                }

                if ($e instanceof AccessDeniedHttpException) {
                    return response()->json([
                        'message' => 'Akses ditolak',
                    ], 403);
                }

                if ($e instanceof ValidationException) {
                    return response()->json([
                        'message' => 'Data yang diberikan tidak valid',
                        'errors' => $e->errors(),
                    ], 422);
                }

                if ($e instanceof TokenMismatchException) {
                    return response()->json([
                        'message' => 'Sesi telah kedaluwarsa',
                    ], 419);
                }

                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'message' => 'Halaman atau data tidak ditemukan',
                    ], 404);
                }

                return response()->json([
                    'message' => 'Terjadi kesalahan pada server',
                ], 500);
            }

            // Handle web requests
            if ($e instanceof AuthenticationException) {
                return response()->view('errors.401', [], 401);
            }

            if ($e instanceof AccessDeniedHttpException) {
                return response()->view('errors.403', [], 403);
            }

            if ($e instanceof TokenMismatchException) {
                return response()->view('errors.419', [], 419);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->view('errors.404', [], 404);
            }

            if (!config('app.debug')) {
                return response()->view('errors.500', [], 500);
            }
        });
    }
}
