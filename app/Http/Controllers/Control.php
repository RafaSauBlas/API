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
            $limites = DB::table("Quincenas")->where("idparametro", 2)
                                             ->where("idparametro", 3)->select("clave", "valor")->first();
            return $limites;
        }
        catch(Throwable $e){
          report($e);
          return false;
        }
     }
}
