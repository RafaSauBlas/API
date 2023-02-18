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

class PruebaCon extends Controller
{
    public function SHOW(Request $request){
        $quincena = DB::connection('SirCoEnLinea')->table("ProductsPk")->where("parent_id", "DCK_____43")->select("*")->first();

        return $quincena;
    }
}