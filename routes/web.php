<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ponto\PontoController;
use App\Http\Controllers\DirecionamentoViews\AcaoController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\Colaborador\ColaboradoresController;


Route::get('/', function () {
    return view('layouts.app');
})->middleware(['auth', 'verified'])->name('app');

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');

    });


    Route::group(['prefix' => 'controle'], function () {

        // Controle histórico de ponto
        Route::get('/consulta_data/{data_inicio}/{data_fim}', [PontoController::class, 'filtrarDados']);
        Route::get('/ponto_usuario', [PontoController::class, 'index'])->name('ponto_usuario');
        Route::get('/proximaPagina', [PontoController::class, 'proximaPagina'])->name('proximaPagina');

        // Controle de usuários
        Route::get('/cadastro_usuario', [AcaoController::class, 'acaoRenderizacaoUsuario'])->name('cadastro_usuario');
        Route::post('/filtro_usuario', [ColaboradoresController::class, 'filtroUsuario'])->name('filtro_usuario');

        // Controle de perfil de acesso
        Route::get('/cadastro_perfil', [AcaoController::class, 'acaoRenderizacaoPerfil'])->name('cadastro_perfil');
        Route::post('/filtro_perfil', [PerfilController::class, 'filtroPerfil'])->name('consulta_perfil');

    });
    
});

require __DIR__.'/auth.php';
