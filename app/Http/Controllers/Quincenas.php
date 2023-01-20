<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nullix\CryptoJsAes\CryptoJsAes;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Throwable;

class Quincenas extends Controller
{
    public function SHOW(Request $request){
       try{

         if($request->has("vale")){
            
            //Verificamos que el parametro "Vale" no esté vacio
            if($request->filled("vale")){
               $vale = $request->vale;
               $val = DB::table("FATB_DistibuidorVales")->where("FAdc_IdVale", $vale)->select("FAdc_Saldo")->first();
               $disponible = $val->FAdc_Saldo;
            }
            else{
              return response()->error("El parametro 'vale' no contiene un valor asignado.");
            }
          }
          else{
            return response()->error("La petición no contiene el parametro 'vale'.");
          }

        if($request->has("monto")){
            
            //Verificamos que el parametro "Vale" no esté vacio
            if($request->filled("monto")){
                $monto =  round($request->monto);
                $quincena = DB::table("Quincenas")->where("valorini", "<=", $monto)
                                                  ->where("valorfin", ">=", $monto)->select("idquincenas")->first();

                $quincenaid = $quincena->idquincenas;

                $quincenas = DB::table("Quincenasdet")->where("idquincena", $quincenaid)->select("plazo")->get();
                $plazos = array();

                for($contador = 0; $contador<$quincenas->count(); $contador++){
	               $quincena = $quincenas[$contador]->plazo;

                   $fact = DB::table("Factor")->where("plazo", $quincena)->select("factor")->get();
                   $subt = (($monto / $quincena) * $fact[0]->factor);
                   $tot = ($quincena * $subt);

                   if($tot <= $disponible){
                     $valores = ["pagos" => $quincena, "monto" => round($subt, 2), "total" => round($tot, 2)];
                     $plazos[$contador] = $valores;
                   }
                }
                $admin = DB::table("parametros")->where("idparametro", 1)->select("valor")->first();
                $cargo = $admin->valor;

                return response()->respuesta($plazos, $cargo);
            }
            else{
              return response()->error("El parametro 'monto' no contiene un valor asignado.");
            }
          }
          else{
            return response()->error("La petición no contiene el parametro 'monto'.");
          }

       }
       catch(Throwable $e){
          report($e);
          return false;
       }
    }
}
