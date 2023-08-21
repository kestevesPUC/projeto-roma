<?php

namespace App\Http\Controllers\DirecionamentoViews;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Colaboradores\Colaboradores;
use App\Models\Perfil\Perfil;
use App\Http\Controllers\Controller;

class AcaoController extends Controller
{
    public function  acaoRenderizacaoPerfil(){
        $perfis = Perfil::all();
        return view('listaPerfilAcesso.index', compact('perfis'));

    }
    public function acaoRenderizacaoUsuario(){

            $colaboradores = Colaboradores::all();
            return view('listaColaboradores.index', compact('colaboradores'));
         
    }

}
