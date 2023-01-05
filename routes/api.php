<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clientes;
use App\Http\Controllers\ValesDigital;
use App\Http\Controllers\Contratos;
use App\Http\Controllers\Quincenas;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//========== RUTAS ESPECIFICAS PARA CLIENTES ==========
// ROUTE::GET('/clientes/traer', [Clientes::class, 'SHOW', function(Request $request){}]);
// ROUTE::POST('/clientes/crear', [Clientes::class, 'Insertar', function(Request $request){}]);
// ROUTE::POST('/clientes/verificar', [Clientes::class, 'Validar', function(Request $request){}]);
// ROUTE::PUT('/clientes/modificar', [Clientes::class, 'Actualizar', function(Request $request){}]);
//========== RUTAS DE DATOS EXTRA PARA CLIENTES ==========
// ROUTE::GET('/clientes/estado', [Clientes::class, 'Estado', function(Request $request){}]);
// ROUTE::GET('/clientes/Municipio', [Clientes::class, 'Munis', function(Request $request){}]);
// ROUTE::GET('/clientes/colonias', [Clientes::class, 'Colonias', function(Request $request){}]);


//========== RUTAS DE DATOS EXTRA PARA CLIENTES ==========
//API #1 Validar vale
ROUTE::POST('/vales/verifvale', [ValesDigital::class, 'VERIFICAR', function(Request $request){}]);
//API #2 Generar parrilla
ROUTE::GET('/contratos/prueba', [Contratos::class, 'PROP', function(Request $request){}]);
//API #3 Generar pedido y detallado del pedido
ROUTE::GET('/quincenas/detalle', [Quincenas::class, 'SHOW', function(Request $request){}]);