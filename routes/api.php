<?php

use App\Http\Controllers\ActividadeController;
use App\Http\Controllers\AtribuirController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SolicitacoesController;
use App\Http\Controllers\UserController;
use App\Models\Actividade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);
    });
});

Route::get('/sector', [SectorController::class, 'index']);

Route::prefix('user')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {


        Route::get('/meuperfil', [UserController::class, 'meuperfil']);
        Route::get('/visualizarproblema/{id}', [SolicitacoesController::class, 'visualizarProblema']);
        Route::post('resolverproblema/{id}', [SolicitacoesController::class, 'resolverproblema']);
        Route::resource('sectores', SectorController::class);
        Route::post('criarproblema', [SolicitacoesController::class, 'criarproblema']);


        Route::group(['middleware' => 'scope:normal'], function () {


            Route::get('meu_problema', [SolicitacoesController::class, 'meu_problema']);

            Route::delete('cancelarproblema/{id}', [SolicitacoesController::class, 'cancelarProblema']);



        });

        Route::group(['middleware' => 'scope:administrator'], function () {
            //Route::resource('sectores', SectorController::class);
            Route::resource('equipamentos', EquipamentoController::class);

            Route::resource('problemas', SolicitacoesController::class);

            Route::get('/showeq/{id}', [EquipamentoController::class, 'showEquipamento']);
            Route::get('/pesquisarequipamento/{pesquisar}', [EquipamentoController::class, 'pesquisarEquipamento']);
            Route::get('/alocado/{id}', [AtribuirController::class, 'alocado']);


            Route::get('/actividadecontagem', [ActividadeController::class, 'contagem']);
            Route::get('/usuariocontagem', [UserController::class, 'contagem']);
            Route::get('/problemacontagem', [SolicitacoesController::class, 'contagem']);
            Route::get('/equipamentocontagem', [EquipamentoController::class, 'contagem']);
            Route::get('/sectorcontagem', [SectorController::class, 'contagem']);

            Route::get('/usuarios', [UserController::class, 'loadUsers']);
            Route::get('/atualizaruser', [UserController::class, 'atualizarUser']);
            Route::get('/showuser/{id}', [UserController::class, 'showUser']);
            Route::post('/permissao/{id}', [UserController::class, 'permissao']);



            Route::get('/actividade/{id}', [ActividadeController::class, 'showActividade']);
            Route::get('/actividades', [ActividadeController::class, 'visualizarActividades']);
            Route::delete('/removeractividade/{id}', [ActividadeController::class, 'reomoverActividade']);
            Route::post('/atualizaractividade/{id}', [ActividadeController::class, 'atualizarActividade']);
            Route::post('/criaractividade', [ActividadeController::class, 'createActividade']);

        });



    });
});

