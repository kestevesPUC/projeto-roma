<?php

use App\Http\Controllers\ProfileController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ponto\PontoController;
use App\Http\Controllers\DirecionamentoViews\AcaoController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\Colaborador\ColaboradoresController;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    if (Auth::user()->status)
    {
        return view('header');
    }
    Auth::guard('web')->logout();
    throw \Illuminate\Validation\ValidationException::withMessages([
        'message' => __('Este usuário está desativado!'),
    ]);
    return redirect('/');

})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/getLogo', [ProfileController::class, 'getLogo'])->name('logo');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ProfileController::class, 'updateTipo'])->name('profile.tipo');
    Route::get('/profile/{id}', [ProfileController::class, 'editarUsuarios'])->name('edit-usuarios');
    Route::get('/getPicture/{idUser}', [ProfileController::class, 'getPicture'])->name('profile.get.picture');

    Route::post('/updateImage', [ProfileController::class, 'updateImageProfile'])->name('profile.update-image');
    Route::post('/updateDescricao', [ProfileController::class, 'updateDescricao'])->name('profile.update-descricao');
    Route::post('/updateStatus', [ProfileController::class, 'updateStatus'])->name('profile.update-status');

    });
    Route::group(['prefix' => 'ponto'], function () {
        Route::get('/', [PontoController::class, 'index'])->name('index.ponto');
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


require __DIR__.'/auth.php';
