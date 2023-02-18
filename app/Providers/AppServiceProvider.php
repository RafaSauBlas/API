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

        //Respuesta exitosa (200)
        Response::macro('buena', function($valor){
            return Response::json(["respuesta" => ["valido" => $valor], "timestamp" => Carbon::now()->toDateTimeString()], 200);
        });

        //Parametros sin valor (210)
        Response::macro('valores', function($valor){
            return Response::json(["respuesta" => ["error" => $valor], "timestamp" => Carbon::now()->toDateTimeString()], 210);
        });

        //Respuesta de Saldos insuficientes (211)
        Response::macro('sinsaldo', function ($value, $causa) {
            return Response::json(["respuesta" => ["valido" => $value, "razon" => $causa], "timestamp" => Carbon::now()->toDateTimeString()], 211);
        });

        //Respuesta de vale vencido (212)
        Response::macro('vencido', function ($valor, $causa) {
            return Response::json(["respuesta" => ["valido" => $valor, "razon" => $causa], "timestamp" => Carbon::now()->toDateTimeString()], 212);
        });

        //Parametros faltantes (400)
        Response::macro('parametros', function($valor){
            return Response::json(["respuesta" => ["error" => $valor], "timestamp" => Carbon::now()->toDateTimeString()], 400);
        });

        //Valor inexistente o invalido (404)
        Response::macro('invalido', function($valor){
            return Response::json(["respuesta" => ["error" => $valor], "timestamp" => Carbon::now()->toDateTimeString()], 404);
        });

        




        //****************************************************************************************************************************************/
        //Respuesta de error
        Response::macro('error', function ($value, $codigo) {
            return response($codigo)->json(["respuesta" => ["error" => $value], "timestamp" =>  Carbon::now()->toDateTimeString()]);
        });

        //Respuesta de información
        Response::macro('informacion', function ($value) {
            return response()->json(["respuesta" => ["valido" => $value], "timestamp" => Carbon::now()->toDateTimeString()]);
        });

        //Respuesta Quincenas
        Response::macro('respuesta', function ($value, $cargo) {
            return Response::json(["respuesta" =>  ["parrilla" => $value, "cargoadmin" => $cargo], "timestamp" => Carbon::now()->toDateTimeString()]);
        });
    }
}
