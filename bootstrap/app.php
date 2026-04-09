<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (\Throwable $e) {
            // Jangan kirim email untuk error yang wajar seperti 404, validasi, atau belum login
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException || 
                $e instanceof \Illuminate\Validation\ValidationException ||
                $e instanceof \Illuminate\Auth\AuthenticationException) {
                return;
            }

            try {
                // Ganti email_anda@example.com dengan email tujuan Anda
                \Illuminate\Support\Facades\Mail::to('email_anda@example.com')->send(new \App\Mail\ErrorOccurredMail($e));
            } catch (\Throwable $mailException) {
                // Abaikan error pengiriman email agar aplikasi tidak berhenti bekerja (error loop)
            }
        });
    })->create();
