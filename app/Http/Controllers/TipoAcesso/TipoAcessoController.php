<?php

namespace App\Http\Controllers\TipoAcesso;

use App\Http\Controllers\Controller;
use App\Models\TipoAcesso\TipoAcesso;

class TipoAcessoController extends Controller {

    /**
     * Busca no DB todos os tipos de acesso existentes
     * @return mixed[]
     */
    public static function getTipoAcessos() {
        return TipoAcesso::query()->select()->get()->toArray();
    }
}
