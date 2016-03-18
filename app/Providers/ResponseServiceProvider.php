<?php

namespace App\Providers;

use Response;

use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($code = NULL, $message = NULL) {
            return Response::json([
                'status'  => 'success',
                'code'    => $code,
                'message' => $message,
            ]);
        });

        Response::macro('error', function ($code, $message) {
            return Response::json([
                'status'  => 'error',
                'code'    => $code,
                'message' => $message,
            ]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
