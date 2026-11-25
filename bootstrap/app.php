<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'super_admin' => \App\Http\Middleware\EnsureUserIsSuperAdmin::class,
            'active' => \App\Http\Middleware\EnsureAccountIsActive::class,
            'password.fresh' => \App\Http\Middleware\EnsurePasswordIsChanged::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return null;
            }

            // Sesi berakhir saat form dikirim: kembali ke halaman login
            if ($e->getStatusCode() === 419) {
                return redirect()->route('login');
            }

            // Terlalu banyak percobaan: kembali ke form dengan pesan
            if ($e->getStatusCode() === 429) {
                return back()
                    ->withInput($request->except('password'))
                    ->withErrors(['email' => 'Terlalu banyak percobaan. Silakan coba lagi beberapa menit lagi.']);
            }

            return null;
        });
    })->create();