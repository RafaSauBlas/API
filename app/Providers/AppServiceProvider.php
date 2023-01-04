<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Respuesta de error
        Response::macro('error', function ($value) {
            return response()->json(["respuesta" => ["error" => $value], "timestamp" =>  Carbon::now()->toDateTimeString()]);
        });

        //Respuesta de información
        Response::macro('informacion', function ($value) {
            return response()->json(["respuesta" => ["valido" => $value], "timestamp" => Carbon::now()->toDateTimeString()]);
        });

        //Respuesta Quincenas
        Response::macro('respuesta', function ($value, $cargo) {
            return response()->json(["respuesta" =>  ["parrilla" => $value, "cargoadmin" => $cargo], "timestamp" => Carbon::now()->toDateTimeString()]);
        });
    }
}
