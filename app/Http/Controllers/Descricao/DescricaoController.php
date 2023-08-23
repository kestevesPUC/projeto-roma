<?php

namespace App\Http\Controllers\Descricao;

use App\Http\Controllers\Controller;
use App\Models\Descricao\Descricao;
use Illuminate\Support\Arr;

class DescricaoController extends Controller {

    /**
     * Busca no DB todas as descrições existentes
     * @return mixed[]
     */
    public static function getDescricao() {
        return Descricao::query()->select()->get()->toArray();
    }
    /**
     * Busca no DB uma descrição específica de acordo com o id
     * @return mixed[]
     */
    public static function getDescricaoForId($id): string {
        $descricao = Arr::get(Arr::get(Descricao::query()->select()->where('id', $id)->get()->toArray(),0),'descricao');

        return ($descricao != null ? $descricao : '');
    }

    public function insertDescription($descricao) {

    }
}
