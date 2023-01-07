<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nullix\CryptoJsAes\CryptoJsAes;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class Control extends Controller
{
    public function TRAER_LIMITE(Request $request){
        try{

            if($request->has("monto")){
                //Verificamos que el parametro no esté vacio
                if($request->filled("monto")){
                   return true;
                }
                else{
                   return response()->error("El parametro 'monto' no contiene un valor asignado.");
                }
             }
             else{
                return response()->error("La petición no contiene el parametro 'monto'.");
             }

            $limites1 = DB::table("Quincenas")->where("idquincenas", 1)->select("valorini")->first();
            $limites2 = DB::table("Quincenas")->where("idquincenas", 15)->select("valorfin")->first();
            $lim1 = $limites1->valorini;
            $lim2 = $limites2->valorfin;

            if($request->monto >= $lim1 && $request->monto <= $lim2){
                return response()->informacion(true);
            }
            else{
                return response()->informacion(false);
            }
        }
        catch(Throwable $e){
          report($e);
          return false;
        }
     }
}
