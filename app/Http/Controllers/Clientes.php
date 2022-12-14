<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Nullix\CryptoJsAes\CryptoJsAes;

class Clientes extends Controller
{
    public function SHOW(Request $request){
      $cliente = DB::table('FATB_Clientes')->where('FAnv_Razon', $request->FAnv_Nombres.' '.$request->FAnv_APaterno.' '.$request->FAnv_AMaterno)
                   ->select('FAnv_Nombres', 'FAnv_APaterno', 'FAnv_AMaterno', 'FAnv_FiscalCd', 'FAnv_FiscalColonia', 'FAnv_ApartadoPost', 'FAnv_Calle', 'FAnv_Tel',
                            'FAnv_Cel', 'FAnv_CURP', 'FAnv_RFC', 'FAnv_IFE', 'FAdt_FechaNac')
                   ->get();
      return $cliente;
    }

    public function SHOW1(Request $request){
      $coleccion = DB::select('exec usp_TraerFirmas');
      $arreglo = array();
      $num = 0;
      foreach($coleccion as $cli){
        $arreglo[$num] = $cli->FAim_Firma;
        $num ++;
      }
      $nomo = CryptoJsAes::descrypt('Rafael Saucedo Blas', '250513');
      return $nomo;
    }

    public function Validar(Request $request){
      $cliente = DB::table('FATB_Clientes')
                   ->where('FAnv_Razon', $request->FAnv_Nombres.' '.$request->FAnv_APaterno.' '.$request->FAnv_AMaterno)
                   ->where('FAnv_CURP', $request->FAnv_CURP)
                   ->count();
      if($cliente == 0){
        return self::Insertar($request);
      }
      else{
        return self::Edit($request);
      }
    }

    public function Colonias(Request $request){
      $colonias = DB::table('FATB_CodigosPostales')->where('CP', $request->CP)
                    ->select('Colonia')
                    ->get();
      $colon = array();
      $num = 0;

      foreach($colonias as $col){
        $colon[$num] = $col->Colonia;
        $num ++;
      }
      return $colon;
    }

    public function Munis(Request $request){
      $municipio = DB::table('FATB_CodigosPostales')->where('CP', $request->CP)
                     ->select('Municipio')
                     ->first();
      $mun = "";
      foreach($municipio as $mu){
        $mun = $municipio	->Municipio;
      }
      return $mun;
    }

    public function Edit(Request $request){
      $cli = DB::table('FATB_Clientes')->where('FAnv_Razon', $request->FAnv_Nombres.' '.$request->FAnv_APaterno.' '.$request->FAnv_AMaterno)
               ->where('FAnv_CURP', $request->FAnv_CURP)
               ->select('FAnv_Nombres', 'FAnv_APaterno', 'FAnv_AMaterno', 'FAnv_FiscalCd', 'FAnv_FiscalColonia', 'FAnv_ApartadoPost', 'FAnv_Calle', 'FAnv_Tel',
                        'FAnv_Cel', 'FAnv_CURP', 'FAnv_RFC', 'FAnv_IFE', 'FAdt_FechaNac')
               ->get();
      
      $cliente = $cli[0];

      if($cliente->FAnv_Nombres != $request->FAnv_Nombres || $cliente->FAnv_APaterno != $request->FAnv_APaterno ||
         $cliente->FAnv_AMaterno != $request->FAnv_AMaterno || $cliente->FAnv_FiscalCd != $request->FAnv_FiscalCd ||
         $cliente->FAnv_FiscalColonia != $request->FAnv_FiscalColonia || $cliente->FAnv_ApartadoPost != $request->FAnv_ApartadoPost ||
         $cliente->FAnv_Calle != $request->FAnv_Calle || $cliente->FAnv_Tel != $request->FAnv_Tel || $cliente->FAnv_Cel != $request->FAnv_Cel ||
         $cliente->FAnv_CURP != $request->FAnv_CURP || $cliente->FAnv_RFC != $request->FAnv_RFC || $cliente->FAnv_IFE != $request->FAnv_IFE ||
         $cliente->FAdt_FechaNac != $request->FAdt_FechaNac){
           return self::Actualizar($request);
      }
      else{

      }
    }    

    public function Fec(Request $request){
      return self::Municipio($request->FAnv_ApartadoPost);
    }

    public function Estado($CP){
      $estado = DB::table('FATB_CodigosPostales')->where('CP', $CP)
                  ->select('Estado')
                  ->first();

      $estad = "";

      foreach($estado as $est){
        $estad = $estado->Estado;
      }
      return $estad;
    }

    public function Municipio($CP){
      $municipio = DB::table('FATB_CodigosPostales')->where('CP', $CP)
                     ->select('Municipio')
                     ->first();
      $mun = "";
      foreach($municipio as $mu){
        $mun = $municipio->Municipio;
      }
      return $mun;
    }

    public function Insertar(Request $request){
      DB::table('FATB_Clientes')->insert([
          'FAin_NuCia' => 1,
          'FAdt_FechaAlta' => Carbon::now()->format('Y-m-d').'T00:00:00.000',
          'FAnv_Razon' => $request->FAnv_Nombres.' '.$request->FAnv_APaterno.' '.$request->FAnv_AMaterno,
          'FAnv_Abreviado' => '',
          'FAnv_Cd' => self::Municipio($request->FAnv_ApartadoPost),
          'FAnv_FiscalCd' => self::Municipio($request->FAnv_ApartadoPost),
          'FAnv_FiscalColonia' => $request->FAnv_FiscalColonia,
          'FAin_FiscalCP' => $request->FAnv_ApartadoPost,
          'FAnv_ApartadoPost' => $request->FAnv_ApartadoPost,
          'FAnv_DirFiscal' => $request->FAnv_Calle,
          'FAnv_Calle' => $request->FAnv_Calle,
          'FAnv_ProdFinan' => '',
          'FAbt_UTCueProp' => 0,
          'FAnv_PorCuenta' => '',
          'FAnv_CuentaPropia' => '',
          'FAnv_AntiguedadDom' => '',
          'FAbt_UTCueTerc' => 0,
          'FAnv_NoInt' => '',
          'FAnv_NoExt' => '',
          'FAnv_Tel' => $request->FAnv_Tel,
          'FAnv_Cel' => $request->FAnv_Cel,
          'FAnv_Fax' => '',
          'FAnv_TipoFM' => '',
          'FAnv_RFC' => $request->FAnv_RFC,
          'FAnv_CURP' => $request->FAnv_CURP,
          'FAin_Grupo' => 0,
          'FAnv_Email' => '',
          'FAnv_Contacto' => '',
          'FAnv_ContactoExt' => '',
          'FAnv_CobraCd' => '',
          'FAnv_CobraCol' => '',
          'FAin_CobraCP' => 0,
          'FAnv_CobraDir' => '',
          'FAnv_CobraPersona' => '',
          'FAnv_CobraTel' => '',
          'FAnv_CobraExtTel' => '',
          'FAnv_CobraEMail' => '',
          'FAtx_Observa' => '',
          'FAbt_Transferencia' => 0,
          'FAnv_TransRefer' => '',
          'FAnv_TransBanco' => '',
          'FAbt_SuspenFactura' => 0,
          'FAbt_RetenEntrega' => 0,
          'FAdc_CreMonto' => 0,
          'FAin_CreDias' => 0,
          'FAnv_CreDiaRev' => '',
          'FAnv_CreDiaRevde' => '',
          'FAnv_CreDiaRevalas' => '',
          'FAnv_CreDiaPag' => '',
          'FAnv_CreDiaPagde' => '',
          'FAnv_CreDiaPagalas' => '',
          'FAbt_EnvioEdoCta' => 0,
          'FAdc_DesctoContado' => 0,
          'FAnv_preciosugerido' => 0,
          'FAnv_Id' => '',
          'FAdt_Fecha' => Carbon::now()->format('Y-m-d').'T00:00:00.000',
          'FAin_Agente' => '',
          'FAnv_PrecioSug' => '',
          'FAnv_NoContrato' => '',
          'FAnv_Municipio' => self::Municipio($request->FAnv_ApartadoPost),
          'FAnv_Estado' => self::Estado($request->FAnv_ApartadoPost),
          'FAnv_APaterno' => $request->FAnv_APaterno,
          'FAnv_AMaterno' => $request->FAnv_AMaterno,
          'FAnv_Nombres' => $request->FAnv_Nombres,
          'FAnv_CveUni' => '',
          'FAim_Foto' => Null,
          'FAim_huella' => Null,
          'FAim_huella2' =>  Null,
          'FAnv_IFE' => $request->FAnv_IFE,
          'FAbt_ListaNegra' => 0,
          'FAdt_FechaNac' => $request->FAdt_FechaNac,
          'FAnv_Nacionalidad' => '',
          'FAnv_EntFedera' => '',
          'FAnv_Pais' => '',
          'FAnv_ActEcono' => '',
          'FAnv_Estudios' => '',
          'FAnv_RolHogar' => '',
          'FAnv_TipoCredito' => '',
          'FAnv_UbicaNEg' => '',
          'FAin_NoPersonas' => 0,
          'FAdt_FecIniAct' => Carbon::now()->format('Y-m-d'),
          'FAnv_Actividad' => '',
          'FAnv_DestinoCred' => '',
          'FAdc_MontoMens' => 0,
          'FAin_NumPagos' => 0,
          'FAnv_ForPago1' => '',
          'FAnv_ForPago2' => '',
          'FAnv_ForPago3' => '',
          'FAnv_Moneda' => '',
          'FAnv_Encuesta1' => 'N',
          'FAnv_Encuesta2' => 'N',
          'FAnv_Encuesta3' => 'N',
          'FAnv_Encuesta4' => 'N',
          'FAnv_Encuesta5' => 'N',
          'FAnv_Encuesta6' => 'N',
          'FAnv_Encuesta7' => 'N',
          'FAnv_Encuesta8' => 'N',
          'FAnv_Encuesta9' => 'N',
          'FAnv_Encuesta10' => 'N',
          'FAnv_Encuesta11' => 'N',
          'FAin_EncuestaVul' => 0,
          'FAnv_EncuestaTotal' => 0,
          'FAnv_RepLegAPat' => '',
          'FAnv_RepLegAMat' => '',
          'FAnv_RepLegNomb' => '',
          'FAnv_RepLegCarPub' => '',
          'FAnv_RepLegConyuge' => '',
          'FAnv_RepLegDireccion' => '',
          'FAnv_RepLegCiudad' => '',
          'FAnv_RepLegTelefonos' => '',
          'FAnv_RepLegRFC' => '',
          'FAnv_RepLegPLD' => 0,
          'FAnv_FuncAPat' => '',
          'FAnv_FuncAMat' => '',
          'FAnv_FuncNomb' => '',
          'FAnv_FuncPuesto' => '',
          'FAnv_Sexo' => '',
          'FAnv_EdoCivil' => '',
          'FAbt_PLD' => 0,
          'FAbt_PLDPEP' => 0,
          'FAbt_PLDInter' => 0,
          'FAbt_PLDBloqueada' => 0,
          'FAbt_PLDPGR' => 0,
          'FAbt_Circulo' => 0,
          'FAbt_Oculto' => 0,
          'FAnv_PContrato' => '',
          'FAdt_PFecContrato' => Carbon::now()->format('Y-m-d'),
          'FAin_PActEconomica' => 0,
          'FAdc_PMonto' => 0,
          'FAin_PTipoCredito' => '',
          'FAdc_PPagoPeriodico' => 0,
          'FAin_PNumPagos' => 0,
          'FAdc_PMontoMaximo' => 0,
          'FAnv_PFormaPago' => '',
          'FAnv_PFrecuenciaPAgo' => '',
          'FAnv_PNaturaleza' => '',
          'FAnv_PCuentaOrigen' => '',
          'FAnv_PCuentaOrigen2' => '',
          'FAnv_POrigenRecursos' => '',
          'FAnv_PDestino' => '',
          'FAbt_PDestinoCorrecto' => 0,
          'FAbt_PColaboraAlterado' => 0,
          'FAnv_POtraInfo' => '',
          'FAdt_PFecElabora' => Carbon::now()->format('Y-m-d'),
          'FAnv_PElabora' => '',
          'FAnv_PaisDom' => '',
          'FAdc_IngMensual' => 0,
          'FAnv_Profesion' => '',
          'FAnv_Empleo' => '',
          'FAnv_EmpDir' => '',
          'FAnv_EmpColonia' => '',
          'FAnv_EmpCP' => 0,
          'FAnv_EmpMunicipio' => '',
          'FAnv_EmpCiudad' => '',
          'FAnv_EmpEstado' => '',
          'FAnv_Empresa' => '',
          'FAbt_ClienteRecursos' => 0,
          'FAbt_Instalaciones' => 0,
          'FAnv_EmpPuesto' => '',
          'FAnv_EmpTel' => '',
          'FAin_EmpCP' => 0,
          'FAnv_EmpDireccion' => '',
          'FAnv_EmpCd' => '',
          'FAnv_EmpCol' => '',
          'FAin_UsuaAgente' => '',
          'FAnv_EmpExtTel' => '',
          'FOnv_TipoAsentamiento' => '',
          'FOnv_Vialidad' => '',
          'FOnv_TipoTasa' => '',
          'FOnv_metodologia' => '',
          'FOnv_SOLI_CREDITO' => '',
          'FOnv_PREGUNTA_INGRESO' => '',
          'FOnv_LenguaIndigena' => '',
          'FOnv_Discapacidad' => '',
          'FOnv_Internet' => '',
          'FOnv_Redes' => '',
          'FOnv_Prospera' => '',
          'FOnv_PerTraba' => 0,
          'FOTB_LocalidadFommur' => '',
          'FOTB_MpoFommur' => '',
          'FAnv_ClienteMicrosip' => 0,
          'FAdt_FecNac' => $request->FAdt_FechaNac,
          'FANV_BANCONOMINA' => '',
          'FANV_NCUENTANOMINA' => '',
          'FAim_IfeF' => Null,
          'FAim_IfeR' => Null,
          'FABo_BuroInterno' => 0,
          'Ruta_IFEFrente' => '',
          'Ruta_IFEAtras' => '',
          'Ruta_Comprobante' => '',
          'Ruta_Vale' => '',
          'FAdc_IdDistrib' => 0,
          'FAnv_EmpAntiguedad' => '',
          'FAdc_Longitud' => '',
          'FAdc_Latitud' => '',
          'FANV_BancoDeposito' => '',
          'FANV_BancoNoCuenta' => '',
          'FAbt_CanjeLinea' => 0,
          'FAdc_IdZT'=> 0,
        ]);
      return "Cliente registrado correctamente.";
    }

    public function Actualizar(Request $request){
      $update = DB::table('FATB_Clientes')
                  ->where('FAnv_Razon', $request->FAnv_Nombres.' '.$request->FAnv_APaterno.' '.$request->FAnv_AMaterno)
                  ->where('FAnv_CURP', $request->FAnv_CURP)
                  ->update([
                      'FAnv_Razon' => $request->FAnv_Nombres.' '.$request->FAnv_APaterno.' '.$request->FAnv_AMaterno,
                      'FAnv_Cd' => self::Municipio($request->FAnv_ApartadoPost),
                      'FAnv_FiscalCd' => self::Municipio($request->FAnv_ApartadoPost),
                      'FAnv_FiscalColonia' => $request->FAnv_FiscalColonia,
                      'FAin_FiscalCP' => $request->FAnv_ApartadoPost,
                      'FAnv_ApartadoPost' => $request->FAnv_ApartadoPost,
                      'FAnv_DirFiscal' => $request->FAnv_Calle,
                      'FAnv_Calle' => $request->FAnv_Calle,
                      'FAnv_Tel' => $request->FAnv_Tel,
                      'FAnv_Cel' => $request->FAnv_Cel,
                      'FAnv_RFC' => $request->FAnv_RFC,
                      'FAnv_CURP' => $request->FAnv_CURP,
                      'FAdt_Fecha' => Carbon::now()->format('Y-m-d').'T00:00:00.000',
                      'FAnv_Municipio' => self::Municipio($request->FAnv_ApartadoPost),
                      'FAnv_Estado' => self::Estado($request->FAnv_ApartadoPost),
                      'FAnv_APaterno' => $request->FAnv_APaterno,
                      'FAnv_AMaterno' => $request->FAnv_AMaterno,
                      'FAnv_Nombres' => $request->FAnv_Nombres,
                      'FAnv_IFE' => $request->FAnv_IFE,
                      'FAdt_FechaNac' => $request->FAdt_FechaNac,
                      'FAdt_Fecnac' => $request->FAdt_FechaNac
                  ]);
      return "Cliente actualizado correctamente.";
    }

}
