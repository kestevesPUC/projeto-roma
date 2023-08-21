<?php

use App\Http\Controllers\ProfileController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ponto\PontoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/', function () {
    if (Auth::user()->status)
    {
        return view('dashboard');
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



    Route::group(['prefix' => 'ponto'], function () {
        Route::get('/', [PontoController::class, 'index'])->name('index.ponto');
        Route::get('/consulta_data/{data_inicio}/{data_fim}', [PontoController::class, 'filtrarDados']);
//        Route::get('/loadGrid', [\App\Http\Controllers\Ponto\PontoController::class, 'loadGrid'])->name('loadGrid');


    });

    Route::group(['prefix' => 'populate'], function () {
        Route::get('/', [\App\Http\Controllers\Ponto\PontoSeniorController::class, 'populate'])->name('index.ponto');

    });
});

require __DIR__.'/auth.php';
