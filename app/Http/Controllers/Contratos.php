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

class Contratos extends Controller
{
    public function PRIMER(Request $request){
       try{

          //Verificamos que la petición contenga el parametro "Vale"
          if(self::VALIDARPARAM($request, "vale") === true){
            $vale = $request->vale;
          }
          else{
            return self::VALIDARPARAM($request, "vale");
          }

          //Verificamos que la petición contenga el parametro "Monto"
          if(self::VALIDARPARAM($request, "monto") === true){
            $monto = $request->monto;
          }
          else{
            return self::VALIDARPARAM($request, "monto");
          }

          //Verificamos que la petición contenga el parametro "Plazo"
          if(self::VALIDARPARAM($request, "plazo") === true){
            $plazo = $request->plazo;
          }
          else{
            return self::VALIDARPARAM($request, "plazo");
          }

          //Verificamos que la petición contenga el parametro "Calle"
          if(self::VALIDARPARAM($request, "calle") === true){
            $calle = $request->calle;
          }
          else{
            return self::VALIDARPARAM($request, "calle");
          }

          //Verificamos que la petición contenga el parametro "Colonia"
          if(self::VALIDARPARAM($request, "colonia") === true){
            $colonia = $request->colonia;
          }
          else{
            return self::VALIDARPARAM($request, "colonia");
          }

          //Verificamos que la petición contenga el parametro "Ciudad"
          if(self::VALIDARPARAM($request, "ciudad") === true){
            $ciudad = $request->ciudad;
          }
          else{
            return self::VALIDARPARAM($request, "ciudad");
          }

          //Verificamos que la petición contenga el parametro "Estado"
          if(self::VALIDARPARAM($request, "estado") === true){
            $estado = $request->estado;
          }
          else{
            return self::VALIDARPARAM($request, "estado");
          }

          //return $vale." - ".$monto." - ".$plazo." - ".$calle." - ".$colonia." - ".$ciudad." - ".$estado;
          //return self::GENERA_LIMITE("2023/01/03", 6);
          return self::TRAERCLIENTE($vale);

       }
       catch(Throwable $e){
          report($e);
          return false;
       }
    }

    public function VALIDARPARAM(Request $request, $campo){
       try{
        //Verificamos que la peticion contega el parametro
        if($request->has($campo)){
            //Verificamos que el parametro no esté vacio
            if($request->filled($campo)){
              return true;
            }
            else{
              return response()->error("El parametro '".$campo."' no contiene un valor asignado.");
            }
          }
          else{
            return response()->error("La petición no contiene el parametro '".$campo."'.");
          }
  
       }
       catch(Throwable $e){
          report($e);
          return false;
       }
    }

    public function GENERA_LIMITE($fecha, $rango){
       try{
         $i = 1;
         $fec = $fecha;
         
         while($i <= $rango){

            $fecha = $fecha." - ".date("Y/m/d", strtotime($fec."+ 15 days"));
            $i++;
            $fec = date("Y/m/d", strtotime($fec."+ 15 days"));
         }
         return $fecha;
       }
       catch(Throwable $e){
         report($e);
         return false;
       }
    }

    public function ACTUALIZACLIENTE($id, $ciudad, $estado, $calle, $colonia){
       try{
          
          $update = DB::table('FATB_Clientes')
                      ->where('FAdc_CveCliente', $id)
                      ->update([
                                'FAnv_Cd' => $ciudad,
                                'FAnv_FiscalCd' => $ciudad,
                                'FAnv_FiscalColonia' => $colonia,
                                'FAnv_DirFiscal' => $colonia,
                                'FAnv_Calle' => $calle
                              ]);
         return true;

       }
       catch(Throwable $e){
         report($e);
         return false;
       }
    }

    public function TRAERCLIENTE($vale){
       try{
        $cliente = DB::table("FATB_DistibuidorVales")->where("FAdc_IdVale", $vale)->select("FAdc_CveCliente")->first();
        return $cliente->FAdc_CveCliente;
       }
       catch(Throwable $e){
          report($e);
          return false;
       }
    }

}