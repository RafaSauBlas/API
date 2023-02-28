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
               $val = DB::table("FATB_DistibuidorVales")->where("FAdc_IdVale", $vale)->select("FAdc_Importe", "FAdc_Saldo")->first();
               $saldo = round($val->FAdc_Saldo);
               $importe = round($val->FAdc_Importe);

               if($saldo > 0){
                $valor = $saldo;
              }
              else{
                $valor = $importe;
              }
            }
            else{
              return response()->valores("El parametro 'vale' no contiene un valor asignado.");
            }
          }
          else{
            return response()->parametros("La petición no contiene el parametro 'vale'.");
          }

        if($request->has("monto")){
            
            //Verificamos que el parametro "Vale" no esté vacio
            if($request->filled("monto")){
                $monto =  round($request->monto);
                $quincena = DB::table("Quincenas")->where("valorini", "<=", $monto)
                                                  ->where("valorfin", ">=", $monto)->select("idquincenas")->first();
                if($quincena === null){
                  return response()->sobrepaso("El monto ingresado sobrepasa el monto maximo por quincenas.");
                }
                else{
                  $quincenaid = $quincena->idquincenas;
                }

                $quincenas = DB::table("Quincenasdet")->where("idquincena", $quincenaid)->select("plazo")->get();
                $plazos = array();

                for($contador = 0; $contador<$quincenas->count(); $contador++){
	               $quincena = $quincenas[$contador]->plazo;

                   $fact = DB::table("Factor")->where("plazo", $quincena)->select("factor")->get();
                   $subt = (($monto / $quincena) * $fact[0]->factor);
                   $tot = ($quincena * $subt);

                   if($tot <= $valor){
                     $valores = ["pagos" => $quincena, "monto" => round($subt, 2), "total" => round($tot, 2)];
                     $plazos[$contador] = $valores;
                   }
                }
                $admin = DB::table("parametros")->where("idparametro", 1)->select("valor")->first();
                $cargo = $admin->valor;
                if(count($plazos) < 1){
                  return response()->sinsaldo(false, "Saldo insuficiente.");
                }
                else{
                  return response()->respuesta($plazos, $cargo);
                }
            }
            else{
              return response()->valores("El parametro 'monto' no contiene un valor asignado.");
            }
          }
          else{
            return response()->parametros("La petición no contiene el parametro 'monto'.");
          }

       }
       catch(Throwable $e){
          report($e);
          return false;
       }
    }
}
