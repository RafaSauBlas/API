<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Nullix\CryptoJsAes\CryptoJsAes;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Throwable;

class ValesDigital extends Controller
{
  /*
    ----- PARAMETROS REQUERIDOS -----
    vale
    cuentap
    fecha
    importe
  */

    public function TRAER_LIMITE(Request $request){
      try{

        if($request->has("importe")){
            //Verificamos que el parametro no esté vacio
            if($request->filled("importe")){
               $monto = $request->importe;
            }
            else{
               return response()->valores("El parametro 'importe' no contiene un valor asignado.");
            }
         }
         else{
            return response()->parametros("La petición no contiene el parametro 'importe'.");
         }

        $limites1 = DB::table("Quincenas")->where("idquincenas", 1)->select("valorini")->first();
        $limites2 = DB::table("Quincenas")->where("idquincenas", 15)->select("valorfin")->first();
        $lim1 = $limites1->valorini;
        $lim2 = $limites2->valorfin;

        if($monto >= $lim1 && $monto <= $lim2){
            return self::VERIFICAR($request);
        }
        else{
          return response()->sinsaldo(false, "Saldo insuficiente");
        }
      }
      catch(Throwable $e){
        report($e);
        return false;
      }
    }

    public function VERIFICAR($request){
      try{

        //Verificamos que la petición contenga el parametro "Vale"
        if($request->has("vale")){
          //Verificamos que el parametro "Vale" no esté vacio
          if($request->filled("vale")){
            //Validamos que el folio tenga el formato correcto
            if(substr($request->vale, 0, 2) === "VE" || substr($request->vale, 0, 2) === "ve" && Str::of($request->vale)->length() === 8){
              $vale = $request->vale;
              $tipo = 1;
            }
            else{
              return response()->invalido("El folio introducido no es un folio valido.");
            }
          }
          else{
            
            if($request->has("cuentap")){
              if($request->filled("cuentap")){

                if(substr($request->cuentap, 0, 2) === "TC" || substr($request->cuentap, 0, 2) === "tc" && Str::of($request->cuentap)->length() === 8){
                  $vale = $request->cuentap;
                  $tipo = 2;
                }
                else{
                  return response()->invalido("El folio introducido no es un folio valido.");
                }

              }
              else{
                return response()->valores("El parametro 'cuentap' no contiene un valor asignado.");
              }
            }
            else{
              return response()->parametros("La petición no contiene el parametro 'cuentap'.");
            }

          }
        }
        else{
          return response()->parametros("La petición no contiene el parametro 'vale'.");
        }

        if($tipo == 1){
          //Verificamos que la petición contenga el parametro "Fecha"
          if($request->has("fecha")){
            //Verificamos que el parametro "Vale" no esté vacio
            if($request->filled("fecha")){
              $fecha = $request->fecha;
            }
            else{
              return response()->valores("El parametro 'fecha' no contiene un valor asignado.");
            }
          }
          else{
            return response()->parametros("La petición no contiene el parametro 'fecha'.");
          }
        }

        //Verificamos que la petición contenga el parametro "Importe"
        if($request->has("importe")){
          //Verificamos que el parametro "Importe" no esté vacio
          if($request->filled("importe")){
            $importe = $request->importe;
          }
          else{
            return response()->valores("El parametro 'importe' no contiene un valor asignado.");
          }
        }
        else{
          return response()->parametros("La petición no contiene el parametro 'importe'.");
        }


        //Traemos el registro que coincida con el folio introducido
        $exist = DB::table("FATB_DistibuidorVales")->where("FAdc_IdVale", $vale)->select("FAdc_IdVale", "FAdc_Saldo", "FAdt_Fecha", "FAin_IdDistri")->first();

        //Validamos que exista algun registro con este folio
        if($exist === null){
          return response()->invalido("El folio que introdujo no existe, verifique el folio e intente nuevamente.");
        }
        else{
          $id = $exist->FAin_IdDistri;

          $disponible = self::CalcularDisponible($id);

          //Validamos que tipo de cuenta es, si el tipo de cuenta es 1(Vale) se valida la fecha de vencimiento, si la cuenta es tipo 2(credito personal) se salta esa validación
          if($tipo == 1){
            //Validamos la vigencia del vale (Se le suman 30 dias a la fecha en la que se generó el vale)
            if(date("Y/m/d", strtotime($fecha)) >= date("Y/m/d", strtotime($exist->FAdt_Fecha)) &&
               date("Y/m/d", strtotime($fecha)) <= date("Y/m/d", strtotime($exist->FAdt_Fecha."+ 30 days")) && $importe <= $disponible){
               return response()->buena(true);
            }
            else{
              return response()->vencido(false, "Vale expirado.");
            }
          }
          else{
            if($importe <= $disponible){
               return response()->buena(true);
            }
            else{
              return response()->sinsaldo(false, "Saldo insuficiente");
            }
          }
            

        }

      }
      catch(Throwable $e){
        report($e);
        return false;
      }
    }

    //Funcion para calcular el saldo disponible del distribuidor
    public function CalcularDisponible($id){
      try{

        $distrib = DB::table("FATB_Distibuidor")->where("FAin_Id", $id)->select("FAdc_LineaCreditoVale")->first();

        if($distrib->FAdc_LineaCreditoVale > 0){
          $lineacredito = $distrib->FAdc_LineaCreditoVale;

          $datos = DB::table("FATB_Distibuidor")
                      ->join("FATB_DistibuidorVales", "FATB_Distibuidor.FAin_Id", "=", "FATB_DistibuidorVales.FAin_IdDistri")
                      ->where("FAin_Id", $id)
                      ->select("FAdc_IdVale", "FAdc_Saldo")->get();

          $saldos = $datos->sum("FAdc_Saldo");


          if($lineacredito < $saldos){
            return 0;
          }
          else{
            $disponible = $lineacredito - $saldos;
            return $disponible;
          }

        }
        else{
          return 0;
        }

      }
      catch(Throwable $e){
        return $e;
      }
    }
}
