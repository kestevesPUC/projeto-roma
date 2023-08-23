<?php

namespace App\Http\Controllers\Diretoria;

use App\Http\Controllers\Controller;
use App\Models\Diretoria\Diretoria;

class DiretoriaController extends Controller {

    /**
     * Busca no DB todos os tipos de diretores/gerentes existentes
     * @return mixed[]
     */
    public static function getDiretoria() {
        return Diretoria::query()->select()->get()->toArray();
    }
}
