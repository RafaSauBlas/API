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
    public function VERIFICAR(Request $request){
      try{

        //Verificamos que la petición contenga el parametro "Vale"
        if($request->has("vale")){
          //Verificamos que el parametro "Vale" no esté vacio
          if($request->filled("vale")){
            //Validamos que el folio tenga el formato correcto
            if(substr($request->vale, 0, 2) === "VE" || substr($request->vale, 0, 2) === "ve" && Str::of($request->vale)->length() === 8){
              $vale = $request->vale;
            }
            else{
              return response()->error("El folio introducido no es un folio valido.");
            }
          }
          else{
            return response()->error("El parametro 'vale' no contiene un valor asignado.");
          }
        }
        else{
          return response()->error("La petición no contiene el parametro 'vale'.");
        }

        //Verificamos que la petición contenga el parametro "Fecha"
        if($request->has("fecha")){
          //Verificamos que el parametro "Vale" no esté vacio
          if($request->filled("fecha")){
            $fecha = $request->fecha;
          }
          else{
            return response()->error("El parametro 'fecha' no contiene un valor asignado.");
          }
        }
        else{
          return response()->error("La petición no contiene el parametro 'fecha'.");
        }

        //Verificamos que la petición contenga el parametro "Importe"
        if($request->has("importe")){
          //Verificamos que el parametro "Importe" no esté vacio
          if($request->filled("importe")){
            $importe = $request->importe;
          }
          else{
            return response()->error("El parametro 'importe' no contiene un valor asignado.");
          }
        }
        else{
          return response()->error("La petición no contiene el parametro 'importe'.");
        }


        //Traemos el registro que coincida con el folio introducido
        $exist = DB::table("FATB_DistibuidorVales")->where("FAdc_IdVale", $vale)->select("FAdc_IdVale", "FAdc_Saldo", "FAdt_Fecha", "FAin_IdDistri")->first();

        //Validamos que exista algun registro con este folio
        if($exist === null){
          return response()->informacion(false);
        }
        else{
          $id = $exist->FAin_IdDistri;

          $disponible = self::CalcularDisponible($id);

          //Validamos la vigencia del vale (Se le suman 30 dias a la fecha en la que se generó el vale)
            if(date("Y/m/d", strtotime($fecha)) >= date("Y/m/d", strtotime($exist->FAdt_Fecha)) &&
               date("Y/m/d", strtotime($fecha)) <= date("Y/m/d", strtotime($exist->FAdt_Fecha."+ 30 days")) && $importe <= $disponible){
               return response()->informacion(true);
            }
            else{
              return response()->informacion(false);
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
