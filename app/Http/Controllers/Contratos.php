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

    public function ENCABEZADO($vale){
       try{

          DB::table("SCTB_Contrato")->insert([
              "CACon_Plaza" => 1,
              "CACon_Nucia" => 1,
              // "CACon_Folio" => 1,
              "CACon_Curp" => "",
              "CACon_Tipo" => "M",
              "CACon_TipoCredito" => "M",
              "CACon_Contrato" => $vale,
              "CACon_FecCotiza" => Carbon::now()->format('Y-m-d').'T00:00:00.000',
              "CACon_FechaContrato" => Carbon::now()->format('Y-m-d').'T00:00:00.000',
              "CACon_ContratoAnterior" => "",
              "CACon_ContratoSustituye" => "",
              "CACon_CveCliente" => $cliente,
              "CACon_Cliente" => $clientenombre,
              "CACon_APaterno" => $clienteapaterno,
              "CACon_AMaterno" => $clienteamaterno,
              "CACon_Nombres" => $clientenombre,
              "CACon_RFC" => "",
              "CACon_DirFiscal" => $calle,
              "CACon_Colonia" => $colonia,
              "CACon_Estado" => $estado,
              "CACon_Municipio" => $ciudad,
              "CACon_Ciudad" => $ciudad,
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
              "CACon_FechaInicio" => Carbon::now()->format('Y-m-d').'T00:00:00.000',
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
              "CACon_ValorOperacion" => $importe,
              "CACon_PagoQuincenal" => ($importe / $nopagos),
              "CACon_PorIntMora" => 0,
              "CACon_NoDoctos" => $nopagos,
              "CACon_Vencimientos" => $nopagos,
              "CACon_ImporteDoctos" => ($importe / $nopagos),
              "CACon_Estatus" => "D",
              "CACon_IdAutoriza" => "ADMIN",
              "CACon_FechaAutoriza" => Carbon::now()->format('Y-m-d').'T00:00:00.000',
              "CACon_Observa" => "",
              "CACon_Id" => "ADMIN",
              "CACon_Fecha" => Carbon::now()->format('Y-m-d').'T00:00:00.000',
              "CACon_Movtos" => 0,
              "CACon_CtaContable" => "",
              "CACon_CtaIntxDev" => "",
              "CACon_TextoLegal" => "",
              "CACon_porintmoracalculo" => 0,
              "CACon_AnuaNumero" => 0,
              "CACon_Anualimporte" => 0,
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
              "CACon_IndPago" => 0,
              "CACon_FecVenci" => "NULL",
              "CACon_SaldosAlVenci" => 0,
              "CACon_SinIntereses" => 0,
              "CACon_Saldo" => 0,
              "CACon_TipoAmort" => "",
              "CACon_PlazoDias" => 0,
              "CaCon_CalFijSI" => 0,
              "CaCon_Cono" => 0,
              "CaCon_CAT" => 0,
              "CACon_ShowCV" => 1,
              "CACon_Fijo" => 0,
              "CACon_ValorEquipo" => 0,
              "CACon_DescEq" => "",
              "CACon_Act" => "",
              "CACon_GarantiaL" => 0,
              "CACon_Testigo1" => "",
              "CACon_Testigo2" => "",
              "CACon_ComisionAper" => 0,
              "CA_ConPagoTInicial" => 0,
              "CACon_EnganchePor" => 0,
              "CACon_ContratoPor" => "NULL",
              "CACon_tpersona" => "F",
              "CACon_Riesgo" => 0,
              "CACon_Pareja" => "NULL",
              "CACon_ValSegAlMillar" => 0,
              "CACON_HM" => "NULL",
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
              "CACon_SeguroFecNac" => Carbon::now()->format('Y-m-d').'T00:00:00.000',
              "CACon_CliFecNac" => Carbon::now()->format('Y-m-d').'T00:00:00.000',
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
              "CACON_EMPAMORI_NOMINA" => "",
              "CACON_INTMENSUAL" => 0,
              "CACON_HECTAREAS" => 0,
              "CACON_PORCOMISIONAPER" => 0,
              "CACON_ANUALIDAD" => 0,
              "CACON_FECANUALIDAD" => "NULL",
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
              "Cliente_ZT" => "NULL",
              "Ticket_ZT" => "NULL",
              "Distri_ZT" => "NULL"
          ]);

       }
       catch(Throwable $e){
         report($e);
         return false;
       }
    }

    public function PROP(){
      return date("Y-m-15", strtotime(Carbon::now()->format('Y-m-d')."+ 1 month"));
    }

    public function DETALLADO(){
      try{
        DB::table("SCTB_ContratoDet")->insert([
            "CADet_NuCia" => 1,
            //"CADet_foliodet" => ,
            "CADet_docextra" => "",
            "CADet_Print" => 1,
            "CADet_folio" => $folio,
            "CADet_fechagenera" => Carbon::now()->format('Y-m-d').'T00:00:00.000',
            "CADet_contrato" => $vale,
            "CADet_docno" => "PRUEBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA",
            "CADet_descrip" => $vale,
            "CADet_Venci",
            "CADet_Capital",
            "CADet_Amortizar",
            "CADet_MesCurso",
            "CADet_DiasTrans",
            "CADet_DiasReales",
            "CACon_CveTasaVar",
            "CADet_IntTasa",
            "CADet_Tasa",
            "CADet_IntCalculo",
            "CADet_IntOrd",
            "CADet_Seguro",
            "CADet_ImpDocto",
            "CADet_DiasMora",
            "CADet_TasaMora",
            "CADet_IntxMora",
            "CADet_BonifInt",
            "CADet_Abono",
            "CADet_TotalPago",
            "CADet_Saldo",
            "CADet_FechaPago",
            "CADet_ReciboSerie",
            "CADet_Recibo",
            "CARec_cveuni",
            "CADet_Id",
            "CADet_fecham",
            "CADet_CveUni",
            "CADet_IvaInteres",
            "CADet_ShowCV",
            "SELCEL",
            "CADet_Pagointeres",
            "CADet_PagoSeguro",
            "CADet_PagoCapital",
            "CaDet_FactInteres",
            "CaDet_FecFactura",
            "CADet_SaldoCapital",
            "CADet_SaldoInteres",
            "CADet_VenciDocto",
            "CADet_SaldoSeg",
            "CaDet_PAIng",
            "CADet_AbonoCapital",
            "CADet_AbonoSeg",
            "CADet_AbonoInteres",
            "SEL",
            "CADet_IvaMora",
            "CADet_IntEmp",
            "CADet_IntDis",
            "CADet_IntPor",
            "CaDet_Producto",
            "CaDet_Distr",
            "CADet_SeguroAbono",
            "CADet_SeguroSaldo",
            "CADet_Invest",
            "CADet_Admon",
            "CADet_SegAuto",
            "CaDet_Comercio",
            "CADET_Ministracion",
            "CADET_SALDOAFAVOR",
            "cadet_fechanew",
            "Ticket_ZT"
        ]);
      }
      catch(Throwable $e){
        report($e);
        return false;
      }
    }

}