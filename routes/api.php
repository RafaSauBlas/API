<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clientes;

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

ROUTE::GET('/clientes/traer', [Clientes::class, 'SHOW', function(Request $request){}]);
ROUTE::POST('/clientes/crear', [Clientes::class, 'Insertar', function(Request $request){}]);
ROUTE::PUT('/clientes/modificar', [Clientes::class, 'Actualizar', function(Request $request){}]);

ROUTE::GET('/clientes/estado', [Clientes::class, 'Estado', function(Request $request){}]);
ROUTE::GET('/clientes/municipio', [Clientes::class, 'Fec', function(Request $request){}]);
ROUTE::GET('/clientes/colonias', [Clientes::class, 'Colonias', function(Request $request){}]);