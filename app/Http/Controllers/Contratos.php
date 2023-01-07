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

          return self::PREPARAR($vale, $monto, $plazo, $calle, $colonia, $ciudad, $estado);

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

    public function ACTUALIZACLIENTE($id, $ciudad, $estado, $calle, $colonia){
       try{
          
          $update = DB::table('FATB_Clientes')
                      ->where('FAnv_CveCliente', $id)
                      ->update([
                                'FAnv_Cd' => strtoupper($ciudad),
                                'FAnv_FiscalCd' => strtoupper($ciudad),
                                'FAnv_FiscalColonia' => strtoupper($colonia),
                                'FAnv_DirFiscal' => strtoupper($colonia),
                                'FAnv_Calle' => strtoupper($calle)
                              ]);
          return response()->informacion(true);
       }
       catch(Throwable $e){
         report($e);
         return false;
       }
    }

    public function PREPARAR($vale, $monto, $plazo, $calle, $colonia, $ciudad, $estado){
       try{

          $cliente_id = DB::table("FATB_DistibuidorVales")->where("FAdc_IdVale", $vale)->select("FAin_IdDistri", "FAdc_CveCliente")->first();
          $id = $cliente_id->FAdc_CveCliente;
          $iddistrib = $cliente_id->FAin_IdDistri;

          $cliente = DB::table("FATB_Clientes")->where("FAnv_CveCliente", $id)->select("FAnv_CveCliente", "FAnv_Razon", "FAnv_Nombres", "FAnv_APaterno", 
                                                                                       "FAnv_AMaterno")->first();

          $folio = self::ENCABEZADO($vale, $cliente, $calle, $colonia, $estado, $ciudad, $monto, $plazo, $iddistrib);
          $fech = Carbon::now()->format('Y-m-d');
          $fecha = self::PROP($fech, $plazo);
        
          $indice = 0;
          $seg = DB::table("parametros")->where("idparametro", 1)->select("valor")->first();
          $seguro = $seg->valor;

          for($i = 1; $i <= $plazo; $i++){
              $verif = self::DETALLADO($folio, $vale, $i, $plazo, $monto, $fecha[$indice], $seguro, $iddistrib);
              $indice +=1;
          }
          if($verif === true){
             return self::ACTUALIZACLIENTE($id, $ciudad, $estado, $calle, $colonia);
          }
          else{
             return false;
          }

       }
       catch(Throwable $e){
          report($e);
          return false;
       }
    }

    public function PROP($fecha, $plazo){
       $plan = array();
       $fec = strtotime($fecha);

       if(date("d", $fec) > "01"){
          $fecha = date("Y-m-01", strtotime($fecha."+ 1 month"));
       }

       $index = 1;
       for($i = 0; $i <= $plazo - 1; $i++){
          if($index === 1){
             $plan[$i] = date("Y-m-15", strtotime($fecha));
             $index += 1;
          }
          else{
             $plan[$i] = date("Y-m-t", strtotime($fecha));
             $fecha = date("Y-m-01", strtotime($fecha."+ 1 month"));
             $index = 1;
          }
       }
       return $plan;
    }

    public function ENCABEZADO($vale, $cliente, $calle, $colonia, $estado, $ciudad, $monto, $plazo, $distrib){
       try{
          //SCTB_Contrato
          DB::table("SCTB_Contrato")->insert([
              "CACon_Plaza" => 1,
              "CACon_Nucia" => 1,
              "CACon_Curp" => "",
              "CACon_Tipo" => "M",
              "CACon_TipoCredito" => "M",
              "CACon_Contrato" => $vale,
              "CACon_FecCotiza" => Carbon::now()->format('Y-m-d H:m:s.000'),
              "CACon_FechaContrato" => Carbon::now()->format('Y-m-d H:m:s.000'),
              "CACon_ContratoAnterior" => "",
              "CACon_ContratoSustituye" => "",
              "CACon_CveCliente" => $cliente->FAnv_CveCliente,
              "CACon_Cliente" => $cliente->FAnv_Razon,
              "CACon_APaterno" => $cliente->FAnv_APaterno,
              "CACon_AMaterno" => $cliente->FAnv_AMaterno,
              "CACon_Nombres" => $cliente->FAnv_Nombres,
              "CACon_RFC" => "",
              "CACon_DirFiscal" => strtoupper($calle),
              "CACon_Colonia" => strtoupper($colonia),
              "CACon_Estado" => strtoupper($estado),
              "CACon_Municipio" => strtoupper($ciudad),
              "CACon_Ciudad" => strtoupper($ciudad),
              "CACon_CP" => 0,
              "CACon_Tel" => "",
              "CACon_Correo" => "",
              "CACon_Contacto" => "",
              "CACon_FuenteRecurso" => 1,
              "CACon_Producto" => 7,
              "CACon_Plazo" => 20,
              "CACon_PlazoQuincena" => 20,
              "CACon_PlazoAplicaRen" => 0,
              "CACon_PlazoRenovaAl" => 0,
              "CACon_FechaInicio" => Carbon::now()->format('Y-m-d H:m:s.000'),
              "CACon_FechaPrimerPago" => "",
              "CACon_FechaVencimiento" => "",
              "CACon_ParaInvertir" => "",
              "CACon_Referencia" => "",
              "CACon_Garantias" => "",
              "CACon_Certificado" => "",
              "CACon_Capital" => $monto,
              "CACon_Enganche" => 0,
              "CACon_SaldoBase" => $monto,
              "CACon_CveTasaVar" => 0,
              "CACon_PorIntTotal" => 0,
              "CACon_ValorInteres" => 0,
              "CACon_AccionesAdq" => 0,
              "CACon_ValorAccion" => 0,
              "CACon_ValorAcciones" => 0,
              "CACon_ImporteSeg1" => 28,
              "CACon_ImporteSeg2" => 0,
              "CACon_GastosAdmin" => 0,
              "CACon_ValorOperacion" => $monto,
              "CACon_PagoQuincenal" => round($monto / $plazo),
              "CACon_PorIntMora" => 0,
              "CACon_NoDoctos" => $plazo,
              "CACon_Vencimientos" => $plazo,
              "CACon_ImporteDoctos" => round($monto / $plazo),
              "CACon_Estatus" => "D",
              "CACon_IdAutoriza" => "ADMIN",
              "CACon_FechaAutoriza" => Carbon::now()->format('Y-m-d H:m:s.000'),
              "CACon_Observa" => "",
              "CACon_Id" => "ADMIN",
              "CACon_Fecha" => Carbon::now()->format('Y-m-d H:m:s.000'),
              "CACon_Movtos" => 0,
              "CACon_CtaContable" => "",
              "CACon_CtaIntxDev" => "",
              "CACon_TextoLegal" => "",
              "CACon_porintmoracalculo" => 0,
              "CACon_AnuaNumero" => 0,
              "CACon_AnuaImporte" => 0,
              "CACon_AnuaEmpiezaEn" => 0,
              "CACon_CalculoPlazoendias" => 0,
              "CACon_XSaldosInsolutos" => 0,
              "CACon_CveUni" => "",
              "CACon_TipoPlazo" => "QUINCENAS",
              "CACon_FolioRequisito" => 0,
              "CACon_RequisitoNotas" => "",
              "CACon_ComisionPagoTardio" => 0,
              "CACon_AnalisisElaboro" => "",
              "CACon_AnalisisVoBo" => "",
              "CACon_Comite" => 0,
              "CACon_PreComite" => 0,
              "CACon_AnalisisEmpGene" => 0,
              "CACon_AnalisisEmpFor" => 0,
              "CACon_AnalisisEmpGenFor" => 0,
              "CACon_AnalisisSector" => 0,
              "CACon_MontoAut" => 0,
              "CACon_FolioComite" => 0,
              "CACon_Grupo" => 0,
              "CACon_GrupoID" => 0,
              "CACon_Agente" => "",
              "CACon_CveGaran" => "",
              "CACon_IdDistrib" => $distrib,
              "CACon_IndPagado" => 0,
              "CACon_FecVenci" => NULL,
              "CACon_SaldosAlVenci" => 0,
              "CACon_SinIntereses" => 0,
              "CACon_Saldo" => 0,
              "CACon_TipoAmort" => "",
              "CACon_PlazoDias" => 0,
              "CaCon_CalFijSI" => 0,
              "CaCon_TasaSeg" => 0,
              "CaCon_Cono" => 0,
              "CaCon_CAT" => 0,
              "CACon_ShowCV" => 1,
              "CACon_Fijo" => 0,
              "CACon_ValorEquipo" => 0,
              "CACon_DescEq" => "",
              "CACon_Act" => "",
              "CAConGarantiaL" => 0,
              "CACon_Testigo1" => "",
              "CACon_Testigo2" => "",
              "CACon_ComisionAper" => 0,
              "CA_ConPagoTInicial" => 0,
              "CACon_EnganchePor" => 0,
              "CACon_ContratoPor" => NULL,
              "CACon_tpersona" => "F",
              "CACon_Riesgo" => 0,
              "CACon_Pareja" => NULL,
              "CACon_ValSegAlMillar" => 0,
              "CACON_HM" => NULL,
              "CACon_ConIVA" => 0,
              "CACon_ConSaldosInMayor" => 0,
              "CACon_ConSaldosInIndiv" => 0,
              "CACon_ConCapitalVenci" => 0,
              "CACon_PagosIgualTotal" => 0,
              "CACON_CAPITALREVOLVENTE" => 0,
              "CACON_CAPITALREVOLVENTESUMA" => 0,
              "CACon_DepuradoCirculo" => 0,
              "CACon_Cheque" => "",
              "SEL_COMITE" => 0,
              "CACon_IdComercio" => 130,
              "CACon_SucCanje" => 6,
              "CACon_SeguroMonto" => 0,
              "CACon_SeguroDetalle" => 0,
              "CACon_SeguroBenef" => 0,
              "CACon_SeguroParen" => 0,
              "CACon_SeguroFecNac" => Carbon::now()->format('Y-m-d H:m:s.000'),
              "CACon_CliFecNac" => Carbon::now()->format('Y-m-d H:m:s.000'),
              "CACon_Poliza" => "",
              "CACon_Categoria" => "",
              "CACon_SegAuto" => 0,
              "CACon_Tipo_Vale" => "V",
              "CaCon_Ticket" => 0,
              "CaCon_Abono" => 0,
              "CaCon_FormaCobro" => "VENTA MOSTRADOR",
              "CaCon_CajeroRefer" => "",
              "CaCon_Banco" => "",
              "CaCon_Cuenta" => "",
              "CaCon_Clabe" => "",
              "CACON_EMPNOMBRENOMINA" => "",
              "CACON_EMPTASAINTNOMINA" => 0,
              "CACON_EMPAMORTI_NOMINA" => "",
              "CACON_INTMENSUAL" => 0,
              "CACON_HECTAREAS" => 0,
              "CACON_PORCOMISIONAPER" => 0,
              "CACON_ANUALIDAD" => 0,
              "CACON_FECANUALIDAD" => NULL,
              "CACON_FIEL" => "",
              "CACON_PAISNAc" => "",
              "CACON_nacionalidad" => "",
              "CACON_AUTORIZODISTRIB" => 0,
              "CACON_BENEFICIARIO" => "",
              "CACON_BENEFPARENZCO" => "",
              "CACON_BENEFDIRECCION" => "",
              "CACON_BENEFFECNAC" => "",
              "CACON_IFE" => "",
              "CACON_REF1NOM" => "",
              "CACON_REF2NOM" => "",
              "CACON_REF1TEL" => "",
              "CACON_REF2TEL" => "",
              "CACON_EMPLEO" => "",
              "CACON_SUELDO" => 0,
              "CACON_ANTIGUEDAD" => "",
              "CACON_TELEMPLEO" => "",
              "CACON_DESTINOCRED" => "GASTOS PERSONALES",
              "CACON_STPID" => "",
              "CACON_STPSTATUS" => "",
              "CACON_STPBANCO" => "",
              "Cliente_ZT" => "",
              "Ticket_ZT" => "",
              "Distri_ZT" => ""
          ]);

          $id = DB::table("PRU_Contrato")->where("CACon_Contrato", $vale)->select("CACon_Folio")->first();

          return $id->CACon_Folio;
       }
       catch(Throwable $e){
         report($e);
         return false;
       }
    }

    public function DETALLADO($folio, $vale, $no, $plazo, $monto, $fecha, $seguro, $distrib){
      try{
        $segundo = 0;

        if($no === 1){
          $primer = round($monto / $plazo) + $seguro;
        }
        elseif($no == $plazo){
          for($i = 0; $i <= $plazo - 1; $i++){
            $segundo += round(($monto / $plazo)) - ($monto / $plazo);
          }
          $primer = round(($monto / $plazo)) - $segundo;
          $seguro = 0;
        }
        else{
          $primer = round($monto / $plazo);
          $seguro = 0;
        }

        //SCTB_ContratoDet
        DB::table("SCTB_ContratoDet")->insert([
            "CADet_NuCia" => 1,
            //"CADet_foliodet" => ,
            "CADet_docextra" => "",
            "CADet_Print" => 1,
            "CADet_folio" => $folio,
            "CADet_fechagenera" => Carbon::now()->format('Y-m-d').' 00:00:00.000',
            "CADet_contrato" => $vale,
            "CADet_docno" => $no."/".$plazo,
            "CADet_descrip" => $vale,
            "CADet_Venci" => date("d-m-Y", strtotime($fecha)),
            "CADet_Capital" => round(($monto / $plazo)),
            "CADet_Amortiza" => round(($monto / $plazo)),
            "CADet_MesCurso" => date("d-m-Y", strtotime($fecha)),
            "CADet_DiasTrans" => $plazo,
            "CADet_DiasReales" => 0,
            "CACon_CveTasaVar" => 0,
            "CADet_IntTasa" => 0,
            "CADet_Tasa" => 0,
            "CADet_IntCalculo" => 0,
            "CADet_IntOrd" => 0,
            "CADet_Seguro" => $seguro, //SOLO SI ES EL PRIMERO
            "CADet_ImpDocto" => $primer, //SOLO SI ES EL PRIMERO
            "CADet_DiasMora" => 0,
            "CADet_TasaMora" => 0,
            "CADet_IntxMora" => 0,
            "CADet_BonifInt" => 0,
            "CADet_Abono" => 0,
            "CADet_TotalPago" => $primer, //SOLO SI ES EL PRIMERO
            "CADet_Saldo" => $primer, //SOLO SI ES EL PRIMERO
            "CADet_FechaPago" => "1900-01-01 00:00:00.000",
            "CADet_ReciboSerie" => "",
            "CADet_Recibo" => 0,
            "CARec_cveuni" => "",
            "CADet_Id" => "ADMIN",
            "CADet_fecha" => Carbon::now()->format('Y-m-d H:m:s.000'),
            "CADet_CveUni" => "",
            "CADet_IvaInteres" => 0,
            "CADet_ShowCV" => 1,
            "SELCEL" => 0,
            "CADet_Pagointeres" => 0,
            "CADet_PagoSeguro" => 0,
            "CADet_PagoCapital" => 0,
            "CaDet_FactInteres" => 0,
            "CaDet_FecFactura" => NULL,
            "CADet_SaldoCapital" => 0,
            "CADet_SaldoInteres" => 0,
            "CADet_VenciDocto" => Carbon::now()->format('Y-m-d H:m:s.000'),
            "CADet_SaldoSeg" => 0,
            "CaDet_PAInt" => NULL,
            "CADet_AbonoCapital" => 0,
            "CADet_AbonoSeg" => 0,
            "CADet_AbonoInteres" => 0,
            "SEL" => 0,
            "CADet_IvaMora" => 0,
            "CADet_IntEmp" => 0,
            "CADet_IntDis" => 0,
            "CADet_IntPor" => 0,
            "CaDet_Producto" => 7,
            "CaDet_Distr" => $distrib,
            "CADet_SeguroAbono" => 0,
            "CADet_SeguroSaldo" => 0,
            "CADet_Invest" => 0,
            "CADet_Admon" => 0,
            "CADet_SegAuto" => 0,
            "CaDet_Comercio" => 130,
            "CADET_Ministracion" => 0,
            "CADET_SALDOAFAVOR" => 0,
            "cadet_fechanew" => NULL,
            "Ticket_ZT" => ""
        ]);

        return true;
      }
      catch(Throwable $e){
        report($e);
        return false;
      }
    }

}