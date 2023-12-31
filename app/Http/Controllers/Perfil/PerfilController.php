<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Perfil\Perfil;
use Illuminate\Http\Request;

class PerfilController extends Controller {

    public static function getPerfil() {
        return Perfil::query()->select()->get()->toArray();
    }

    public function filtroPerfil(Request $request){

        $nome = $request->input('nome_perfil');
        $status = $request->input('status_perfil');

        $result = Perfil::query()
            ->select();

        if(!empty($nome)){
            $result->where('descricao', 'like', '%' . $nome . '%');
        }
        if(!empty($status != null)){
            $result->where('ativo', $status);
        }
        $retorno = $result->get();

        $retorno->transform(function($item){
            $item->status = $item->ativo === 1 ? 'Ativo' : 'Inativo';
            return $item;
        });

        return response()->json(['dados' => $retorno]);
    }
}
