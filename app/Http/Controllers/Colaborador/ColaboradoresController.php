<?php

namespace App\Http\Controllers\Colaborador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Colaboradores\Colaboradores;

class ColaboradoresController extends Controller
{
    public function filtroUsuario(Request $request)
    {   
        $nome = $request->input('nome_colaborador');
        $cpf =  $request->input('cpf_colaborador');
        $status = $request->input('status_colaborador');

        $result = Colaboradores::query()
            ->select();
            
        if(!empty($nome)) {
            $result->where('name', 'like', '%' . $nome . '%');
        }
        if(!empty($cpf)) {
            $result->where('cpf', 'like', '%' . $cpf . '%');
        }

        if($status != null) {
            $result->where('status', $status);
        }
        $retorno = $result->get();

        $retorno->transform(function($item){
            $item->status = $item->status === 1 ? 'Ativo' : 'Inativo';
            return $item;
        });
        
        return response()->json(['dados' => $retorno]);
    }
}
