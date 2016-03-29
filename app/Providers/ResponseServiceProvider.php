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
        Response::macro('success', function ($status = 200, $message = NULL) {
            switch ($status) {
                case 200:
                    $message = ($message == NULL) ? 'OK' : $message;
                    break;
                case 201:
                    $message = ($message == NULL) ? 'Created' : $message;
                    break;
                case 204:
                    $message = ($message == NULL) ? 'No Content' : $message;
                    break;
            }

            return Response::json([
                'status'  => $status,
                'message' => $message,
            ]);
        });

        Response::macro('error', function ($status = 500, $message = NULL) {
            switch ($status) {
                case 400:
                    $message = ($message == NULL) ? 'Bad Request' : $message;
                    break;
                case 401:
                    $message = ($message == NULL) ? 'Unauthorized' : $message;
                    break;
                case 403:
                    $message = ($message == NULL) ? 'Forbidden' : $message;
                    break;
                case 404:
                    $message = ($message == NULL) ? 'Not Found' : $message;
                    break;
                case 405:
                    $message = ($message == NULL) ? 'Method Not Allowed' : $message;
                    break;
                case 409:
                    $message = ($message == NULL) ? 'Conflict' : $message;
                    break;
                case 500:
                    $message = ($message == NULL) ? 'Internal Server Error' : $message;
                    break;
            }

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
