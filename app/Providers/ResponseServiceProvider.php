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
        Response::macro('success', function ($status = 200, $message = 'OK') {
            return Response::json([
                'status'  => $status,
                'message' => $message,
            ]);
        });

        Response::macro('error', function ($status = 500, $message = 'Internal Server Error') {
            return Response::json([
                'status'  => $status,
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
